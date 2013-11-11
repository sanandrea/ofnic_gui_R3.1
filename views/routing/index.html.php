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
	        	<div>
		        	<div class="btn-group">
		  				<button type="button" id="srcBtnGroup" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
		    				Source<span class="caret"></span>
		  				</button>
		  				<ul id="srcNodeDropDown" class="dropdown-menu" role="menu">
		  				</ul>
					</div>
					<div class="btn-group  pull-right">
		  				<button type="button" id="dstBtnGroup" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
		    				Destination<span class="caret"></span>
		  				</button>
		  				<ul id="dstNodeDropDown" class="dropdown-menu" role="menu">
		  				</ul>
					</div>
				</div>
				<div class="row">
					<div id="displaySrcNode" class="col-md-6">
						
					</div>
					<div id="displayDstNode" class="col-md-6">
						
					</div>
				</div>
				<hr>
				<p>Select incoming and outgoing Port from the menus below</p>
				<div>
		        	<div class="btn-group">
		  				<button type="button" id="incBtnGroup" class="btn btn-info dropdown-toggle" data-toggle="dropdown" disabled="disabled">
		    				Incoming<span class="caret"></span>
		  				</button>
		  				<ul id="incPortDropDown" class="dropdown-menu" role="menu">
		  				</ul>
					</div>
					<div class="btn-group  pull-right">
		  				<button type="button" id="outBtnGroup" class="btn btn-info dropdown-toggle" data-toggle="dropdown" disabled="disabled">
		    				Outgoing<span class="caret"></span>
		  				</button>
		  				<ul id="outPortDropDown" class="dropdown-menu" role="menu">
		  				</ul>
					</div>
				</div>
				<div class="row">
					<div id="displayIncPort" class="col-md-6">
						
					</div>
					<div id="displayOutPort" class="col-md-6">
						
					</div>
				</div>
				<hr>
	        </div>
	    </div>
	</div>

</div>
