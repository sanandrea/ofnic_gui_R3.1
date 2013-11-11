<div class="row" id="messageBox" style="background-color:#FFFF33;font-size: medium;" align="center"></div>
<div class="row">
	<div id="graph" class="col-md-7" align="left">
	      <canvas id="viewport" width="550" height="450"></canvas>
	</div>
	<div class="col-md-5">
		<div id="content" class="row"></div>
		<div class="panel panel-default" id="portPanel">
	    <!-- Create a Routing panel -->
	        <div class="panel-heading">Create Virtual Path</div>
	        <div class="panel-body" id="portPanelBody">
	        	<p>Select Source and Destination Node from the menus below</p>
	        	<div class="btn-group">
	  				<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
	    				Source<span class="caret"></span>
	  				</button>
	  				<ul id="srcNodeDropDown" class="dropdown-menu" role="menu">
	  				</ul>
				</div>
				<div class="btn-group  pull-right">
	  				<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
	    				Destination<span class="caret"></span>
	  				</button>
	  				<ul id="dstNodeDropDown" class="dropdown-menu" role="menu">
	  				</ul>
				</div>
	        </div>
	    </div>
	</div>

	<!--menu nascosto virtual path -->
	<ul id = "menuPath" class="dropdown-menu hide">
		<li><a href='javascript:selectNodeOne();'>Source</a></li>
		<li class="divider"></li>
		<li><a href='javascript:selectNodeTwo();'>Destination</a></li>
	</ul>
</div>
