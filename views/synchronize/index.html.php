<div id="messageBox" class="fade"></div>
<div class="row">
	<div id="graph" class="col-md-7" align="left">
	      <canvas id="viewport" width="550" height="450"></canvas>
	</div>
	<div class="col-md-5">
	    <div class="panel panel-default">
	    <!-- Default panel contents -->
	        <div class="panel-heading">Topology Information</div>
	        <div class="panel-body">
	            <p>Select a Node from the graph or from the menu below</p>
		        <div class="btn-group">
	  				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
	    				Select Node <span class="caret"></span>
	  				</button>
	  				<ul id="nodeDropDown" class="dropdown-menu" role="menu">
	  				</ul>
				</div>
				
	        </div>
	        <!-- Node Info Table -->
	        <table class="table">
	          <thead>
	            <tr>
	              <th>Node ID</th>
	              <th>Buffers</th>
	              <th>Actions</th>
	              <th>Tables</th>
	            </tr>
	          </thead>
	          <tbody id="nodeInfoTable">
	          </tbody>
	        </table>
	    </div>

	    <div class="panel panel-default hidden" id="portPanel">
	    <!-- Default panel contents -->
	        <div class="panel-heading">Port Information</div>
	        <div class="panel-body" id="portPanelBody">
	        	<p>Select a Port from the menu below</p>
	        	<div class="btn-group">
	  				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
	    				Select Port <span class="caret"></span>
	  				</button>
	  				<ul id="portDropDown" class="dropdown-menu" role="menu">
	  				</ul>
				</div>
	        </div>
	        <!-- Port Info Table -->
	        <table class="table">
	          <thead>
	            <tr>
	              <th>Port ID</th>
	              <th>Port Name</th>
	              <th>Active</th>
	              <th>State</th>
	              <th>Speed</th>
	            </tr>
	          </thead>
	          <tbody id="portInfoTable">
	          </tbody>
	        </table>
	    </div>
		<div id="content" class="row"></div>
	</div>
</div>
