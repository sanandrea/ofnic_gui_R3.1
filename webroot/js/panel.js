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
		
		var switchNumber=0;
		$.getJSON("./?a=ws&wspath=controlpanel_userroles",  function( data2 ) {
			$.each(data2.result.user_roles, function(j,user){
				$('#roleBody').append('<tr id="'+user.User+'"><th>'+user.User+
						'<a class="btn btn-danger btn-xs pull-right" href=javascript:deleteUser("'+user.User+
                        '");><i class="glyphicon glyphicon-trash"></i></a></th></tr>');
				$.each(roles,function(i,r){
					switchNumber++;
					if (($.inArray(r.Name, user.Roles) > -1)&&(r.Name != 'Readonly')){
						$('#'+user.User).append('<th class="success"> <div class="make-switch has-switch" data-on="success" data-off="warning">'+
								'<div id="swtch'+switchNumber+'" '+
								'onclick="javascript:deleteRoleUser(\''+user.User+'\',\''+r.Name+'\',\''+switchNumber+'\')"'+
								' "class="switch-on switch-animate"><input type="checkbox" checked=""><span class="switch-left switch-success">ON</span>'+
								'<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
						'</div></th>');
					}else if (($.inArray(r.Name, user.Roles) < 0)&&(r.Name != 'Readonly')) {
						$('#'+user.User).append('<th class="success"> <div class="make-switch has-switch" data-on="success" data-off="warning">'+
								'<div id="swtch'+switchNumber+'" '+
								'onclick="javascript:addRoleUser(\''+user.User+'\',\''+r.Name+'\',\''+switchNumber+'\')"'+
								'class="switch-off switch-animate"><input type="checkbox" unchecked=""><span class="switch-left switch-success">ON</span>'+
								'<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
						'</div></th>');
					}else{
						$('#'+user.User).append('<th class="success"> <div class="make-switch has-switch deactivate" data-on="success" data-off="warning">'+
								'<div id="swtch'+switchNumber+'" '+
								'class="switch-on switch-animate"><input type="checkbox" checked=""><span class="switch-left switch-success">ON</span>'+
								'<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
						'</div></th>');
					}
				});
				
			});
			$('#panel').append('<div class="row">'+
					'<div class="col-lg-4">'+
					'<h2>Add User</h2>'+
					'<input type="username" class="form-control" id="userlabel" placeholder="Username">'+
					'<span class="help-block"></span>'+
					'<input type="password" class="form-control" id="pwdlabel" placeholder="password">'+
					'<span class="help-block"></span>'+
					'<button class="btn btn-primary" onclick="javascript:addUser(); return false;" type="button">Add</button>'+
					'</div><!-- /.col-lg-6 --> </div>'
			);
		});
	});

}

function addUser(){
  var user = $('#userlabel').val();
  var pass = $('#pwdlabel').val();
  
  if ((user === '')||(pass === ''))
    return;

  $.ajax({
        type: "POST",
        url: "./?a=register",
        data: {uid: user, pwd: pass},
        error: function() {
          alert("ERROR! Capability couldn't be added. Try again!");
        },
        success: function(data) {
        	//console.log(data);
        	appendUser(user);
        }
      });
  $('#userlabel').val('');
  $('#pwdlabel').val('');
  return false;
}

