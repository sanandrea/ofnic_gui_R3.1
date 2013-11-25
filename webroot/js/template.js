var selectedContent = null;

function alertMessage(mess,success){
	$('#messageBox').append('<p>'+mess+'</p>');
	if (success){
		$('#messageBox').addClass('alert alert-success in');
	}else{
		$('#messageBox').addClass('alert alert-danger in');
	}	
	$('#messageBox').fadeIn();
	setTimeout(function () { $("#messageBox").removeClass('alert alert-danger alert-success in'); $("#messageBox").empty();}, 4000);
}

function setContent(val){
    
   //$("#viewport").height(350); //put canvas height back to 350 if case 3 or 4 put it to 0 to show admin tools (check case 3 and 4)
    
   switch (val)
  {
	  case 0:
        //$('#content').html("<div id='left' class='col-md-5'> </div><div id='right' class='col-md-7'> <div  class='col-md-5' id='port_info' > </div><div id='graph_info'></div><canvas id='viewport1'></canvas></div>");
        
	    //grafo secondario
        /*
        sys1 = arbor.ParticleSystem(1000); // creo un sistema di particelle
        sys1.parameters({gravity:false}); // escludo la gravità
    	sys1.parameters({ friction: '1.0' });
	    sys1.renderer = Renderer("#viewport1"); //inizio a disegnare nel viewport
		*/
		
	    if(nodesOfPath!=null)eraseVirtualPathLine(openedPath);
	    nodeSelectBefore = null;
	    selectedContent = 0;
	    statOption = 0;
	    addVirtualPath = false;
	    clearInterval(pathTimer);
	    clearInterval(timerStat);
	    $('#menuPath').hide();
		addVirtualPath = false;
	    break;
	  case 1:
	    //$('#content').html("<div class='col-md-12' style='margin-bottom:25px;'><div class='btn-group' data-toggle='buttons-radio'><button id='portStat' class='btn btn-blue' onClick=activeGetPortStat()>Get Port Statistics</button><button id='pathStatDisplay' class='btn btn-blue' onClick=displayMonitorStat()>Get Monitor Statistic</button><button id='addPathMonitor' class='btn btn-blue' onClick=activeAddPathStat()>Add Monitor to a Path</button></div> </div><div id='statistics' class='span12'></div>");
		displayVirtualPathStat();

	    if(nodesOfPath!=null)eraseVirtualPathLine(openedPath);
	    nodeSelectBefore = null;
	    clearInterval(pathTimer);
	    clearInterval(timerStat);
    	    selectedContent = 1;
	    statOption = 1;
	    addVirtualPath = false;
	    displayMonitorStat();
	    $('#pathStatDisplay').addClass('active');
	    $('#menuPath').hide();
		addVirtualPath = false;
	    break;
	  case 2:
	    //$('#content').html("<div class='col-md-5'><button id = 'addPath' value='addPath' class='btn btn-primary' onClick='activeMenuPath();'>Add new Virtual Path</button></div><div id='virtualPath' class='col-md-5'></div>");
	    
        displayVirtualPath();
	    if(nodesOfPath!=null)eraseVirtualPathLine(openedPath);
	    selectedContent = 2;
	    nodeSelectBefore = null;
	    statOption = 0;
	    pathTimer = setInterval(timerVirtualPath,10000);
	    //clearInterval(timerStat);
   	    $('#menuPath').hide();
		addVirtualPath = false;
	    break;
	 case 4:
	    $('#content').html("<div class='col-md-12'><div class='btn-group'>"+
	                        "<button class='btn btn-primary' onClick=getUsers()    id='userButton' >Edit User Roles</button>"+
	                        "<button class='btn btn-primary' onClick=getRes()      id='resButton'  >Browse Resources</button>"+
	                        "<button class='btn btn-primary' onClick=getRoles()    id='rolesButton'>Edit Editable-Roles</button>"+
	                        "</div> </div><div id='panel' class='col-md-12'></div>");
	    break;
        
  }
}



