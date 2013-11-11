var portSelectBefore = null;
var nodeSelectBefore = null;
var edgeHighlighted = null;

function addNodeToList(aNode){
  $('#nodeDropDown').append("<li><a onclick=\"javascript:selectNode("+aNode+")\">"+aNode+"</a></li>");
}

// gestione dei tasti delle interfacce
function PortSelect(intName,index)
{
   if (intName != portSelectBefore) {
      if (edgeHighlighted != null){
        edge.data.lineWidth = 1;
      }
      //sys1.prune();  //CANCELLA IL GRAFO SECONDARIO
      portSelectBefore = intName;
      generateGraphPort(intName,nodeSelectBefore,index);
   }

}

function selectNode(node){
  if (node != nodeSelectBefore){
    displayPortPanel();
    resetPortTable();
    if (edgeHighlighted != null){
      edge.data.lineWidth = 1;
    }
    findNode(node);
    changeNodeColour(node, colorGreen);
    arborNode = sys.getNode(node);
    arborNode.data.color = colorGreen;
    if (nodeSelectBefore != null){
      sys.getNode(nodeSelectBefore).data.color = colorRed;
    }
    nodeSelectBefore = node;
  }
}

function displayPortPanel(){
  $('#portPanel').removeClass("hidden");
}

function resetPortTable(){
  $('#portInfoTable').html("");
  
}
// abilita le interfacce presenti sul nodo selezionato e disabilita le altre
function setPorts(result,node)
{
  //sys1.prune();  //CANCELLA IL GRAFO SECONDARIO
    //CANCELLA le info della porta
	$('#port_info').html("");
    $('#graph_info').text("");			
    nodeSelectBefore = node;	
    portSelectBefore = null;
	
  //old implementation see line below
  //$('#left').html( "<table><tr><td colspan='2'>Information about node "+node+"</td></tr><tr><td>Num Buffers: </td><td>"+result.Num_Buffers+"</td></tr><tr><td>Num Tables: </td><td>"+result.Num_Tables+"</td></tr><tr><td>Actions: </td><td>"+result.Actions+"</td></tr><tr height='25'></tr><tr><td colspan='2'>Ports of node "+node+"</td></tr><tr height='10'></tr></table><div id='portLeft' class='btn-group' data-toggle='buttons-radio'></div>");
  $('#nodeInfoTable').html("<tr><td>"+node+"</td><td>"+result.Num_Buffers+"</td><td>"+result.Actions+"</td><td>"+result.Num_Tables+"</td></tr>");

  $('#portDropDown').html("");
    $.each(result.Port_Names, function(i,port) {
	    $.getJSON("./?a=ws&wspath=synchronize_network_node_"+node+"_port_"+result.Port_Index[i], function(data1) {
        //old implementation see line below
        //$('#portLeft').append("<button id='"+port+"' class='btn btn-primary' onClick=PortSelect('"+port+"','"+result.Port_Index[i]+"');>"+port+"</button>");
        $('#portDropDown').append("<li><a onClick=PortSelect('"+port+"','"+result.Port_Index[i]+"');>"+port+"</a></li>");

	if (data1.result.links == 'None'){
		$("#"+port).attr('disabled','disabled');       
	}	
      });});


       
}

function displayPortInfo(result, port, index){
	//old implementation see line below
  //$('#port_info').html( "<table><tr><td colspan='2' width='400'>Information about port "+port+"</td></tr><tr><td>Active: </td><td>"+result.Active+"</td></tr><tr><td>Config: </td><td>"+result.Config+"</td></tr><tr><td>State: </td><td>"+result.State+"</td></tr><tr><td>Speed: </td><td>"+result.Speed+"</td></tr><tr height='25'></tr></table>");
  $('#portInfoTable').html("<tr><td>"+index+"</td><td>"+port+"</td><td>"+result.Active+"</td><td>"+result.State+"</td><td>"+result.Speed+"</td></tr>");

  //old implementation
  //$('#graph_info').text("link of port " + port);
}
