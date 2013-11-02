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
 * @created 03/11/2014
 */

if (!defined('OFNIC')) die('Direct access not allowed!');

class UserModel extends Model {
	
	
    /**
     * Constructor, use it to load the database interface
     *
     * @return void
     *
     * @access public
     */
    public function __construct($id = '') {
        

        // if it was not autoloaded...
        if (!$this -> db) {
            $this -> db = Db::getInstance();
        }

	   $this->data['username'] = '';
	   $this->data['password'] = '';
	   
	   parent::__construct($id);
	   
    }

    /**
     * Gets all Users from database
     *
     * @return array of fevs
     *
     * @access public
     */
    public static function getAll() {
        $db = Db::getInstance();
        $res = $db -> readPDO('SELECT * FROM ' . $this -> table);
        $ret = array();

        foreach ($res as $r) {
            $user = new UserModel();
            $user -> load($r);
            $ret[] = $user;
        }

        return $ret;
    }
    
     /**
     *
     * Remove from the database
     * @access public
     */
    
    public function remove(){
         
        return $this->delete();        
    }
    
}
?>
