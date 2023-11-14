<?php
include_once("../../Config/config.php");
new Header("Deposito", $DIRS);

echo <<<HTML
<div class="container">
   <h2>Cambiar estado de compras</h2>
   <p>Dentro de esta tabla se visualizan y cambian los estados de las compras.</p>

   <table id="dg" title="Compras" class="easyui-datagrid" style="width:100%;height:500px"
      url="Action/load_deposito.php" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true">
      <thead>
         <tr id="menu-fields">
            <th field="idcompra" width="10">ID Compra</th>
            <th field="cetdescripcion" width="30">Estado Compra</th>
            <th field="cefechaini" width="30">Fecha de Estado</th>
            <th field="cofecha" width="30">Fecha Inicio Compra</th>
            <th field="usnombre" width="30">Usuario</th>
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