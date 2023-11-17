<?php
include_once("../../Config/config.php");
new Header("Admin", $DIRS, 1);

function selectDirectory(){
   $admin = scandir($_SESSION['ROOT'] . "View/Admin/", 1);
   $adminAction = scandir($_SESSION['ROOT'] . "View/Admin/Action/", 1);
   $base = 'View/Admin/';
   $radioButtons = iterateDirectory($admin, $adminAction, $base);

   $depo = scandir($_SESSION['ROOT'] . "View/Deposito/", 1);
   $depoAction = scandir($_SESSION['ROOT'] . "View/Deposito/Action/", 1);
   $base = 'View/Deposito/';
   $radioButtons .= iterateDirectory($depo, $depoAction, $base);

   $login = scandir($_SESSION['ROOT'] . "View/Login/", 1);
   $loginAction = scandir($_SESSION['ROOT'] . "View/Login/Action/", 1);
   $base = 'View/Login/';
   $radioButtons .= iterateDirectory($login, $loginAction, $base);

   $store = scandir($_SESSION['ROOT'] . "View/Store/", 1);
   $storeAction = scandir($_SESSION['ROOT'] . "View/Store/Action/", 1);
   $base = 'View/Store/';
   $radioButtons .= iterateDirectory($store, $storeAction, $base);

   return $radioButtons;
}

function iterateDirectory($menuRoutes, $menuActions, $base){
   $radioButtons = '';

   // Pop Folder and . and ..
   array_pop($menuRoutes);
   array_pop($menuRoutes);
   array_pop($menuRoutes);
   array_pop($menuActions);
   array_pop($menuActions);
   array_pop($menuActions);
   
   // Menu
   foreach($menuRoutes as $route => $value){
      $radioButtons .= <<<HTML
      <div class="buttons-here">
         <input class="easyui-radiobutton" name="medescripcion" value="{$base}{$value}" label="{$base}{$value}">
      </div>
      HTML;
   }
   
   // Menu
   foreach($menuActions as $route => $value){
      $radioButtons .= <<<HTML
      <div class="buttons-here">
         <input class="easyui-radiobutton" name="medescripcion" value="{$base}Action/{$value}" label="{$base}Action/{$value}">
      </div>
      HTML;
   }

   return $radioButtons;
}

function loadParents(){
   $radioButtons = '';
   $abmMenu = new ABMMenu;
   $arrayMenu = $abmMenu->Search();

   // Menu
   foreach($arrayMenu as $menu){
      $radioButtons .= <<<HTML
      <div class="buttons-here">
         <input class="easyui-radiobutton" name="idpadre" value="{$menu->getIdMenu()}" label="{$menu->getMeNombre()}">
      </div>
      HTML;
   }

   return $radioButtons;
}

$loadParents = loadParents();
$selectDirectory = selectDirectory();

echo <<<HTML

<div class="container">
   <h2>Cambiar estado de compras</h2>
   <p>Dentro de esta tabla se visualizan y cambian los estados de las compras.</p>

   <table id="dg" title="Compras" class="easyui-datagrid" style="width:100%;height:500px"
      url="Action/load_menu.php" toolbar="#toolbar" fitColumns="true" singleSelect="true">
      <thead>
         <tr id="menu-fields">
            <th field="idmenu" width="10">ID Menu</th>
            <th field="menombre" width="30">Nombre</th>
            <th field="medescripcion" width="30">Ref (Descripcion)</th>
            <th field="idpadre" width="30">Id Padre</th>
            <th field="medeshabilitado" width="30">Fecha Deshabiltado</th>
         </tr>
      </thead>
   </table>
   <div id="toolbar">
      <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newMenu()">New Menu</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editMenu()">Edit Menu</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="disableMenu()" hidden>Remove Menu</a>
   </div>
</div>

<!--Crear nuevo usuario-->
<div id="dlg" class="easyui-dialog" style="width:50%;height:80%;padding:10px 20px" closed="true" buttons="#dlg-buttons">
   <div class="ftitle">Menu Information</div>
   <form id="fm" method="post" novalidate>
      <div class="fitem">
         <label>Nombre:</label>
         <input name="menombre" class="easyui-textbox" required="true">
      </div>
      <br>
      <div class="fitem">
         <label>Reference:</label>
         {$selectDirectory}
      </div>
      <br>
      <div class="fitem">
         <label>ID Padre:</label>
         {$loadParents}
      </div>
   </form>
</div>

<div id="dlg-buttons">
   <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMenu()" style="width:90px">Save</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>

<script>
   function newMenu() {
      $('#dlg').dialog('open').dialog('setTitle', 'New User');
      $('#fm').form('clear');
      url = 'Action/save_menu.php';
   }

   function saveMenu(){
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

function editMenu(){
   var row = $('#dg').datagrid('getSelected');
   if (row){
      $('#dlg').dialog('open').dialog('setTitle','Edit User');
      $('#fm').form('load',row);
      url = 'Action/update_menu.php?idmenu='+row.idmenu;
   }
}

function disableMenu(){
   var row = $('#dg').datagrid('getSelected');
   if (row){
      $.messager.confirm('Confirm','Are you sure you want to disable this user?',function(r){
            if (r){
               $.post('Action/disable_menu.php',{idmenu:row.idmenu},function(result){
                  console.log(result)
                  if (result.success){
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


$(document).ready(function(){
   $('.textbox-label').addClass("w-auto")
})
</script>
HTML;

new Footer;