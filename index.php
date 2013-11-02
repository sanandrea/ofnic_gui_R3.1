<?php

  /**
    * Copyright 2013 (C) Universita' di Roma La Sapienza
    *
    * This file is part of OFNIC Uniroma GE.
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

/* Macro to prevent direct access */   
define('OFNIC', 1);

include 'include.php';
include 'accesscontrol.php';

// Session to maintain current timeslot	 

// Load defaults
$controller = (isset($_GET['c'])) ? $_GET['c'] : 'Main';
$action = (isset($_GET['a'])) ? $_GET['a'] : 'index';
$format = (isset($_GET['f'])) ? $_GET['f'] : 'index.html';
$logger = (isset($_GET['l'])) ? $_GET['l'] : 0;

$class = $controller . 'Controller';
$path = __ROOT_PATH . '/controllers/' . $class . '.php';

if (file_exists($path)) {

	$controller = new $class();

	if (is_callable(array($controller, $action), false)) {

		#if (!hasDoneLogin()) {
        if (TRUE) {
			$controller -> showLogin();
		}else{
		    $controller -> $action($format);
		    Logger::setController($class);
		    Logger::setAction($action);
        }
	} else {
		Logger::error('Wrong action "' . $action . '"!');
	}
} else {
	Logger::error('Wrong controller "' . $class . '"!');
}

if($logger)
    Logger::show();

function hasDoneLogin() {

    session_start();

    if (isset($_POST['uid'])) {
        $uid = $_POST['uid'];
    } else {
        $uid = $_SESSION['uid'];
    }
    if (isset($_POST['pwd'])) {
        $pwd = $_POST['pwd'];
    } else {
        $pwd = $_SESSION['pwd'];
    }
    if(!isset($uid)) {
        return FALSE;
    } else {
        return TRUE;
    }

}
?>
