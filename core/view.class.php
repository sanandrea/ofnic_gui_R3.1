<?php

if (!defined('OFNIC')) die('Direct access not allowed!');

/**
 * View class file.
 */

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

Class view {
    /**
     * Name of the view
     *
     * @access private
     */
    private $name = '';

	/**
     * Template of the view
     *
     * @access private
     */
    private $template = '';

    /**
     * StdClass $this reference
     *
     * @access private
     */
    private static $singleton = null;

    /**
     * Variables array
     *
     * @access private
     */
    private $data = array();

	/**
     * Modules array
     *
     * @access private
     */
    private $modules = array();


    /**
     * Title used to label the page
     *
     * @access private
     */
    private $title = '';

    /**
     * Description used to label the page
     *
     * @access private
     */
    private $description = '';

    /**
     * Keywords used to label the page
     *
     * @access private
     */
    private $keywords = '';

    /**
     * Particular CSS style to apply to the page
     *
     * @access private
     */
    private $css = '';

    /**
     * Particular JS file to load with the page
     *
     * @access private
     */
    private $js = '';

    /**
     * Constructor, we avoid external instantiation of this class
     * @param string $name the name of the view
     *
     * @return void
     */
    public function __construct($name, $tpl) {
        $this -> name = $name;
		$this -> template = $tpl;
    }

    /**
     * The main destructor erases singleton object
     *
     * @return void
     */
    public function __destruct() {
        self::$singleton = null;
    }

    /**
     * __clone private so nobody can clone the instance
     *
     * @access private
     */
    private function __clone() {
    }

    /**
     *
     * Return View instance
     *
     * @return View object
     *
     * @access public
     */
    public static function getInstance() {
        if (!self::$singleton) {
            self::$singleton = new View();
        }

        return self::$singleton;
    }

    /**
     *
     * Assigns data by index
     *
     * @param string $index
     *
     * @param mixed $value
     *
     * @return void
     *
     */
    public function assign($index, $value) {
        $this -> data[$index] = $value;
    }

    /**
     * Renders the view
     *
     * @param string $type type of the required output (html / json)
     * @param boolean $return whether to return the content instead of showing it
     *
     * @return mixed It returns the rendered code or it shows the view
     *
     */
    public function render($return = true) {

        $path = __ROOT_PATH . '/views' . '/' . $this -> name . '/' . $this -> template . '.php';
        $buffer = '';
        $start = microtime(TRUE);

        if (file_exists($path) == FALSE) {

            $exception = new Exception();

            Logger::error('View not found in ' . $path . ' >> ' . $exception);

            return FALSE;
        }

        // Load variables
      	extract($this->data);

        // start output buffering
        ob_start();

        include ($path);

        $html = ob_get_clean();
        //
        Logger::checkpoint('Total to execute queries');

        Logger::addLog('Loading view ' . $this -> name . ' , template ' . $this->template);

        if ($return) {
            return $html;
        }

        // otherwise
        echo $html;

    }
	
	
	 public static function do_render($view = '', $tpl = '', $data = array(), $return = true) {

        $path = __ROOT_PATH . '/views' . '/' . $view . '/' . $tpl . '.php';
        $buffer = '';
        $start = microtime(TRUE);

        if (file_exists($path) == FALSE) {

            $exception = new Exception();

            Logger::error('View not found in ' . $path . ' >> ' . $exception);

            return FALSE;
        }

        // Load variables
      	extract($data);

        // start output buffering
        ob_start();

        include ($path);

        $html = ob_get_clean();
        //
        Logger::checkpoint('Total to execute queries');

        Logger::addLog('Loading view ' . $this -> name . ' , format ' . $type);

        if ($return) {
            return $html;
        }

        // otherwise
        echo $html;

    }
	

    /**
     * Shows the view
     * @param string $type type of the required output (html / json)
     * @return void
     */
    public function show() {
        return $this -> render(false);
    }
    
     /**
     * Shows a complete page, including header and body contents
     * @param array $settings header settings
     * @return void
     */
    public function page($settings = array()) {
        // overwrite attributes with settings, if available
        $title = isset($settings['title']) ? $settings['title'] : $this -> title;
        $description = isset($settings['description']) ? $settings['description'] : $this -> description;
        $keywords = isset($settings['keywords']) ? $settings['keywords'] : $this -> keywords;
		$modules = isset($settings['modules']) ? $settings['modules'] : $this -> modules;

        $content = $this -> render($this -> template);
		
        $path = __ROOT_PATH . '/views' . '/' . 'layout.php';

        ob_start();

        include ($path);

        $html = ob_get_clean();

        echo $html;

        Logger::checkpoint('Total to load views');
    }

}
?>
