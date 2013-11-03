var selectedContent = null;


function setContent(val){
    
   $("#viewport").height(350); //put canvas height back to 350 if case 3 or 4 put it to 0 to show admin tools (check case 3 and 4)
    
   switch (val)
  {
	  case 0:
            $('#content').html("<div id='left' class='span5'> </div><div id='right' class='span7'> <div  class='span5' id='port_info' > </div><div id='graph_info'></div><canvas id='viewport1'></canvas></div>");
	
	    //grafo secondario
            sys1 = arbor.ParticleSystem(1000); // creo un sistema di particelle
	    sys1.parameters({gravity:true}); // includo la gravità
	    sys1.renderer = Renderer("#viewport1"); //inizio a disegnare nel viewport	      
	
	    if(nodesOfPath!=null)eraseVirtualPathLine(openedPath);
	    nodeSelectBefore = null;
	    selectedContent = 0;
	    statOption = 0;
	    addVirtualPath = false;
	    clearInterval(pathTimer);
	    clearInterval(timerStat);
	    $("li").removeClass("active");
	    $("li::eq(0)").addClass("active");
	    $('#menuPath').hide();
		addVirtualPath = false;
	    break;
	  case 1:
	    $('#content').html("<div class='span12' style='margin-bottom:25px;'><div class='btn-group' data-toggle='buttons-radio'><button id='portStat' class='btn btn-blue' onClick=activeGetPortStat()>Get Port Statistics</button><button id='pathStatDisplay' class='btn btn-blue' onClick=displayMonitorStat()>Get Monitor Statistic</button><button id='addPathMonitor' class='btn btn-blue' onClick=activeAddPathStat()>Add Monitor to a Path</button></div> </div><div id='statistics' class='span12'></div>");

	    if(nodesOfPath!=null)eraseVirtualPathLine(openedPath);
	    nodeSelectBefore = null;
	    clearInterval(pathTimer);
	    clearInterval(timerStat);
    	    selectedContent = 1;
	    statOption = 0;
	    addVirtualPath = false;
	    $("li").removeClass("active");
	    $("li::eq(1)").addClass("active");
	    displayMonitorStat();
	    $('#pathStatDisplay').addClass('active');
	    $('#menuPath').hide();
		addVirtualPath = false;
	    break;
	  case 2:
	    $('#content').html("<div class='span12' style='margin-bottom:25px;'><button id = 'addPath' value='addPath' class='btn btn-blue' onClick='activeMenuPath();'>Add new Virtual Path</button> </div><div id='virtualPath' class='span12'></div>");
	    
            displayVirtualPath();
	    if(nodesOfPath!=null)eraseVirtualPathLine(openedPath);
	    selectedContent = 2;
	    nodeSelectBefore = null;
	    statOption = 0;
	    pathTimer = setInterval(timerVirtualPath,10000);
	    clearInterval(timerStat);
	    $("li").removeClass("active");
	    $("li::eq(2)").addClass("active");
   	    $('#menuPath').hide();
		addVirtualPath = false;
	    break;
	 case 3:
	    $("#viewport").height(0);
	    $("li").removeClass("active");
	    $("li::eq(3)").addClass("active");
	    $('#content').html("<form id='userdata' name='login' action='"+serverPath+"/netic.v1/login' method='post'>"+
                            "Username: <input type='text' name='username' id='username'/><br>"+
                            "Password: <input type='password' name='password' id='pw'/></br>"+
                            "<input type='button' value='Login' onclick=log(); /></form></br>"+
                            "<h3>Register to the webservice:</h3>"+
                            "<form id='newuserdata' name='register' action='"+serverPath+"/netic.v1/register' method='post'>"+
                            "Username: <input type='text' name='username' id='newusername'/></br>"+
                            "Password: <input type='password' name='password' id='newpw'/></br>"+
                            "<input type='button' value='Register' onclick=reg(); /></form></br>");                         
        break;
	 case 4:
	    $("#viewport").height(0);
	    $("li").removeClass("active");
	    $("li::eq(4)").addClass("active");
	    $('#content').html("<div class='span12' style='margin-bottom:25px;'><div class='btn-group' data-toggle='buttons-radio'>"+
	                        "<button class='btn btn-blue' onClick=getUsers()    id='userButton' >Edit User Roles</button>"+
	                        "<button class='btn btn-blue' onClick=getRes()      id='resButton'  >Edit Resources</button>"+
	                        "<button class='btn btn-blue' onClick=getRoles()    id='rolesButton'>Edit Editable-Roles</button>"+
	                        "</div> </div><div id='panel' class='span12'></div>");
	    break;
        
  }
}



