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
					<div id="displayPort" class="col-md-6">
						
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
	<div class="col-md-3 sidebar-offcanvas" id="sidebar" role="navigation">
		<div class="panel-group" id="virtualPathList">
    		<div class="panel panel-default panelOverFlow" id="pathPanelEntry3783">
        		<div class="panel-heading">
            		<div class="panel-title">
                		Flow Monitoring Tasks
                		<a data-toggle="collapse" data-parent="virtualPathList" href="#addTaskCollapse" class="btn btn-success btn-xs pull-right" ><i class="glyphicon glyphicon-plus"></i></a>
            		</div>
        		</div>
        		<div id="addTaskCollapse" class="panel-collapse collapse">
            		<div class="panel-body" id="addTaskPanel">
            			Select the Flow and then the Node on which to perform the monitoring.
            			<div class="btn-group">
		  				<button type="button" id="pathsBtnGroup" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
		    				Flow<span class="caret"></span>
		  				</button>
		  				<ul id="flowDropDown" class="dropdown-menu" role="menu">
		  				</ul>
					</div>
					<div class="btn-group  pull-right">
		  				<button type="button" id="nodesBtnGroup" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" disabled="disabled">
		    				Node<span class="caret"></span>
		  				</button>
		  				<ul id="nodePathDropDown" class="dropdown-menu" role="menu">
		  				</ul>
					</div>
            		</div>
        		</div>
    		</div>
		</div>
    </div>

    <div class="modal fade" id="myModalStat" aria-hidden="true">
		<div class="modal-dialog">
	    	<div class="modal-content">
	 			<div class="modal-header">
	   				<a href="javascript:closeModalStat();" class="close" >×</a>
	   				<h3>Monitoring Task Parameters</h3>
	 			</div>
	 			<div class="modal-body">
	 				<form id="pathStatParameters">
	   					<table><tbody>
							<tr><td colspan="2" style="border-bottom:1px solid black;">Mandatory Parameters</td></tr>
							<tr> <td>Path ID:</td><td><input type="text" id="PathID" name="PathID" readonly/></td></tr>
							<tr> <td>Node ID:</td><td><input type="text"  id="dpid"  name="dpid" readonly/></td></tr>
							<tr> <td>Duration (s):</td><td><input type="text" name="duration" /></td></tr>
							<tr> <td>Frequency :</td><td><input type="text" name="frequency" /></td></tr>
	    				</tbody></table>
	  				</form>
				</div>
				<div class="modal-footer">
  					<a href="javascript:closeModalStat();" class="btn btn-default" >Cancel</a>
  					<a href="javascript:submitModalStat();" class="btn btn-primary">Create</a>
				</div>
	  		</div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>
