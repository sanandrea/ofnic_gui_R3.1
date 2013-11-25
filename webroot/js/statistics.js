var statOption;

function setupNewTaskCollapse(){
	
	$('#addTaskCollapse').on('show.bs.collapse', function () {
		$('#expandTaskButton').html("<i class=\"glyphicon glyphicon-minus\"></i>");
		
	});
	
	$('#addTaskCollapse').on('hidden.bs.collapse', function () {
		$('#expandTaskButton').html("<i class=\"glyphicon glyphicon-plus\"></i>");
		$('#displayFlow').empty();
		$('#displayFlowNode').empty();
		$('#nodesBtnGroup').attr('disabled','disabled');
		eraseVirtualPathLine(openedPath);
		openedPath = null;
		
	});
	
}

//setta le variabili e il template per ottenere le statistiche sulla porta
function activeGetPortStat(){
	statOption = 1;
	nodeSelectBefore = null;	
        portSelectBefore = null;
        clearInterval(timerStat);
	$('#statistics').html("<div id='left'q class='span5'>Select a node </div><div id='right' class='span7'>");

}

function addNodeToList(aNode){
  $('#nodeDropDown').append("<li><a onclick=\"javascript:selectNode("+aNode+")\">"+aNode+"</a></li>");
}

function selectNode(aNode){
	if (aNode != nodeSelectBefore){
		$('#displayNode').html('<h4><span class="label label-default">Node '+aNode+'</span></h4>');
		$('#portBtnGroup').removeAttr('disabled');
		changeNodeColour(aNode, colorGreen);
		if (nodeSelectBefore != null){
			changeNodeColour(nodeSelectBefore, colorRed);	
		}
		findNode(aNode);
		nodeSelectBefore = aNode;
	}
}

//is called in grafo.js
function populatePortList(result, aNode){
	$('#portDropDown').empty();
	$('#displayPort').empty();
	$('#portStatInfoTable').empty();
	
	console.log(result);
	$.each(result.Port_Names, function(i,port) {
		$.getJSON("./?a=ws&wspath=synchronize_network_node_"+aNode+"_port_"+result.Port_Index[i], function(data1) {
			$('#portDropDown').append('<li><a onClick=PortSelectStat("'+port+'","'+result.Port_Index[i]+'");>'+port+'</a></li>');
	    })
	    .fail(function (jqxhr, textStatus, error){
	    	alertMessage("Could not retrieve network nodes. Reason: "+jqxhr.status+" ("+error+")",false);
	    });
	});
}

function PortSelectStat(intName,index)
{
   	if (intName != portSelectBefore) {
      		portSelectBefore = intName;
      	// get port stat
      	  	$.getJSON("./?a=ws&wspath=statistics_node_"+nodeSelectBefore+"_port_"+index, function(data) {
			displayPortStat(data.result,intName);	        
		})
	    .fail(function (jqxhr, textStatus, error){
	    	alertMessage("Could not retrieve statistics of port. Reason: "+jqxhr.status+" ("+error+")",false);
	    });   
	}
   
}	

//visualizza le statistuche della porta
function displayPortStat(result, port){
	$('#displayPort').empty();
	$('#displayPort').append('<h4><span class="label label-default pull-right">'+port+'</span></h4>');
	//$('#right').html( "<table><tr><td colspan='2' width='400'>Statistics about port "+port+"</td></tr><tr><td>Tx_bytes: </td><td>"+result.Tx_bytes+"</td></tr><tr><td>Tx_errors: </td><td>"+result.Tx_errors+"</td></tr><tr><td>Rx_bytes: </td><td>"+result.Rx_bytes+"</td></tr><tr><td>Rx_errors: </td><td>"+result.Rx_errors+"</td></tr><tr height='25'></tr></table>");
	$('#portStatInfoTable').empty();
	$('#portStatInfoTable').append("<tr><td>"+result.Tx_bytes+"</td><td>"+result.Rx_bytes+"</td><td>"+result.Tx_errors+"</td><td>"+result.Rx_errors+"</td></tr>")
      
}


