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
HTML;