/*
 *  For EditUsers
 */
function getUsers(){
	var roles;
	$.getJSON("./?a=ws&wspath=controlpanel_role", function (data1){
		roles = data1.result.roles;
		$('#panel').html('<table class="table"><thead><tr id="roleHead"></tr></thead><tbody id="roleBody"></tbody></table>');
		$('#roleHead').append('<th>Alias</th>');
		$.each(data1.result.roles, function (i,role){
			$('#roleHead').append('<th>'+role.Name+'</th>');
		});
	});

	var switchNumber=0;
	$.getJSON("./?a=ws&wspath=controlpanel_userroles",  function( data2 ) {
		$.each(data2.result.user_roles, function(j,user){
			$('#roleBody').append('<tr id="'+user.User+'"><th>'+user.User+'</th></tr>');
			$.each(roles,function(i,r){
				switchNumber++;
				if ($.inArray(r.Name, user.Roles) > -1){
					$('#'+user.User).append('<th class="success"> <div class="make-switch has-switch" data-on="success" data-off="warning">'+
		                    '<div id="swtch'+switchNumber+'" '+
		                    'onclick="javascript:deleteRoleUser(\''+user.User+'\',\''+r.Name+'\',\''+switchNumber+'\')"'+
		                    ' "class="switch-on switch-animate"><input type="checkbox" checked=""><span class="switch-left switch-success">ON</span>'+
		                    '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
		                    '</div></th>');
				}else{
					$('#'+user.User).append('<th class="success"> <div class="make-switch has-switch" data-on="success" data-off="warning">'+
		                    '<div id="swtch'+switchNumber+'" '+
		                    'onclick="javascript:addRoleUser(\''+user.User+'\',\''+r.Name+'\',\''+switchNumber+'\')"'+
		                    'class="switch-off switch-animate"><input type="checkbox" unchecked=""><span class="switch-left switch-success">ON</span>'+
		                    '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
		                    '</div></th>');
				}
			});
			
		});
    });
}

function addRoleUser(u,r,n){
	console.log("switch number is: "+ n);
	$.ajax({
		
		type: "POST",
		url: "./?a=ws&wspath=controlpanel_userroles_"+u+"_roles_"+r,
		data: {user: u, newrole: r},
		error: function() {
			alert("ERROR! Role couldn't be added. Try again!");
			return false;
		},
		success: function() {
			$('#swtch'+n).removeClass('switch-off');
			$('#swtch'+n).addClass('switch-on');	
			$('#swtch'+n).attr('onclick','javascript:deleteRoleUser(\''+u+'\',\''+r+'\',\''+n+'\')');
		}
	});	
}

function deleteRoleUser(u,r,n){
	console.log("switch number is: "+ n);
	$.ajax({
		
		type: "DELETE",
		url: "./?a=ws&wspath=controlpanel_userroles_"+u+"_roles_"+r,
		data: {user: u, role: r},
		error: function() {
			alert("ERROR! Role couldn't be removed! Try again.");
			return false;
		},
		success: function() {
			waitingForResponse = false;
			$('#swtch'+n).removeClass('switch-on');
			$('#swtch'+n).addClass('switch-off');
			$('#swtch'+n).attr('onclick','javascript:addRoleUser(\''+u+'\',\''+r+'\',\''+n+'\')');
			waitingForResponse = true;  
		}
	});	
}

function deleteUser(){
user=$("#del_user").val();
$.ajax({

      type: "DELETE",
      url: "./?a=ws&wspath=controlpanel_user_"+user,
      error: function() {
        alert("ERROR! User couldn't be deleted. Try again!");
      },
      success: function() {
        getUsers();      
     }
      
    });
}


/*
 *  For EditResources
 */
 
function getRes(){
	var caps;
	$.getJSON("./?a=ws&wspath=controlpanel_caps", function (data){
		caps = data.result.caps;
		$('#panel').html('<table class="table"><thead><tr id="capHead"></tr></thead><tbody id="capBody"></tbody></table>');
		$('#capHead').append('<th>Alias</th>');
		$.each(data.result.caps, function (i,cap){
			$('#capHead').append('<th>'+cap.Name+'</th>');
		});
		
		var switchNumber=0;
		$.getJSON( "./?a=ws&wspath=controlpanel_res",  function( data ) {
			console.log(data);
			$.each(data.result.res, function(j,resource){
				$('#capBody').append('<tr id="path'+j+'"><th>'+resource.Path+'</th></tr>');
				$.each(caps,function(i,cap){
					switchNumber++;
					
					// very tricky here ids are the list of ids that matches 
					// with the list of Caps.
					index = $.inArray(cap.Name, resource.Caps);
					
					if ($.inArray(cap.Name, resource.Caps) > -1){
						tableKey = resource.IDs[index];
						$('#path'+j).append('<th class="success"> <div class="make-switch has-switch deactivate" data-on="success" data-off="warning">'+
			                    '<div id="swtch'+switchNumber+'" '+
			                    ' "class="switch-on switch-animate"><input type="checkbox" checked=""><span class="switch-left switch-success">ON</span>'+
			                    '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
			                    '</div></th>');
					}else{
						$('#path'+j).append('<th class="warning"> <div class="make-switch has-switch deactivate" data-on="success" data-off="warning">'+
			                    '<div id="swtch'+switchNumber+'" '+
			                    'class="switch-off switch-animate"><input type="checkbox" unchecked=""><span class="switch-left switch-success">ON</span>'+
			                    '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
			                    '</div></th>');
					}
				});
				
			});			
		});
		
		
		
	});
	return;
    
}
/**
 * Unused for the moment
 */