//visualizza la lista dei path esistenti per aggiungere un monitoring task
function displayVirtualPathStat(){
	$.getJSON("./?a=ws&wspath=virtualpath", function(data) {
		pathExisting = data.result.Paths;
		$.each(data.result.Paths, function(i,path) {
			if (path != ""){
				$('#flowDropDown').append("<li><a onclick=\"javascript:selectFlow('"+path+"')\">"+path+"</a></li>");
			}
		});
	})
    .fail(function (jqxhr, textStatus, error){
    	alertMessage("Could not retrieve virtualpaths. Reason: "+jqxhr.status+" ("+error+")",false);
    });
	return;
}

function selectFlow(path){
	console.log("path is: "+ path);
	if (path != openedPath){
		$('#displayFlow').html('<h4><span class="label label-default">'+path+'</span></h4>');
		//call this CB when data available
		getInfoVirtualPath(path, flowInfoReady);
		openedPath = path;
	}
	return;
}

function flowInfoReady(path){
	console.log("cb called");
	$('#nodePathDropDown').empty();
	for (var j=0;j<nodesOfPath.length;j++)
	{
		$("#nodePathDropDown").append("<li><a onClick=portPathStatSelect('"+nodesOfPath[j]+"','"+path+"');>"+nodesOfPath[j]+"</a></li>");
	}
	$('#nodesBtnGroup').removeAttr('disabled');
}

// click per aggiungere il monitor sulla porta selezionata
function portPathStatSelect(node,path){
	$('#dpid').val(node);
	$('#PathID').val(path);
	$('#displayFlowNode').html('<h4><span class="label label-default pull-right">Node ID:'+node+'</span></h4>');
}

function displayNewTaskModal(){
	$('#myModalStat').modal({backdrop:"static"});
	$('#myModalStat').modal('show');
	
	$('#addTaskCollapse').collapse('hide');
}

//resetta le porte al click su close della finestra dei parametri
function closeModalStat(){
	$('#pathStatParameters')[0].reset();	
	$('#myModalStat').modal('hide');
}		

//invia i dati
function submitModalStat(){

	$.ajax({
      type: "POST",
      url: "./?a=ws&wspath=statistics_task_create",
      data: $("#pathStatParameters").serialize(),
      error: function() {
        alertMessage("Creation failed. Try again.",false);
      },
      success: function() {
        alertMessage("Creation Successfull!!!",true);   
      },
      complete: function() {
        
	$('#addPathMonitor').removeClass('active');
	$('#pathStatDisplay').addClass('active');
	displayMonitorStat();
	closeModalStat();
      }
    });	
	
}

//visualizza i monitor attivi
function displayMonitorStat(){
	clearInterval(timerStat);
	$.getJSON("./?a=ws&wspath=statistics_task", function(data) {
		$('#monitoringTaskList').empty();
	
		$.each(data.result['MonitorIDs'], function(i,monitor) {
			if (monitor != ""){            
				$('#monitoringTaskList').append('<div class="panel panel-default" id="monitorPanelEntry'+monitor+'">'+
												'<div class="panel-heading">'+
													'<div class="panel-title">'+
														'<a data-toggle="collapse" data-parent="#monitoringTaskList" href="#collapse'+i+'">'+
															'Monitor ID '+ monitor +
														'</a>'+
														'<a class="btn btn-danger btn-xs pull-right" href=javascript:removeMonitoringTask("'+monitor+
														'");><i class="glyphicon glyphicon-trash"></i></a>'+
												'</div></div>'+
												'<div id="collapse'+i+'" class="panel-collapse collapse">'+
													'<div class="panel-body" id="monitorTaskInfo'+monitor+'">'+
											'</div></div></div>');    
				$('#collapse'+i).on('shown.bs.collapse', function () {
				getStatMonitor(monitor);});
				$('#collapse'+i).on('hidden.bs.collapse', function () {
				clearInterval(timerStat);});
				i++;
			}
	
		});	
    })
    .fail(function (jqxhr, textStatus, error){
    	alertMessage("Could not retrieve monitor tasks. Reason: "+jqxhr.status+" ("+error+")",false);
    });
}

//rimuove il monitor
function removeMonitoringTask(monitor){
	$.ajax({
	      type: "DELETE",
	      url: "./?a=ws&wspath=statistics_task_"+monitor,
	      
	      error: function() {
	        alertMessage("Remotion failed. Try again.",false);
	      },
	      success: function() {
	        alertMessage("Remotion Successfull!!!",true);
	      },
	      complete: function() {
	      displayMonitorStat();
	      }
	});	
}
