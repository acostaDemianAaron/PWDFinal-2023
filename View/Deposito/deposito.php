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
      <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">New Product</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="processProducto()">Process Product</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="cancelProducto()">Cancel Product</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="disableUser()">Disable Product</a>
   </div>
</div>


<!--Crear nuevo producto-->
<div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px" closed="true" buttons="#dlg-buttons">
   <form id="fm" method="post" novalidate>
      <div class="fitem">
         <label>Estado compra</label>
         <input name="cetdescripcion" class="easyui-textbox" required="true" disabled>
      </div>
      <div class="fitem">
         <label>Fecha Estado</label>
         <input name="cefechaini" class="easyui-textbox" required="true" disabled>
      </div>
      <div class="fitem">
         <label>Fecha Inicio Compra</label>
         <input name="cetdescripcion" class="easyui-textbox" required="true" disabled>
      </div>
      <div class="fitem">
         <label>Usuario</label>
         <input name="cofecha" class="easyui-textbox" required="true" disabled>
      </div>
      <div class="fitem">
         <label>Usuario</label>
         <input name="cofecha" class="easyui-textbox" required="true" disabled>
      </div>
   </form>
</div>
<div id="dlg-buttons">
   <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="processProducto()" style="width:150px">Procesar Envio</a>
   <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="saveUser()" style="width:150px">Cancelar Envio</a>
</div>

<script>
   function processProduct(){
      $('#dlg').dialog('open').dialog('setTitle', 'Edit Product');
      $('#fm').form('clear');
      url = 'Action/update_producto.php';
   }


   function saveProduct(){
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


   function processProducto(){
   var row = $('#dg').datagrid('getSelected');
   if (row){
      $.messager.confirm('Confirm','Are you sure you want to process the product?',function(r){
            if (r){
               $.post('Action/process_producto.php',{idcompra:row.idcompra},function(result){
                  if (result.success){
                     console.log(result)
                       //$('#dg').datagrid('reload');    // reload the user data
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


function cancelProducto(){
   var row = $('#dg').datagrid('getSelected');
   if (row){
      $.messager.confirm('Confirm','Are you sure you want to cancel the product?',function(r){
            if (r){
               $.post('Action/cancel_producto.php',{idcompra:row.idcompra},function(result){
                  if (result.success){
                     console.log(result)
                       //$('#dg').datagrid('reload');    // reload the user data
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