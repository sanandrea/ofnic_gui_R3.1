<div class="row" id="messageBox" style="background-color:#FFFF33;font-size: medium;" align="center"></div>
<div class="row row-offcanvas row-offcanvas-right">
	<div id="graph" class="col-md-6" align="left">
	      <canvas id="viewport" width="550" height="450"></canvas>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default" id="portPanel">
	    <!-- Create a Routing panel -->
	        <div class="panel-heading">Monitor Port Statistics</div>
	        <div class="panel-body" id="portPanelBody">
	        	<p>Select the Node and Port from the menus below</p>
	        	<div>
		        	<div class="btn-group">
		  				<button type="button" id="nodeBtnGroup" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
		    				Node<span class="caret"></span>
		  				</button>
		  				<ul id="nodeDropDown" class="dropdown-menu" role="menu">
		  				</ul>
					</div>
					<div class="btn-group  pull-right">
		  				<button type="button" id="portBtnGroup" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" disabled="disabled">
		    				Port<span class="caret"></span>
		  				</button>
		  				<ul id="portDropDown" class="dropdown-menu" role="menu">
		  				</ul>
					</div>
				</div>
				<div class="row botSpace">
					<div id="displayNode" class="col-md-6">
						
					</div>
					<div id="displayPort" class="col-md-2 pull-right">
						
					</div>
				</div>
	        </div>
	        
	        <table class="table">
	          <thead>
	            <tr>
	              <th>TX B/s</th>
	              <th>RX B/s</th>
	              <th>TX Errors</th>
	              <th>RX Errors</th>
	            </tr>
	          </thead>
	          <tbody id="portStatInfoTable">
	          </tbody>
	        </table>
	    </div>
	</div>
	<div class="col-md-3" sidebar-offcanvas" id="sidebar" role="navigation>
		<div class="panel panel-default" id="portPanel">
	    <!-- Create a Routing panel -->
	        <div class="panel-heading">Active Virtual Paths</div>
	        <div class="panel-body" id="portPanelBody">
	        	
	        </div>
	        <div class="panel-group" id="virtualPathList">
		        
	        </div>
	    </div>
    </div>
</div>
