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
      <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remove User</a>
   </div>
</div>



<div id="dlg" class="easyui-dialog" style="width:400px" data-options="closed:true,modal:true,border:'thin',buttons:'#dlg-buttons'">
      <form id="fm" method="post" novalidate style="margin:0;padding:20px 50px">
         <h3>User Information</h3>
         <div style="margin-bottom:10px">
            <input name="firstname" class="easyui-textbox" required="true" label="First Name:" style="width:100%">
         </div>
         <div style="margin-bottom:10px">
            <input name="lastname" class="easyui-textbox" required="true" label="Last Name:" style="width:100%">
         </div>
         <div style="margin-bottom:10px">
            <input name="phone" class="easyui-textbox" required="true" label="Phone:" style="width:100%">
         </div>
         <div style="margin-bottom:10px">
            <input name="email" class="easyui-textbox" required="true" validType="email" label="Email:" style="width:100%">
         </div>
      </form>
   </div>
   <div id="dlg-buttons">
      <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
   </div>
   <script type="text/javascript">
      var url;

      function newUser() {
         $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'New User');
         $('#fm').form('clear');
         url = 'save_user.php';
      }

      function editUser() {
         var row = $('#dg').datagrid('getSelected');
         if (row) {
            $('#dlg').dialog('open').dialog('center').dialog('setTitle', 'Edit User');
            $('#fm').form('load', row);
            url = 'update_user.php?id=' + row.id;
         }
      }

      function saveUser() {
         $('#fm').form('submit', {
            url: url,
            iframe: false,
            onSubmit: function() {
               return $(this).form('validate');
            },
            success: function(result) {
               var result = eval('(' + result + ')');
               if (result.errorMsg) {
                  $.messager.show({
                     title: 'Error',
                     msg: result.errorMsg
                  });
               } else {
                  $('#dlg').dialog('close'); // close the dialog
                  $('#dg').datagrid('reload'); // reload the user data
               }
            }
         });
      }

      function destroyUser() {
         var row = $('#dg').datagrid('getSelected');
         if (row) {
            $.messager.confirm('Confirm', 'Are you sure you want to destroy this user?', function(r) {
               if (r) {
                  $.post('destroy_user.php', {
                     id: row.id
                  }, function(result) {
                     if (result.success) {
                        $('#dg').datagrid('reload'); // reload the user data
                     } else {
                        $.messager.show({ // show error message
                           title: 'Error',
                           msg: result.errorMsg
                        });
                     }
                  }, 'json');
               }
            });
         }
      }
   </script>
HTML;