function appendUser(user){
	var switchNumber = totalSwitches;
	$('#roleBody').append('<tr id="'+user+'"><th>'+user+
			'<a class="btn btn-danger btn-xs pull-right" href=javascript:deleteUser("'+user+
	'");><i class="glyphicon glyphicon-trash"></i></a></th></tr>');
	$('#roleHead > th').each(function(i,item){
		var roleName = $(item).text();
		if (!(roleName === 'Alias')){
			switchNumber++;
			if (roleName === 'Readonly'){
				$('#'+user).append('<th class="success"> <div class="make-switch has-switch deactivate" data-on="success" data-off="warning">'+
						'<div id="swtch'+switchNumber+'" '+
						'class="switch-on switch-animate"><input type="checkbox" checked=""><span class="switch-left switch-success">ON</span>'+
						'<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
				'</div></th>');
			}else{
				$('#'+user).append('<th class="success"> <div class="make-switch has-switch" data-on="success" data-off="warning">'+
						'<div id="swtch'+switchNumber+'" '+
						'onclick="javascript:addRoleCap(\''+user+'\',\''+roleName+'\',\''+switchNumber+'\')"'+
						'class="switch-off switch-animate"><input type="checkbox" unchecked=""><span class="switch-left switch-success">ON</span>'+
						'<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
				'</div></th>');
			}
		}
	});
}
function addRoleUser(u,r,n){
	console.log("switch number is: "+ n);
	$.ajax({
		
		type: "POST",
		url: "./?a=ws&wspath=controlpanel_user_"+u+"_roles_"+r,
		data: {user: u, newrole: r},
		error: function() {
			alert("ERROR! Role couldn't be added. Try again!");
			return false;
		},
		success: function(data) {
			console.log(data);
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
		url: "./?a=ws&wspath=controlpanel_user_"+u+"_roles_"+r,
		data: {user: u, role: r},
		error: function() {
			alert("ERROR! Role couldn't be removed! Try again.");
			return false;
		},
		success: function(data) {
			console.log(data);
			waitingForResponse = false;
			$('#swtch'+n).removeClass('switch-on');
			$('#swtch'+n).addClass('switch-off');
			$('#swtch'+n).attr('onclick','javascript:addRoleUser(\''+u+'\',\''+r+'\',\''+n+'\')');
			waitingForResponse = true;  
		}
	});	
}

function deleteUser(user){
$.ajax({

      type: "DELETE",
      url: "./?a=ws&wspath=controlpanel_user_"+user,
      error: function() {
        alert("ERROR! User couldn't be deleted. Try again!");
      },
      success: function(data) {
    	$('#'+user).remove();
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
var totalSwitches = 0;
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
			$.each(data.result.roles, function(j,role){
				$('#capBody').append('<tr id="role_'+role.Role+'"><th>'+role.Role+
                                '<a class="btn btn-danger btn-xs pull-right" href=javascript:deleteRole("'+role.Role+
                                '");><i class="glyphicon glyphicon-trash"></i></a></th></tr>');
				$.each(caps,function(i,cap){
					switchNumber++;					
					if (($.inArray(cap.Name, role.Caps) > -1)&&(cap.Name != 'GET')){
						$('#role_'+role.Role).append('<th class="success"> <div class="make-switch has-switch" data-on="success" data-off="warning">'+
			                    '<div id="swtch'+switchNumber+'" '+
			                    'onclick="javascript:deleteRoleCap(\''+role.Role+'\',\''+cap.Name+'\',\''+switchNumber+'\')"'+
			                    ' "class="switch-on switch-animate"><input type="checkbox" checked=""><span class="switch-left switch-success">ON</span>'+
			                    '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
			                    '</div></th>');
					}else if (($.inArray(cap.Name, role.Caps) < 0)&&(cap.Name != 'GET')){
						$('#role_'+role.Role).append('<th class="success"> <div class="make-switch has-switch" data-on="success" data-off="warning">'+
			                    '<div id="swtch'+switchNumber+'" '+
			                    'onclick="javascript:addRoleCap(\''+role.Role+'\',\''+cap.Name+'\',\''+switchNumber+'\')"'+
			                    'class="switch-off switch-animate"><input type="checkbox" unchecked=""><span class="switch-left switch-success">ON</span>'+
			                    '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
			                    '</div></th>');
					}else{
			            $('#role_'+role.Role).append('<th class="success"> <div class="make-switch has-switch deactivate" data-on="success" data-off="warning">'+
			                          '<div id="swtch'+switchNumber+'" '+
			                          //'onclick="javascript:addRoleCap(\''+role.Role+'\',\''+cap.Name+'\',\''+switchNumber+'\')"'+
			                          'class="switch-on switch-animate"><input type="checkbox" checked=""><span class="switch-left switch-success">ON</span>'+
			                          '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
			                          '</div></th>');
					}
				});
				
			});
      totalSwitches = switchNumber;
      //displayNoCapRoles();
      $('#panel').append('<div class="row">'+
                        '<div class="col-lg-4">'+
                        '<h2>Add role</h2>'+
                        '<div class="input-group">'+
                        '<span class="input-group-btn">'+
                        '<button class="btn btn-primary" onclick="javascript:addRole(); return false;" type="button">Add</button></span>'+
                        '<input type="username" class="form-control" id="userlabel" placeholder="Role name">'+
                        '</div><!-- /input-group -->'+
                        '</div><!-- /.col-lg-6 --> </div>'
                        );
		});
		
	});
  
}


