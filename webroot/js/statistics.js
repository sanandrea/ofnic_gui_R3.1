var statOption;

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
	    });
	});
}

//setta le variabili e il template per ottenere le statistiche sulla porta
function activeAddPathStat(){
	statOption = 2;
	nodeSelectBefore = null;	
        portSelectBefore = null;
	clearInterval(timerStat);
	displayVirtualPathStat();
}

//visualizza le porte del nodo selezionato
function setPortsStat(result,node)
{
	      $('#right').html("");
    	      nodeSelectBefore = node;	
	      portSelectBefore = null;
		 
		$('#left').html( "<table><tr><td colspan='2'>Information about node "+node+"</td></tr><tr><td>Num Buffers: </td><td>"+result.Num_Buffers+"</td></tr><tr><td>Num Tables: </td><td>"+result.Num_Tables+"</td></tr><tr><td>Actions: </td><td>"+result.Actions+"</td></tr><tr height='25'></tr><tr><td colspan='2'>Ports of node "+node+"</td></tr><tr height='10'></tr></table><div id='portLeft' class='btn-group' data-toggle='buttons-radio'></div>");
		
	      $.each(result.Port_Names, function(i,port) {
		$.getJSON("./?a=ws&wspath=synchronize_network_node_"+node+"_port_"+result.Port_Index[i], function(data1) {

		 $('#portLeft').append("<button class='btn btn-primary' onClick=PortSelectStat('"+port+"','"+result.Port_Index[i]+"');>"+port+"</button>");

	      });});
       
}

// gestione dei tasti delle interfacce
function PortSelectStat(intName,index)
{
   	if (intName != portSelectBefore) {
      		portSelectBefore = intName;
      	// get port stat
      	  	$.getJSON("./?a=ws&wspath=statistics_node_"+nodeSelectBefore+"_port_"+index, function(data) {
			displayPortStat(data.result,intName);	        
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


//visualizza i virtual path esistenti per aggiungere un monitor
function displayVirtualPathStat(){
	$.getJSON("./?a=ws&wspath=virtualpath", function(data) {
		pathExisting = data.result.Paths;
		$.each(data.result.Paths, function(i,path) {
			if (path != ""){
				$('#flowDropDown').append("<li><a onclick=\"javascript:selectFlow('"+path+"')\">"+path+"</a></li>");
			}
		});
	});
	return;
	
	
	
	

$('#statistics').html("<div id='displayPathStat' class='accordion'></div>");

$.getJSON("./?a=ws&wspath=virtualpath", function(data) {
	
	pathExisting = data.result.Paths;

	$.each(data.result.Paths, function(i,path) {
		if (path != ""){            
		$('#displayPathStat').append("<div id='accordion-group"+path+"'class='accordion-group'><div class='accordion-heading'><a  class='accordion-toggle' data-toggle='collapse' data-parent='#displayPathStat' href='#collapse"+i+"'>Virtual Path " + path + "</a></div><div id='buttonPathStat"+path+"' class='btn-group' data-toggle='buttons-radio' style='float:right;'></div> <div id='collapse"+i+"' class='accordion-body collapse' style='clear:both;'><div id='inner-"+path+"' class='accordion-inner'></div></div></div>");
		
		$.getJSON("./?a=ws&wspath=virtualpath_"+path, function(data) {   
	
	for (var j=0;j<data.result.Nodes.length;j++)
	{
		$("#buttonPathStat"+path).append("<button id='btn"+path+"node"+data.result.Nodes[j]+"'class='btn btn-blue' onClick=portPathStatSelect('"+data.result.Nodes[j]+"','"+path+"')>"+data.result.Nodes[j]+"</button>");	
	}		    
		$('#collapse'+i).on('shown', function () {
		getInfoVirtualPath(path);}); 

		$('#collapse'+i).on('hidden', function () {
		eraseVirtualPathLine(path);});
	  });	
	} 
      });
});
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
}

function displayNewTaskModal(){
	$('#myModalStat').modal({backdrop:"static"});
	$('#myModalStat').modal('show');
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
        alertMessage("Creation failed. Try again.");
      },
      success: function() {
        alertMessage("Creation Successfull!!!");   
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
    });
}

//rimuove il monitor
function removeMonitoringTask(monitor){
	$.ajax({
	      type: "DELETE",
	      url: "./?a=ws&wspath=statistics_task_"+monitor,
	      
	      error: function() {
	        alertMessage("Remotion failed. Try again.");
	      },
	      success: function() {
	        alertMessage("Remotion Successfull!!!");      
	      },
	      complete: function() {
	      displayMonitorStat();
	      }
	});	
}
