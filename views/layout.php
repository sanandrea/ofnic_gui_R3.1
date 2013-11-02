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
<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?=$title ?></title>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="description" content="<?=$description ?>" />
		<meta name="keywords" content="<?=$keywords ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Le styles -->
    	<link href="webroot/assets/css/bootstrap.css" rel="stylesheet">
    	<link href="webroot/assets/css/signin.css" rel="stylesheet">	     
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
		
		<?php 
		if (isset($modules['login'])) {
		?>
		
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2>Welcome to OFNIC GEi Web Gui</h2>
					<h4>Provided by Uniroma1</h4>
				</div>
				<div class="col-md-4">
					<?php 
					readfile(__ROOT_PATH . '/views'.'/login_section.html');
					?>
				</div>
			</div>
		</div>
		
		<?php 
		}
		?>

		<div class="container">  
   			<!-- <h1><?=$title?></h1> -->
		
   			<?=$content ?>
		</div>
		
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    
<script src="webroot/assets/js/jquery.js"></script>
<script src="webroot/assets/js/arbor.js"></script>
<script src="webroot/assets/js/arbor-tween.js"></script>
<script src="webroot/assets/js/graphics.js"></script>
<script src="webroot/assets/js/jquery.flot.js"></script>
<script src="webroot/assets/js/jstorage.js"></script>

<!--
<script src="js/template.js"></script>
<script src="js/synchronization.js"></script>    
<script src="js/grafo.js"></script>    
<script src="js/renderer.js"></script>
<script src="js/routing.js"></script>
<script src="js/statistics.js"></script>
<script src="js/grafoStatistics.js"></script>
<script src="js/panel.js"></script>



<script src="webroot/assets/js/google-code-prettify/prettify.js"></script>
<script src="webroot/assets/js/bootstrap-transition.js"></script>
<script src="webroot/assets/js/bootstrap-alert.js"></script>
<script src="webroot/assets/js/bootstrap-modal.js"></script>
<script src="webroot/assets/js/bootstrap-dropdown.js"></script>
<script src="webroot/assets/js/bootstrap-scrollspy.js"></script>
<script src="webroot/assets/js/bootstrap-tab.js"></script>
<script src="webroot/assets/js/bootstrap-tooltip.js"></script>
<script src="webroot/assets/js/bootstrap-popover.js"></script>
<script src="webroot/assets/js/bootstrap-button.js"></script>
<script src="webroot/assets/js/bootstrap-collapse.js"></script>
<script src="webroot/assets/js/bootstrap-carousel.js"></script>
<script src="webroot/assets/js/bootstrap-typeahead.js"></script>
<script src="webroot/assets/js/application.js"></script>
-->
</body>
</html>
