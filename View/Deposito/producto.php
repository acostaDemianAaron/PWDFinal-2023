<?php
include_once("../../Config/config.php");
new Header("Productos", $DIRS, 2);

function selectImg(){
   $radioButtons = '';
   $files = scandir($_SESSION['ROOT'] . "View/Img/", 1);
   array_pop($files);
   array_pop($files);
   foreach($files as $file){
      $radioButtons .= <<<HTML
      <div class="buttons-here">
         <input class="easyui-radiobutton" name="prodetalle" value="{$file}" label="{$file}">
      </div>
      HTML;
   }
   return $radioButtons;
}

$selectImg = fn() => selectImg();

echo <<<HTML
<div class="container">
   <h2>Administrar de productos</h2>
   <p>Dentro de esta tabla se visualizan y cambian los datos de los productos.</p>

   <table id="dg" title="Compras" class="easyui-datagrid" style="width:100%;height:500px"
      url="Action/load_producto.php" toolbar="#toolbar" fitColumns="true" singleSelect="true">
      <thead>
         <tr id="menu-fields">
            <th field="idproducto" width="10">ID</th>
            <th field="proprecio" width="30">Precio</th>
            <th field="pronombre" width="30">Nombre</th>
            <th field="prodetalle" width="30">Imagen</th>
            <th field="procantstock" width="30">Cantidad Stock</th>
         </tr>
      </thead>
   </table>
   <div id="toolbar">
      <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newProduct()">New Product</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editProduct()">Editar</a>
   </div>
</div>

<!--Crear nuevo usuario-->
<div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
   <div class="ftitle">Product Information</div>
   <form id="fm" method="post" novalidate>
      <div class="fitem">
         <label>Nombre:</label>
         <input name="pronombre" class="easyui-textbox" required="true">
      </div>
      <div class="fitem">
         <label>Precio:</label>
         <input name="proprecio" class="easyui-textbox" required="true">
      </div>
      <div class="fitem">
         <label>Cantidad Stock:</label>
         <input name="procantstock" class="easyui-textbox">
      </div>
      <div class="fitem">
         <label>Imagen:</label>
         {$selectImg()}
      </div>
   </form>
</div>

<div id="dlg-buttons">
   <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveProduct()" style="width:90px">Save</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
</div>

<script>
function newProduct(){
   $('#dlg').dialog('open').dialog('setTitle', 'New Product');
   $('#fm').form('clear');
   url = 'Action/save_producto.php';
}

function editProduct(){
   var row = $('#dg').datagrid('getSelected');
   if (row){
      $('#dlg').dialog('open').dialog('setTitle','Edit Product');
      $('#fm').form('load',row);
      url = 'Action/edit_producto.php?idproducto='+row.idproducto;
   }
}

function saveProduct(){
   $('#fm').form('submit',{
      url: url,
      onSubmit: function(){
         return $(this).form('validate');
      },
      success: function(result){
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

$(document).ready(function(){
   $('.textbox-label').addClass("w-auto")
})
</script>
HTML;