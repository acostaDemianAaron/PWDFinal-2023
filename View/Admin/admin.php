<?php
include_once("../../Config/config.php");
new Header("Admin", $DIRS);

echo <<<HTML

<div class="container">
   <h2>Cambiar estado de compras</h2>
   <p>Dentro de esta tabla se visualizan y cambian los estados de las compras.</p>

   <table id="dg" title="Compras" class="easyui-datagrid" style="width:100%;height:500px"
      url="Action/load_usuario.php" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true">
      <thead>
         <tr id="menu-fields">
            <th field="idusuario" width="10">ID Usuario</th>
            <th field="usnombre" width="30">Nombre</th>
            <th field="usmail" width="30">Mail</th>
            <th field="usdeshabilitado" width="30">Estado</th>
            <th field="rol" width="30">Rol</th>
         </tr>
      </thead>
   </table>
   <div id="toolbar">
      <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">New User</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Edit User</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="disableUser()">Remove User</a>
   </div>
</div>

<!--Crear nuevo usuario-->
<div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
   <div class="ftitle">User Information</div>
   <form id="fm" method="post" novalidate>
      <div class="fitem">
         <label>Name:</label>
         <input name="usnombre" class="easyui-textbox" required="true">
      </div>
      <div class="fitem">
         <label>Password:</label>
         <input name="uspass" class="easyui-textbox" required="true">
      </div>
      <div class="fitem">
         <label>Mail:</label>
         <input name="usmail" class="easyui-textbox" validType="email">
      </div>
      <div class="fitem">
         <label>Rol:</label>
         <div>
            <input class="easyui-radiobutton" name="idrol" value="1" label="Admin:">
         </div>
         <div>
            <input class="easyui-radiobutton" name="idrol" value="2" label="Deposito:">
         </div>
         <div>
            <input class="easyui-radiobutton" name="idrol" value="3" label="Usuario:">
         </div>
      </div>
   </form>
</div>

<div id="dlg-buttons">
   <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>

<script>
   function newUser() {
      $('#dlg').dialog('open').dialog('setTitle', 'New User');
      $('#fm').form('clear');
      url = 'Action/save_usuario.php';
   }

   function saveUser(){
      $('#fm').form('submit',{
         url: url,
         onSubmit: function(){
            return $(this).form('validate');
         },
         success: function(result){
            console.log(result);
            if (result.errorMsg){
               $.messager.show({
                  title: 'Error',
                  msg: result.errorMsg
               });
            } else {
                  $('#dlg').dialog('close');
                  $('#dg').datagrid('reload');
            }
         }
      });
   }

function editUser(){
   var row = $('#dg').datagrid('getSelected');
   if (row){
      $('#dlg').dialog('open').dialog('setTitle','Edit User');
      $('#fm').form('load',row);
      url = 'Action/update_usuario.php?idusuario='+row.idusuario;
   }
}

function disableUser(){
   var row = $('#dg').datagrid('getSelected');
   if (row){
      $.messager.confirm('Confirm','Are you sure you want to destroy this user?',function(r){
            if (r){
               $.post('Action/disableUser.php',{idusuario:row.idusuario},function(result){
                  if (result.success){
                     console.log(result)
                       $('#dg').datagrid('reload');    // reload the user data
                  } else {
                        $.messager.show({    // show error message
                           title: 'Error',
                           msg: result.errorMsg
                     });
                  }
               },'json');
         }
      });
   }

}
</script>
HTML;
