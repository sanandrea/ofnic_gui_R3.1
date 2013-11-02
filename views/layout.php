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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title><?=$title ?></title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="<?=$description ?>" />
		<meta name="keywords" content="<?=$keywords ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Le styles -->
    	<link href="webroot/assets/css/aplication.css" rel="stylesheet">
    	<link href="webroot/assets/css/bootstrap.css" rel="stylesheet">
    	<link href="webroot/assets/css/bootstrap-responsive.css" rel="stylesheet">
    	<link href="webroot/assets/css/docs.css" rel="stylesheet">
    	<link href="webroot/assets/js/google-code-prettify/prettify.css" rel="stylesheet">
	     
	</head>
		
	<body>
		<?php 
		if (isset($modules['navbar'])) {
		?>
		<div class="navbar navbar-default navbar-fixed-top"><div class="navbar-inner"><div class="container">  
		<?php 
		echo implode($modules['navbar'], '')
		?>
		</div></div></div>
		<?php 
		}
		?>
		
		<div class="container">  
   			<h1><?=$title?></h1>
		
   			<?=$content ?>
		</div>
		
		 
<script src="js/main.js" type="text/javascript"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
	</html>
