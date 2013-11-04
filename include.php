<?php
    /**
    * Copyright 2013 (C) Universita' di Roma La Sapienza
    *
    * This file is part of OFNIC Uniroma GEi
    *
    * OFNIC is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
    *
    * OFNIC is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
    *
    * You should have received a copy of the GNU General Public License
    * along with OFNIC.  If not, see <http://www.gnu.org/licenses/>.
    *
	* @author Andi Palo
 	* @created 02/11/2014
    */
     
    ini_set('error_reporting', 2147483647);
    ini_set('display_errors', 'on');

    // define the site paths
    $site_path = realpath(dirname(__FILE__));
    define('__ROOT_PATH', $site_path);

    // for profiling and debugging purposes
    define('TIME_START', microtime(true));

    // algorithm settings
    include __ROOT_PATH . '/config/settings.php';
    // helper functions
    include __ROOT_PATH . '/helpers/base.php';

/**
 * System function (available in PHP 5) which is called whenever the code tries 
 * to use a class that has not yet been defined.
 * 
 * @param string $classname name of the class to load
 * @return boolean
 */
    function __autoload($classname) {
        $paths = array();

        if (endsWith($classname, 'model')) {
            $paths[] = __ROOT_PATH . '/models/' . $classname . '.php';
        }
        if (endsWith($classname, 'view')) {
            $paths[] = __ROOT_PATH . '/views/' . $classname . '.php';

        }
        if (endsWith($classname, 'controller')) {
            $paths[] = __ROOT_PATH . '/controllers/' . $classname . '.php';
        }

        $paths[] = __ROOT_PATH . '/core/' . strtolower($classname) . '.class.php';

        foreach ($paths as $path) {
            if (file_exists($path)) {
                include $path;
                return true;
            }
        }

        // not found, halt
        throw new Exception('File class not found for ' . $classname);
        return FALSE;
    }
?>