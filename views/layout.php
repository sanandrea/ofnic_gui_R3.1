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
    	<link href="webroot/assets/css/ofnic.css" rel="stylesheet">	     
	</head>
		
	<body style>
		<div id="wrap">
		<!-- Le navbar -->
		<?php
		if (isset($modules['navbar'])) {
		?>
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
            		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              			<span class="icon-bar"></span>
              			<span class="icon-bar"></span>
              			<span class="icon-bar"></span>
            		</button>
            		<img class="navbar-brand" src="webroot/assets/img/fi_ware_logo_sm.png"/>
          		</div>
          		<div class="collapse navbar-collapse">
            		<ul class="nav navbar-nav">
						<?php 
						echo implode($modules['navbar'], '')
						?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
                			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i><?php echo "  ".$_SESSION['uid']?> <b class="caret"></b></a>
                			<ul class="dropdown-menu">
                  				<li><a href="?a=logout">Logout</a></li>
                			</ul>
              			</li>
              			<!-- <a class="navbar-brand" >OFNIC</a> -->
					</ul>
				</div>
			</div>
		</div>
		<?php 
		}
		?>
		<!-- /Le navbar -->
		
		<?php 
		if (isset($modules['login'])) {
		?>
		
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h1>Welcome to OFNIC GEi Web Gui</h1>
					<h4>
						This web page is the graphical user interface of a reference instance of the Network Information&Control (NetIC) Generic Enabler. 
						More info on NetIC GE can be found  
						<a href="http://forge.fi-ware.eu/plugins/mediawiki/wiki/fiware/index.php/FIWARE.ArchitectureDescription.I2ND.NetIC" target="_blank">here</a>
						<br /><br /><br />
						NetIC is the task dealing with interfaces toward programmable networks inside the I2ND chapter of <a href="http://www.fi-ware.eu/" target="_blank">FI-WARE</a> project.
					</h4>
					<h4>OpenFlow Network Information and Control (OFNIC) is provided by Uniroma1 Partner of FI-WARE Consortium</h4>
					<img class="featurette-image img-responsive center-block" data-src="holder.js/500x500/auto" alt="300x300" src="webroot/assets/img/fi_ware_logo.png"/>
					
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
   			<!-- <h1><?=$title?></h1> 
   			-->
   			<?=$content ?>
		
   			
		</div>


	<!-- wrapper -->	
    </div>

    <div id="footer">
      	<div class="container">
        	<p class="text-muted credit">OFNIC GEi <strong>Designed by </strong><spam class="blue-dark">University of Rome, La Sapienza</spam> Copyright &copy 2013</p>
    	</div>
    </div>

<?=$scripts ?>



</body>
</html>
