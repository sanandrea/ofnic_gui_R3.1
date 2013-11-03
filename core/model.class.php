<?php

if (!defined('OFNIC'))
	die('Direct access not allowed!');

/**
 * Model class file
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

abstract Class model {
	/**
	 * Database object
	 *
	 * @access protected
	 *
	 */
	protected $db = null;

	/**
	 * Table name for this model
	 *
	 * @access protected
	 *
	 */
	protected $table = '';

	/**
	 * Id field for this model
	 *
	 * @access protected
	 *
	 */
	protected $idname = '';

	/**
	 * Table fields for this model
	 *
	 * @access protected
	 *
	 */
	protected static $fields = array();

	/**
	 * Associative array of data for this model
	 *
	 * @access protected
	 *
	 */
	protected $data = array();

	/**
	 * Contructor
	 * @access public
	 * @return void
	 */
	public function __construct($id = '') {
		$idname = $this->idname;
		$this->$idname = $id;
		Logger::addLog('Loading model ' . get_class($this));
	}

	/**
	 *  PHP5 __get magic method
	 * @param string $key
	 * @access public
	 * @return object
	 */

	public function __get($key) {
		return $this -> data[$key];
	}

	/**
	 *  PHP5 __set magic method
	 * @param string $key
	 * @param string $value
	 * @access public
	 * @return void
	 */
	public function __set($key, $value) {
		if (isset($this -> data[$key]))
			$this -> data[$key] = $value;
	}
	
	
	/*
	 * Crea nuova istanza nel DB con gli attributi presenti in $data
	 */

	public function create() {
		$idname = $this -> idname;
		$keys = $values = '';
		$bindings = array();
		foreach ($this->data as $k => $v)
			if ($k != $idname || $v) {
				$keys .= ',' . $k;
				$values .= ',?';
				$bindings[] = $v;
			}

		$sql = 'INSERT INTO ' . $this -> table . ' (' . substr($keys, 1) . ') VALUES (' . substr($values, 1) . ')';
		if ($this -> db -> writePDO($sql, $bindings)){
			$this -> $idname = $this -> db -> lastInsertId();
			return true;
		}
		else
			return FALSE;
	}
	
	/**
	 *
	 * Recupera istanza dal DB
	 * Popola array $data
	 * @param integer $id
	 *
	 * @access public
	 */
	public function retrieve() {
		$idname = $this -> idname;
		$idvalue = $this->$idname;
		
		if(empty($idvalue))
			return FALSE;
		
		$values = $this -> db -> readPDO('SELECT * FROM ' . $this -> table . ' WHERE ' . $this -> idname . ' = ?', $idvalue, true);
		if ($values)
			$this -> data = $values;
	}
	/*
	 * Aggiorna istanza nel DB
	 * Se viene passato array di attributi, aggiorna solo gli attributi indicati
	 * altrimenti aggiorna tutti quelli presenti in $data
	 */
	
	
	public function update($values = array()) {
		$idname = $this -> idname;
		$idvalue = $this->$idname;
		if(empty($this->$idname))
			return FALSE;
		
		$keys = '';
		$bindings = array();
		
		$val = empty($values) ? $this->data : $values;
		
		foreach ($val as $k => $v)
			if ($k != $idname) {
				$keys .= ',' . $k.'=?';
				$bindings[] = $v;
			}

		$sql = 'UPDATE ' . $this -> table . ' SET ' . substr($keys, 1) . ' WHERE ' . $idname  . ' = ' . $idvalue;
		return $this -> db -> writePDO($sql, $bindings);
	}

	

	/**
	 * Rimuove istanza dal DB
	 */
	public function delete() {
		$idname = $this -> idname;
		$idvalue = $this->$idname;
		if (empty($idvalue))
			return FALSE;
		return $this -> db -> writePDO('DELETE FROM ' . $this -> table . ' WHERE ' . $idname . ' = ?', $idvalue);
		
	}
	
	public function select($what = '*' , $where = '', $bindings='', $order = ''){
		$sql = 'SELECT '.$what.' FROM '.$this->table;
		 if ($where)
      		$sql .= ' WHERE '.$where;
		 
		 if ($order)
      		$sql .= ' ORDER BY '.$order;
		 
		 $sql .= ' LIMIT 1';
		 
		$values = $this -> db -> readPDO($sql, $bindings, true);
		
		if ($values)
			$this -> data = $values;
	}


	public function select_many($what = '*' , $where = '', $bindings='', $order = '', $limit = ''){
		$sql = 'SELECT '.$what.' FROM '.$this->table;
		 if ($where)
      		$sql .= ' WHERE '.$where;
		 
		 if ($order)
      		$sql .= ' ORDER BY '.$order;
		 
		 if ($limit)
      		$sql .= ' LIMIT '.$limit;
		 
		 $arr=array();
   		 $class=get_class($this);
   	
		$res = $this -> db -> readPDO($sql, $bindings, false);
		foreach ($res as $r){
	 	 $myclass = new $class();
         $myclass->data = $r;
		 $arr[]=$myclass;
   		 }
		
    return $arr;
	}

	/**
	 *
	 * Return data
	 * @access public
	 */

	public function data() {
		return $this -> data;
	}
	
	public function setData($d) {
		$this -> data = $d;
	}
	

	public function dump() {
		$res = $this -> data;
		foreach ($res as $id => $item) {
			if ($item instanceof model)
				$res[$id] = $item -> dump();
		}
		return $res;
	}

}
?>
