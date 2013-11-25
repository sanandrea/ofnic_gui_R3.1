<div id="messageBox" class="fade"></div>
<div class="row">
	<div id="graph" class="col-md-7" align="left">
	      <canvas id="viewport" width="550" height="450"></canvas>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default" id="portPanel">
	    <!-- Create a Routing panel -->
	        <div class="panel-heading">
	        	<div class="panel-title">
            		Virtual Paths
            		<a data-toggle="collapse" id="expandVPButton" href="#addVPCollapse" class="btn btn-success btn-xs pull-right" >
            			<i class="glyphicon glyphicon-plus"></i>
            		</a>
            	</div>
	        </div>
	        <div id="addVPCollapse" class="panel-collapse collapse">
		        <div class="panel-body" id="portPanelBody">
		        	<p>Select Source and Destination Node from the menus below</p>
		        	<div>
			        	<div class="btn-group">
			  				<button type="button" id="srcBtnGroup" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
			    				Source<span class="caret"></span>
			  				</button>
			  				<ul id="srcNodeDropDown" class="dropdown-menu" role="menu">
			  				</ul>
						</div>
						<div class="btn-group  pull-right">
			  				<button type="button" id="dstBtnGroup" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
			    				Destination<span class="caret"></span>
			  				</button>
			  				<ul id="dstNodeDropDown" class="dropdown-menu" role="menu">
			  				</ul>
						</div>
					</div>
					<div class="row botSpace">
						<div id="displaySrcNode" class="col-md-6">
							
						</div>
						<div id="displayDstNode" class="col-md-6">
							
						</div>
					</div>
					<hr>
					<p>Select incoming and outgoing Port from the menus below</p>
					<div>
			        	<div class="btn-group">
			  				<button type="button" id="incBtnGroup" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" disabled="disabled">
			    				Incoming<span class="caret"></span>
			  				</button>
			  				<ul id="incPortDropDown" class="dropdown-menu" role="menu">
			  				</ul>
						</div>
						<div class="btn-group  pull-right">
			  				<button type="button" id="outBtnGroup" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" disabled="disabled">
			    				Outgoing<span class="caret"></span>
			  				</button>
			  				<ul id="outPortDropDown" class="dropdown-menu" role="menu">
			  				</ul>
						</div>
					</div>
					<div class="row botSpace">
						<div id="displayIncPort" class="col-md-3">
						</div>
						<div id="displayOutPort" class="col-md-3 col-md-offset-6">
							
						</div>
					</div>
					<hr>
		        	<ul class="pager">
	  					<li><button class="btn btn-success" onclick="javascript:launchVirtualModal();">Add</button></li>
					</ul>	
		        </div>
		    </div>
		<div class="panel-body">
		    <div class="panel-group" id="virtualPathList">
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
	<!--form di dialogo virtual path -->
	
	<div class="modal fade" id="myModal" aria-hidden="true">
		<div class="modal-dialog">
	    	<div class="modal-content">
	 			<div class="modal-header">
	   				<a href="javascript:closeModal();" class="close" >×</a>
	   				<h3>Virtual Path Parameters</h3>
	 			</div>
	 			<div class="modal-body">
	 				<form id="pathParameters">
	   					<table><tbody>
							<tr><td colspan="2" style="border-bottom:1px solid black;">Mandatory Parameters</td></tr>
							<tr> <td>Source IP address:</td><td><input type="text" id="nw_src" name="nw_src" /></td></tr>
							<tr> <td>Destination IP address:</td><td><input type="text" id="nw_dst"  name="nw_dst" /></td></tr>
							<tr> <td>Duration (s):</td><td><input type="text" name="duration" /></td></tr>
							<tr> <td>Bandwidth (kbps):</td><td><input type="text" name="bandwidth" /></td></tr>
							<tr> <td>Set ARP path:</td><td><select name="set_arp"><option value="0">false</option><option value="1">true</option></select></td></tr> 
							<tr> <td>Bidirectional:</td><td><select name="bidirectional"><option value="0">false</option><option value="1">true</option></select></td></tr>
							<tr><td colspan="2" style="border-bottom:1px solid black;">Optional info if lldp is not announced by border hosts</td></tr>
							<tr> <td>Source Datapath Id:</td><td><input type="text" id="dp_src" name="dp_src" readonly/></td></tr>
							<tr> <td>Destination Datapath Id:</td><td><input type="text" id="dp_dst" name="dp_dst" readonly/></td></tr>
							<tr> <td>Entry Port Id:</td><td><input type="text" id="first_port" name="first_port" readonly/></td></tr>
							<tr> <td>Exit Port Id:</td><td><input type="text" id="last_port" name="last_port" readonly/></td></tr>
							<tr><td colspan="2" style="border-bottom:1px solid black;">Optional info if the "Set ARP path" is set to true, but the Hosts don't support lldp</td></tr>
							<tr> <td>Source Mac Address:</td><td><input type="text" name="dl_src" /></td></tr>
							<tr> <td>Destination Mac Address:</td><td><input type="text" name="dl_dst" /></td></tr>
							<tr><td colspan="2" style="border-bottom:1px solid black;">Optional info if the users wants to add granularity to the flow</td></tr>
						
							<tr> <td>Ip Protocol:</td><td><input type="text" name="ip_proto" /></td></tr>
							<tr> <td>Source Transport Port:</td><td><input type="text" name="tp_src" /></td></tr>
							<tr> <td>Destination Transport Port:</td><td><input type="text" name="tp_dst" /></td></tr>
	    				</tbody></table>
	  				</form>
				</div>
				<div class="modal-footer">
  					<a href="javascript:closeModal();" class="btn btn-default" >Cancel</a>
  					<a href="javascript:submitModal();" class="btn btn-primary">Create</a>
				</div>
	  		</div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>
