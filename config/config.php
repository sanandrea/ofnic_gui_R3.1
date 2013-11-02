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

/**
 * The configuration file
 */

/* Logging */
$config['enable_log'] = true;

$win_dir_root = substr(dirname(__FILE__),0,strrpos(dirname(__FILE__),"\\"));
$lin_dir_root = substr(dirname(__FILE__),0,strrpos(dirname(__FILE__),"/"));

$dir_root = $lin_dir_root;
$slash = '/';

if (is_dir($win_dir_root))
{

    $dir_root = $win_dir_root;
    $slash = '\\';
}

/* Database connection */
$config['dbhost'] = '130.206.82.172';
$config['dbuser'] = 'root';
$config['dbpass'] = 'openflow';
$config['dbname'] = 'openflow_users';
$config['dberrors'] = true;

?>