function addResCap(r,c,n){
$.ajax({

      type: "POST",
      url: "./?a=ws&wspath=controlpanel_res_"+r+"_caps_"+c,
      error: function() {
        alert("ERROR! Capability couldn't be added. Try again!");
      },
      success: function() {
        getRes();      
      }
    });	
}
/**
 * Unused for the moment
 */
function deleteResCap(r,c,n){
$.ajax({

      type: "DELETE",
      url: "./?a=ws&wspath=controlpanel_res_"+r+"_caps_"+c,
      error: function() {
        alert("ERROR! Capability couldn't be removed. Try again!");
      },
      success: function() {
        getRes();      
      }
    });	
}
/**
 * Unused for the moment
 */
function replacePath(path){
    var find = '/';
    var re = new RegExp(find, 'g');
    path=path.replace(re, ':');
    return path
}

/*
 *  For EditRoles
 */
 
function getRoles(){

//$('#panel').html("<h1>Edit Roles</h1><h3>Edit all the Editable Roles adding new capabilities or removing current ones</h3>"+
//"Add new role:<input type='text' id='new'><input type='button' value='Add Role' onclick='addRole();' /></br>"+
//"Delete role:<SELECT id='del_role'></SELECT><input type='button' value='Delete Role' onclick='deleteRole();' />"+
//"<TABLE id='table'><tr align=center><td ><b>ROLE</b></td><td><b>CURRENT CAPABILITIES</b></td><td><b>OTHER CAPABILITIES</b></td></tr></TABLE>");

	
	var caps;
	$.getJSON("./?a=ws&wspath=controlpanel_caps", function (data){
		caps = data.result.caps;
		$('#panel').html('<table class="table"><thead><tr id="capHead"></tr></thead><tbody id="capBody"></tbody></table>');
		$('#capHead').append('<th>Alias</th>');
		$.each(data.result.caps, function (i,cap){
			$('#capHead').append('<th>'+cap.Name+'</th>');
		});
		
		var switchNumber=0;
		$.getJSON( "./?a=ws&wspath=controlpanel_editableroles_caps",  function( data ) {
			console.log(data);
			$.each(data.result.roles, function(j,role){
				$('#capBody').append('<tr id="role'+role.Role+'"><th>'+role.Role+'</th></tr>');
				$.each(caps,function(i,cap){
					switchNumber++;					
					if ($.inArray(cap.Name, role.Caps) > -1){
						$('#role'+role.Role).append('<th class="success"> <div class="make-switch has-switch" data-on="success" data-off="warning">'+
			                    '<div id="swtch'+switchNumber+'" '+
			                    'onclick="javascript:deleteRoleCap(\''+role.Role+'\',\''+cap.Name+'\',\''+switchNumber+'\')"'+
			                    ' "class="switch-on switch-animate"><input type="checkbox" checked=""><span class="switch-left switch-success">ON</span>'+
			                    '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
			                    '</div></th>');
					}else{
						$('#role'+role.Role).append('<th class="success"> <div class="make-switch has-switch" data-on="success" data-off="warning">'+
			                    '<div id="swtch'+switchNumber+'" '+
			                    'onclick="javascript:addRoleCap(\''+role.Role+'\',\''+cap.Name+'\',\''+switchNumber+'\')"'+
			                    'class="switch-off switch-animate"><input type="checkbox" unchecked=""><span class="switch-left switch-success">ON</span>'+
			                    '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
			                    '</div></th>');
					}
				});
				
			});			
		});
		
	});
}

function addRole(){
role=$('#new').val();
$.ajax({

      type: "POST",
      url: "./?a=ws&wspath=controlpanel_role_create_"+role,
      error: function() {
        alert("ERROR! Capability couldn't be added. Try again!");
      },
      success: function() {
        getRoles();      
      }
    });	
}

function deleteRole(){

role=$('#del_role').val();
$.ajax({

      type: "DELETE",
      url: "./?a=ws&wspath=controlpanel_role_"+role,
      error: function() {
        alert("ERROR! Role couldn't be deleted. Try again!");
      },
      success: function() {
        getRoles();      
      }
    });	

}

function addRoleCap(r,c,n){
$.ajax({

      type: "POST",
      url: "./?a=ws&wspath=controlpanel_role_"+r+"_caps_"+c,
      data: {role: r, newcap: c},
      error: function() {
        alert("ERROR! Capability couldn't be added. Try again!");
      },
      success: function() {
    	$('#swtch'+n).removeClass('switch-off');
		$('#swtch'+n).addClass('switch-on');	
		$('#swtch'+n).attr('onclick','javascript:deleteRoleCap(\''+r+'\',\''+c+'\',\''+n+'\')');
      }
    });	
}

function deleteRoleCap(r,c,n){
$.ajax({

      type: "DELETE",
      url: "./?a=ws&wspath=controlpanel_role_"+r+"_caps_"+c,
      data: {cap: c, role: r},
      error: function() {
        alert("ERROR! Capability couldn't be removed! Try again.");
      },
      success: function() {
    	$('#swtch'+n).removeClass('switch-on');
  		$('#swtch'+n).addClass('switch-off');	
  		$('#swtch'+n).attr('onclick','javascript:addRoleCap(\''+r+'\',\''+c+'\',\''+n+'\')');
     }
    });	
}