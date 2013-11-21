/*
 *  For EditUsers
 */

function getUsers(){
//	$('#panel').html("<h1>Edit Users</h1><h3>Edit all the Users adding new roles or removing current ones</h3>"+
//	"Delete user: <SELECT id='del_user'></SELECT><input type='button' value='Delete' onclick='deleteUser();'/>"+
//	"<TABLE id='table'><tr align=center><td><b>USER</b></td><td><b>CURRENT ROLES</b></td><td><b>OTHER ROLES</b></td></tr></TABLE>");

	var roles;
	$.getJSON("./?a=ws&wspath=controlpanel_role", function (data){
		roles = data.result.roles;
		$('#panel').html('<table class="table"><thead><tr id="roleHead"></tr></thead><tbody id="roleBody"></tbody></table>');
		$('#roleHead').append('<th>#</th>');
		$.each(data.result.roles, function (i,role){
			$('#roleHead').append('<th>'+role.Name+'</th>');
		});
	});

	$.getJSON("./?a=ws&wspath=controlpanel_userroles",  function( data ) {
		$.each(data.result.user_roles, function(i,user){
			$('#roleBody').append('<tr id="'+user.User+'"><th>'+user.User+'</th></tr>');
			console.log(user.Roles);
			$.each(roles,function(i,r){
//				console.log(r);
//				console.log($.inArray(r.Name, user.Roles));
				if ($.inArray(r.Name, user.Roles) > -1){
					$('#'+user.User).append('<th class="success">ok</th>');
				}else{
					$('#'+user.User).append('<th class="danger">no</th>');
				}
			});
			
		});
		return;
        var i=1;
        var j=2;
        users=data.result.users;
        for (var u in users){
            actual=users[u]["username"];
            $("#del_user").append("<OPTION value='"+actual+"'>"+actual);
            $("#table").append("<tr><td id='user"+i+"'>"+actual+"</td><td>"+
            "<SELECT id='"+i+"' NAME='delrole'></SELECT><input type='button' onclick='deleteRoleUser("+i+")'; value='Delete role'></td>"+
            "<td><SELECT id='"+j+"' NAME='newrole'></SELECT><input type='button' onclick='addRoleUser("+j+");' value='Add Role'></td></tr>");
            appendRoles(actual,i);
            i=i+2;
            appendNoRoles(actual,j);
            j=j+2;
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

function addRoleUser(j){
r=$("#"+j).val();
i=j-1;
u=$("#user"+i).html();
$.ajax({

      type: "POST",
      url: "./?a=ws&wspath=controlpanel_user_"+u+"_roles_"+r,
      data: {user: u, newrole: r},
      error: function() {
        alert("ERROR! Role couldn't be added. Try again!");
      },
      success: function() {
        getUsers();      
      }
    });	
}

function deleteRoleUser(i){
u=$("#user"+i).html();
r=$("#"+i).val();
$.ajax({

      type: "DELETE",
      url: "./?a=ws&wspath=controlpanel_user_"+u+"_roles_"+r,
      data: {user: u, role: r},
      error: function() {
        alert("ERROR! Role couldn't be removed! Try again.");
      },
      success: function() {
        getUsers();      
      }
    });	
}

function appendRoles(u,i){
$.getJSON( "./?a=ws&wspath=controlpanel_user_"+u+"_roles", function( data ) {
        roles=data.result.roles;
        for (var r in roles)
            $("#"+i).append("<OPTION value='"+roles[r]["Role"]+"'>"+roles[r]["Role"]);
    });
}

function appendNoRoles(u,j){
$.getJSON( "./?a=ws&wspath=controlpanel_user_"+u+"_noroles", function( data ) {
        roles=data.result.roles;
        for (var r in roles)
            $("#"+j).append("<OPTION value='"+roles[r]["Name"]+"'>"+roles[r]["Name"]);
           
    });
}

/*
 *  For EditResources
 */
 
function getRes(){
 
$('#panel').html("<h1>Edit Resources</h1><h3>Edit resources adding new required capabilities or removing current ones</h3>"+
"<TABLE id='table'><tr align=center><td><b>RESOURCE</b></td><td><b>CURRENT CAPABILITIES</b></td><td><b>OTHER CAPABILITIES</b></td></tr></TABLE>");

$.getJSON( "./?a=ws&wspath=controlpanel_res",  function( data ) {
		console.log(data);
        var i=1;
        var j=2;
        res=data.result.res;
        for (var r in res){
            actual=res[r]["Path"];
            $("#table").append("<tr><td id='res"+i+"'>"+actual+"</td><td>"+
            "<SELECT id='"+i+"' NAME='delcap'></SELECT><input type='button' onclick='deleteResCap("+i+");' value='Delete cap'></td>"+
            "<td><SELECT id='"+j+"' NAME='newcap'></SELECT><input type='button' onclick='addResCap("+j+");' value='Add cap'></td></tr>");
            appendResCaps(actual,i);
            i=i+2;
            appendResNoCaps(actual,j);
            j=j+2;
            }
           
    });
    
}

function addResCap(j){
c=$("#"+j).val();
i=j-1;
r=$("#res"+i).html();
r=replacePath(r);
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

function deleteResCap(i){
c=$("#"+i).val();
r=$("#res"+i).html();
r=replacePath(r);
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

function appendResCaps(r,i){
r=replacePath(r);
$.getJSON( "./?a=ws&wspath=controlpanel_res_"+r+"_caps", function( data ) {
        caps=data.result.caps;
        for (var cap in caps)
            $("#"+i).append("<OPTION value='"+caps[cap]["Cap"]+"'>"+caps[cap]["Cap"]);
    });
}

function appendResNoCaps(r,j){
r=replacePath(r);
$.getJSON( "./?a=ws&wspath=controlpanel_res_"+r+"_nocaps", function( data ) {       
        caps=data.result.caps;
        for (var cap in caps)
            $("#"+j).append("<OPTION value='"+caps[cap]["Name"]+"'>"+caps[cap]["Name"]);
           
    });
}

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

$('#panel').html("<h1>Edit Roles</h1><h3>Edit all the Editable Roles adding new capabilities or removing current ones</h3>"+
"Add new role:<input type='text' id='new'><input type='button' value='Add Role' onclick='addRole();' /></br>"+
"Delete role:<SELECT id='del_role'></SELECT><input type='button' value='Delete Role' onclick='deleteRole();' />"+
"<TABLE id='table'><tr align=center><td ><b>ROLE</b></td><td><b>CURRENT CAPABILITIES</b></td><td><b>OTHER CAPABILITIES</b></td></tr></TABLE>");

$.getJSON( "./?a=ws&wspath=controlpanel_role_editables",  function( data ) {
              
        var i=1;
        var j=2;
        roles=data.result.roles;
        for (var role in roles){
            actual=roles[role]["Role"];
            $("#del_role").append("<OPTION value='"+actual+"'>"+actual);
            $("#table").append("<tr><td id='role"+i+"'>"+actual+"</td><td>"+
            "<SELECT id='"+i+"' NAME='delcap'></SELECT><input type='button' onclick='deleteRoleCap("+i+")'; value='Delete cap'></td>"+
            "<td><SELECT id='"+j+"' NAME='newcap'></SELECT><input type='button' onclick='addRoleCap("+j+");' value='Add cap'></td></tr>");
            appendRoleCaps(actual,i);
            i=i+2;
            appendRoleNoCaps(actual,j);
            j=j+2;
            }
         
           
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

function addRoleCap(j){
c=$("#"+j).val();
i=j-1;
r=$("#role"+i).html();
$.ajax({

      type: "POST",
      url: "./?a=ws&wspath=controlpanel_role_"+r+"_caps_"+c,
      data: {role: r, newcap: c},
      error: function() {
        alert("ERROR! Capability couldn't be added. Try again!");
      },
      success: function() {
        getRoles();      
      }
    });	
}

function deleteRoleCap(i){
r=$("#role"+i).html();
c=$("#"+1).val();
$.ajax({

      type: "DELETE",
      url: "./?a=ws&wspath=controlpanel_role_"+r+"_caps_"+c,
      data: {cap: c, role: r},
      error: function() {
        alert("ERROR! Capability couldn't be removed! Try again.");
      },
      success: function() {
        getRoles();      
     }
    });	
}  

function appendRoleCaps(r,i){
$.getJSON( "./?a=ws&wspath=controlpanel_role_"+r+"_caps",function( data ) {
        caps=data.result.caps;
        for (var cap in caps)
             $("#"+i).append("<OPTION value='"+caps[cap]["Cap"]+"'>"+caps[cap]["Cap"]);         
    });
}

function appendRoleNoCaps(r,j){
$.getJSON( "./?a=ws&wspath=controlpanel_role_"+r+"_nocaps",function( data ) {
        caps=data.result.caps;
        for (var cap in caps)
            $("#"+j).append("<OPTION value='"+caps[cap]["Name"]+"'>"+caps[cap]["Name"]);     
        
    });
}