// function displayNoCapRoles(){
//   $.getJSON("./?a=ws&wspath=controlpanel_editableroles", function (data){
//     var switchNumber = totalSwitches;
//     $.each(data.result.roles, function(i,role){
//       var found = false;
//       $('#capBody > tr').each(function(i,item){
//         var roleName = $(item).attr('id').substring(5);
//         if (role.Name === roleName)
//           found = true;
//       });
//       if (!found){
//         $('#capBody').append('<tr id="role_'+role.Name+'"><th>'+role.Name+
//                                 '<a class="btn btn-danger btn-xs pull-right" href=javascript:deleteRole("'+role.Name+
//                                 '");><i class="glyphicon glyphicon-trash"></i></a></th></tr>');
//         $('#capHead > th').each(function(i,item){
//           var capName = $(item).text();
//           if (!(capName === 'Alias')){
//             switchNumber++;
//             $('#role_'+role.Name).append('<th class="success"> <div class="make-switch has-switch" data-on="success" data-off="warning">'+
//                           '<div id="swtch'+switchNumber+'" '+
//                           'onclick="javascript:addRoleCap(\''+role.Name+'\',\''+capName+'\',\''+switchNumber+'\')"'+
//                           'class="switch-off switch-animate"><input type="checkbox" unchecked=""><span class="switch-left switch-success">ON</span>'+
//                           '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
//                           '</div></th>');
//             }
//           });
//       }
//     });
//   });
// }
function appendRole(role){
  var switchNumber = totalSwitches;
  $('#capBody').append('<tr id="role_'+role+'"><th>'+role+
                              '<a class="btn btn-danger btn-xs pull-right" href=javascript:deleteRole("'+role+
                              '");><i class="glyphicon glyphicon-trash"></i></a></th></tr>');
  $('#capHead > th').each(function(i,item){
    var capName = $(item).text();
    if (!(capName === 'Alias')){
      switchNumber++;
      if (capName === 'GET'){
        $('#role_'+role).append('<th class="success"> <div class="make-switch has-switch deactivate" data-on="success" data-off="warning">'+
                    '<div id="swtch'+switchNumber+'" '+
                    'class="switch-on switch-animate"><input type="checkbox" unchecked=""><span class="switch-left switch-success">ON</span>'+
                    '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
                    '</div></th>');
      }else{
        $('#role_'+role).append('<th class="success"> <div class="make-switch has-switch" data-on="success" data-off="warning">'+
                    '<div id="swtch'+switchNumber+'" '+
                    'onclick="javascript:addRoleCap(\''+role+'\',\''+capName+'\',\''+switchNumber+'\')"'+
                    'class="switch-off switch-animate"><input type="checkbox" unchecked=""><span class="switch-left switch-success">ON</span>'+
                    '<label>&nbsp;</label><span class="switch-right switch-warning">OFF</span></div>'+
                    '</div></th>');
      }
    }
  });
}

function addRole(){
  var role = $('#userlabel').val();
  if (role === '')
    return;

  $.ajax({
        type: "POST",
        url: "./?a=ws&wspath=controlpanel_role_create_"+role,
        error: function() {
          alert("ERROR! Capability couldn't be added. Try again!");
        },
        success: function() {
          appendRole(role);
        }
      });
  $('#userlabel').val('');
  return false;
}

function deleteRole(role){
$.ajax({

      type: "DELETE",
      url: "./?a=ws&wspath=controlpanel_role_"+role,
      error: function() {
        alert("ERROR! Role couldn't be deleted. Try again!");
      },
      success: function() {
        console.log("removing");
        $('#role_'+role).remove();
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