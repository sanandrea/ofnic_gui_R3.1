<?php

if (!defined('OFNIC')) die('Direct access not allowed!');

/**
 * Controller class file
 */

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

abstract Class controller {

    /**
     * Action to be performed
     *
     * @access protected
     */
    protected $action;
    /**
     * The expected format (json or html)
     *
     * @access protected
     */
    protected $format;

    /**
     * The default controller action
     * It must be overridden by each child class
     * @return void
     * @access public
     */
    abstract public function index();

    /**
     * Contructor
     * @access public
     * @return void
     */
    public function __construct() {
        Logger::addLog('Loading controller ' . get_class($this));
    }

}
?>
