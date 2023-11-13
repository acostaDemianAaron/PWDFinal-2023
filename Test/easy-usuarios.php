<?php
include_once("../Config/config.php");
new Header("Change Usuarios", $DIRS, null);

// Example of EasyUI with list-menu.php
echo <<<HTML

<div class="container">
   <h2>Tabla Usuario</h2>
   <p>Showing Users.</p>

   <table id="dg" title="Usuarios" class="easyui-datagrid" style="width:90%;height:300px"
      url="list-menu.php?type=usuario" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true">
      <thead>
         <tr id="menu-fields">
            <th field="idusuario" width="10">ID</th>
            <th field="usnombre" width="50">Nombre</th>
            <th field="uspass" width="50">Pass (encoded)</th>
            <th field="usmail" width="50">Mail</th>
            <th field="usdeshabilitado" width="50">Deshabiltado</th>
         </tr>
      </thead>
   </table>
</div>

HTML;