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

if (!defined('OFNIC')) die('Direct access not allowed!');

/**
 * Check if a string starts with a given substring
 *
 * @param string $string string to be checked
 * @param string $search substring
 * @param boolean $case case-sensitive
 *
 * @return boolean true/false
 *
 */
function startsWith($string, $search, $case = false) {
    if ($case) {
        return (strcmp(substr($string, 0, strlen($search)), $search) === 0);
    }
    return (strcasecmp(substr($string, 0, strlen($search)), $search) === 0);
}

/**
  * Check if a string ends with a given substring
 *
 * @param string $string string to be checked
 * @param string $search substring
 * @param boolean $case case-sensitive
 *
 * @return boolean true/false
 *
 */
function endsWith($string, $search, $case = false) {
    if ($case) {
        return (strcmp(substr($string, strlen($string) - strlen($search)), $search) === 0);
    }
    return (strcasecmp(substr($string, strlen($string) - strlen($search)), $search) === 0);
}

/**
  * Join recursively array elements with a glue string. 
 *
 * @param array $array Array to implode
 * @param string $glue Defaults to an empty string. 
 * @param string $showkey If not null, implode the key
 *
 * @return string A string containing a string representation of all the array elements
 *
 */

function implode_recursive($item, $glue, $showkey = null) {
    $ret = '';

   // foreach ($array as $key => $item) {
    	if ($item instanceof model){
            $ret .= implode_recursive($item->data(), $glue, $showkey) . $glue;
        } else if (is_array($item)) {
          	$ret .= implode_recursive($item, $glue, $showkey) . $glue;
        } else {
        	if ($showkey)
            $ret .= $showkey .'_' . $glue;
			else 
			$ret .= $item . $glue;
  //      }
    }

    $ret = substr($ret, 0, 0-strlen($glue));

    return $ret;
}

/**
  * Convert array of Objects (subclasses of model) in array of array
 *  Used for printing
 * @param array $array array to be converted
 * @return array array converted
 *
 */

function object2array($array){
    foreach ($array as &$item) {
        $item=$item->data2array();
    }
    return $array;
}


function jsonMessage($type, $msg, $data = null){
		$msgview = new View('msg');
		$msgview -> assign('type', $type);
		$msgview -> assign('msg', $msg);
		$msgview -> assign('data', $data);
		$msgview -> show('json');
	}

function currentTime($session = null){
	return isset($session['ts'])? strtotime(date("Y-m-d")) + ($session['ts'] * 60) : time();  // TO BE REPLACED WITH: time() 
}

function currentUser(){
	return isset($_SESSION['user'])? $_SESSION['user'] : 1;  // DEFAULT_USER 
}


function randomString($length) {
    $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ";
    $pass = "";
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, strlen($alphabet)-1);
        $pass.= $alphabet[$n];
    }
    return $pass;
}

function randomValue($length) {
    $numbers = "0123456789";
     $pass = "";
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, strlen($numbers)-1);
         $pass.= $numbers[$n];
    }
    return $pass;
}

?>
