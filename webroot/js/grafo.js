function generateGraph(){
//SCRIPT PER LA GENERAZIONE DEL GRAFO DI RETE
    // vedo i nodi della rete	  
    $.getJSON("./?a=ws&wspath=synchronize_network", function(data) {
    console.log(data);
	//grafo principale
	sys = arbor.ParticleSystem(1000); // creo un sistema di particelle
	sys.parameters({gravity:false}); // escludo la gravità
	sys.parameters({ friction: '1.0' });
	sys.renderer = Renderer("#viewport"); //inizio a disegnare nel viewport
	
    if (data.result.Nodes.length != 0){
	 //aggiungo i nodi
	$.each(data.result.Nodes, function() {
	   sys.addNode(this,{color:colorRed, fixed:true, shape:'dot', label:this});
	   
	   //add this node in the dropdown list of nodes
	   addNodeToList(this);
	});
	
	$.getJSON("./?a=ws&wspath=synchronize_network_all", function(data) {
	$.each(data.result.pairs, function(i,nodes) {
             sys.addEdge(sys.getNode(nodes[0]),sys.getNode(nodes[1]),{lineWidth:1});
	  });

	$.each(data.result.hosts, function(i,hosts) {
	    sys.addNode(hosts[1],{color:colorBlue, label:hosts[1]});
        sys.addEdge(sys.getNode(hosts[0]),sys.getNode(hosts[1]),{lineWidth:1});
	});	
       });
          
      }
      else{alertMessage("None Nodes detected");}
    });
}

function findNode(nameNode){

   if (nameNode != nodeSelectBefore){
   //RESTITUISCE LE INTERFACCE DEL NODO
   $.getJSON("./?a=ws&wspath=synchronize_network_node_"+nameNode, function(data) {   
	if (statOption == 1){   
		setPortsStat(data.result,nameNode);
	}else{
		setPorts(data.result,nameNode);
	}	
   });
   }
}


function generateGraphPort(nameInterface, selectedNode, index){
  	//vedo i link di ogni interfaccia
	$.getJSON("./?a=ws&wspath=synchronize_network_node_"+selectedNode+"_port_"+index, function(data1) {
		if (data1.result.links != 'None'){
			// genera tabella delle info della porta
			displayPortInfo(data1.result, nameInterface, index);
			$.each(data1.result.links, function(link) {
		        $.getJSON("./?a=ws&wspath=synchronize_network_node_"+selectedNode+"_port_"+index+"_link_"+link,function(data2){
			    	if (data2.result.node != null){
			    		edgesFound = sys.getEdges(selectedNode,data2.result.node);
			    		if (edgesFound.length > 0){
			    			edge = edgesFound[0];
			    			edge.data.lineWidth = 4;
			    			edgeHighlighted = edge;
			    		}
			    		// su ogni link un solo nodo non bisogna fare $each
			    		/*
			    		sys1.addNode(data2.result.node,{color:'#b01700', shape:'dot', label:data2.result.node});
			    		if (sys1.getNode(nameInterface)==null) sys1.addNode(nameInterface,{color:'#32CD32', label:nameInterface});
                            sys1.addEdge(sys1.getNode(nameInterface),sys1.getNode(data2.result.node));
                        */
			    	}else{
			    		edgesFound = sys.getEdges(selectedNode,data2.result.Name);
			    		if (edgesFound.length > 0){			    			
			    			edge = edgesFound[0];
			    			edge.data.lineWidth = 4;
			    			edgeHighlighted = edge;
			    		}
			    		/*
						sys1.addNode(data2.result.Name,{color:'#0000cd', label:data2.result.Name});
			    		if (sys1.getNode(nameInterface)==null) sys1.addNode(nameInterface,{color:'#32CD32', label:nameInterface});
                            sys1.addEdge(sys1.getNode(nameInterface),sys1.getNode(data2.result.Name));
                        */
					}
			 	});
		    });
        }
	});   
}

