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
if (!defined('OFNIC'))
	die('Direct access not allowed!');

/**
 * OFNIC Main Web Site Controller class file
 */


Class MainController Extends Controller {

	/**
	 * Constructor, we avoid external instantiation of this class
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Main index, no action
	 *
	 * @access public
	 *
	 * @see core/controller.class#index()
	 *
	 * @return void
	 */
	public function index() {
		$view = new View('main', 'index.html');
		$view -> assign('content', 'Main page');
		
		$modules['navbar'][] = '<a href="#" class="brand">OFNIC</a>';
		$modules['navbar'][] = '<ul class="nav"><li class="active"><a href="./home.html">Synchronize</a></li></ul>';
		$modules['navbar'][] = '<ul class="nav"><li class="active"><a href="./home.html">Statistics</a></li></ul>';
		$modules['navbar'][] = '<ul class="nav"><li class="active"><a href="./home.html">Routing</a></li></ul>';
		
		$view -> page(array('title' => 'Main', 'modules' => $modules));
	}

	public function showLogin(){
		$view = new View('login','login.html');
		$modules['login'] = TRUE;
		$view -> page(array('title' => 'Login', 'modules' => $modules));
	}

	
	
}
?>
