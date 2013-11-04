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

    /* old method */
    $data = array();
    $data['username'] = $_POST['uid'];
    $data['password'] = $_POST['pwd'];

    $cookieFile = '/tmp/ofnic_' . $_POST['uid'] . '_cookie.txt';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_HEADER, true);
    //no certificate checking
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_URL, "https://130.206.82.172/netic.v1/login");
    //write cookie to jar
    curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile);

    ob_start();      // prevent any output
    curl_exec ($curl); // execute the curl command
    ob_end_clean();  // stop preventing output

    //release memory and file handlers
    curl_close($curl);

    $ch = curl_init();
    // Set query data here with the URL
    curl_setopt($ch, CURLOPT_URL, 'https://130.206.82.172/netic.v1/doc');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, '3');
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    $content = trim(curl_exec($ch));
    curl_close($ch);
    #print $content;

    //delete cookie file at session end
    if (file_exists($cookieFile)){
        unlink($cookieFile);
    }
    

    
?>