<?php

if (!defined('OFNIC'))
	die('Direct access not allowed!');

/**
 * This file implements the database class
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
Class db {
	/**
	 * StdClass $this reference
	 *
	 * @access private
	 */
	private static $singleton = null;

	/**
	 * Database connection link
	 *
	 * @access private
	 */
	private $link = null;

	/**
	 * Database user
	 *
	 * @access private
	 */
	private $user = null;

	/**
	 * Database password
	 *
	 * @access private
	 */
	private $pass = null;

	/**
	 * Database to use
	 *
	 * @access private
	 */
	private $base = null;

	/**
	 * Database host
	 *
	 * @access private
	 */
	private $host = null;

	/**
	 * Allows easy switching between mysql and pdo modes, for
	 * 	backwards compatiiblity's sake
	 *
	 * @access private
	 */
	private $pdo = true;

	/**
	 * Shows or hides SQL errors (for production environments)
	 * 	This setting is got from the database config file
	 *
	 * @access private
	 */
	private $errors = false;

	/**
	 * Enable logger ()
	 * 	This setting is got from the database config file
	 *
	 * @access private
	 */
	private $logger = false;

	/**
	 * Register to keep the last executed query
	 *
	 * @access private
	 */
	private $lastQuery = '';

	/**
	 * Constructor, initializes the connection and sets the singleton pattern
	 *
	 * @return void
	 */
	private function __construct() {
		$conf = array();
		
		// Cerchiamo di capire se siamo in ambiente windows-based "\" oppure linux-based "/"
		$win_dir_root = substr(dirname(__FILE__),0,strrpos(dirname(__FILE__),"\\"));
		$lin_dir_root = substr(dirname(__FILE__),0,strrpos(dirname(__FILE__),"/"));
		
		// di default ipotizziamo di essere in ambiente linux...
		$dir_root = $lin_dir_root;
		$slash = '/';
		
		if (is_dir($win_dir_root))
		{
		    // siamo in ambiente windows
		    $dir_root = $win_dir_root;
		    $slash = '\\';
		}

		$file = __ROOT_PATH .$slash.'config'.$slash.'config.php';
		
		echo $file .'<br/>';

		if (!file_exists($file)) {
			return false;
		}

		require ($file);

		// check format
		if (!isset($conf) OR !is_array($conf)) {
			$conf = array();
		}

		echo '$config[dbuser] = ' .$config['dbuser']. '<br/>';
		$this -> user = $config['dbuser'];
		$this -> pass = $config['dbpass'];
		$this -> base = $config['dbname'];
		$this -> host = $config['dbhost'];
		$this -> errors = $config['dberrors'];
		$this -> logger = $config['enable_log'];

		if ($this -> pdo) {
			$this -> connectPdo();
		} else {
			$this -> connectMysql();
		}
	}

	/**
	 * The main destructor closes database connection
	 * 	and initializes the DB singleton object
	 *
	 * @return void
	 */
	public function __destruct() {
		if (!is_null($this -> link)) {
			if (!$this -> pdo) {
				mysql_close($this -> link);
			}

			$this -> link = null;
			self::$singleton = null;
		}
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
	 * Return DB instance or create intitial connection
	 *
	 * @return Db object
	 *
	 * @access public
	 */
	public static function getInstance() {
		if (!self::$singleton) {
			self::$singleton = new Db();
		}

		return self::$singleton;
	}

	/**
	 * Creates a Mysql connection with old driver (faster)
	 *
	 * @return void
	 */
	private function connectMysql() {
		if (!($tmp = mysql_connect($this -> host, $this -> user, $this -> pass))) {
			if ($this -> logger) {
				Logger::sqlError(mysql_error());
				return;
			} else {
				throw new Exception('Connection impossible : ' . mysql_error());
			}
		}

		$this -> link = &$tmp;

		// Select the db
		if (!mysql_select_db($this -> base, $this -> link)) {
			if ($this -> logger) {
				Logger::sqlError(mysql_error($this -> link));
				return;
			} else {
				throw new Exception('Impossible to select the database : ' . mysql_error($this -> link));
			}
		}
	}

	/**
	 * Creates a PDO Mysql connection (slower but more powerful)
	 *
	 * @return void
	 *
	 * @access private
	 */
	private function connectPdo() {
		$this -> link = new PDO('mysql:host=' . $this -> host . ';dbname=' . $this -> base, $this -> user, $this -> pass);
		$this -> link -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * Sets PDO mode
	 *
	 * @return void
	 *
	 * @access public
	 */
	public function setPdo() {
		$this -> pdo = true;

		$this -> connectPdo();
	}

	/**
	 * Unsets PDO mode
	 *
	 * @return void
	 *
	 * @access public
	 */
	public function unsetPdo() {
		$this -> pdo = false;

		$this -> connectMysql();
	}

	/**
	 * Select Queries, return an array with all results
	 *
	 * @param string $req
	 *
	 * @return mixed array with results
	 *
	 * @access public
	 */
	public function read($req = '') {
		// vars
		$start = microtime(true);
		$return = null;

		$this -> lastQuery = $req;

		if ($this -> pdo) {
			$out = $this -> link -> query($req);
			$return = $out -> fetchAll();

			if ($this -> logger) {
				Logger::query($req, $start);
			} else {
				throw new Exception('Invalid query: ' . $req);
			}

			return $out -> fetchAll();
		} else {
			$rows = mysql_query($req, $this -> link);

			if (!$rows && $this -> errors) {

				if ($this -> logger) {
					Logger::sqlError($req);
				} else {
					throw new Exception('Invalid query: ' . $req);
				}

			}

			$out = array();

			if ($rows) {
				while ($row = mysql_fetch_array($rows, MYSQL_ASSOC)) {
					$out[] = $row;
				}
			}

			if ($this -> logger) {
				Logger::query($req, $start);
			}

			return $out;
		}

	}

	public function readPDO($sql = '', $bindings = '', $one = FALSE) {

		
		if (!$this -> pdo)
			return FALSE;

		try {

			$stmt = $this -> link -> prepare($sql);

			if (is_scalar($bindings))
				$bindings = trim($bindings) ? array($bindings) : array();
			
			$res = $stmt -> execute($bindings);
			$query = $stmt -> queryString;
			$this -> lastQuery = $query;
			if ($this -> logger) {
				$start = microtime(true);
				Logger::query($query. ' Values: [' . implode($bindings, " : ") . ']', $start);
			}
			
			return ($one) ? $stmt -> fetch(PDO::FETCH_ASSOC) : $stmt -> fetchAll(PDO::FETCH_ASSOC);
			
		} catch( PDOException $Exception ) {

			if ($this -> logger) {
				Logger::sqlError($Exception -> getMessage());
			}
			return FALSE;
		}

	}

	public function writePDO($sql = '', $bindings = '') {
		
		if (!$this -> pdo)
			return FALSE;

		try {
	
		$stmt = $this -> link -> prepare($sql);
	
		if (is_scalar($bindings))
			$bindings = trim($bindings) ? array($bindings) : array();

		$res = $stmt -> execute($bindings);
		$query = $stmt -> queryString;
		$this -> lastQuery = $query;
		if ($this -> logger) {
				$start = microtime(true);
				Logger::query($query. ' Values: [' . implode($bindings, " : ") . ']', $start);
		
		}

		return $res;
		
		} catch( PDOException $Exception ) {

			if ($this -> logger) {
				Logger::sqlError($Exception -> getMessage());
			}
			return FALSE;
		}
	}

	/**
	 * Insert and Update queries, return numbers of affected rows
	 *
	 * @param string $req
	 *
	 * @return int number of affected rows
	 *
	 * @access public
	 */
	public function write($req = '') {
		$start = microtime(true);

		$this -> lastQuery = $req;

		if ($this -> pdo) {
			$out = $this -> link -> query($req);

			if ($this -> logger) {
				Logger::query($req, $start);
			} else {
				throw new Exception('Invalid query: ' . $req);
			}

			return $out -> rowCount();
		} else {
			$rows = mysql_query($req, $this -> link);

			if (!$rows && $this -> errors) {

				if ($this -> logger) {
					Logger::sqlError($req);
				} else {
					throw new Exception('Invalid query: ' . $req);
				}
			}

			if ($this -> logger) {
				Logger::query($req, $start);
			}

			return mysql_affected_rows($this -> link);
		}
	}

	/**
	 * Gets the last inserted ID
	 *
	 * @return mixed the last inserted ID
	 */
	public function lastInsertId() {
		if ($this -> pdo) {
			return $this -> link -> lastInsertId();
		} else {
			return mysql_insert_id($this -> link);
		}
	}

	/**
	 * Returns the last executed query
	 *
	 * @return string
	 *
	 * @access public
	 */
	public function lastQuery() {

		return $this -> lastQuery;

	}

} /*** end of class ***/
?>
