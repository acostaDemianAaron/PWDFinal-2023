<?php
include_once("../../Config/config.php");
new Header("Deposito", $DIRS, 2);

echo <<<HTML
<div class="container">
   <h2>Cambiar estado de compras</h2>
   <p>Dentro de esta tabla se visualizan y cambian los estados de las compras.</p>

   <table id="dg" title="Compras" class="easyui-datagrid" style="width:100%;height:500px"
      url="Action/load_deposito.php" toolbar="#toolbar" fitColumns="true" singleSelect="true">
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
      <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="processProducto()">Process Product</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="cancelProducto()">Cancel Product</a>
   </div>


<div class="m-5"></div>
<div class="">
<table class="easyui-datagrid" title="State" style="width:100%;height:300px"
url="Action/load_state.php"  singleSelect="true" data-options="collapsible:true,">
        <thead>
            <tr>
            <th field="idcompra" width="100">ID Compra</th>
            <th field="cofecha" width="230">Fecha de Cambio</th>
            <th field="cefechaini" width="235">Fecha de Estado Inicio</th>
            <th field="cefechaace" width="235">Fecha de Estado Aceptado</th>
            <th field="cefechaevi" width="235">Fecha de Estado Enviado</th>
            <th field="cefechacan" width="235">Fecha de Estado Cancelado</th>
            </tr>
        </thead>
    </table> 
    </div>
    </div>
<script>
function processProduct(){
   $('#dlg').dialog('open').dialog('setTitle', 'Edit Product');
   $('#fm').form('clear');
   url = 'Action/process_producto.php';
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


function cancelProducto(){
var row = $('#dg').datagrid('getSelected');
if (row){
   $.messager.confirm('Confirm','Are you sure you want to cancel the product?',function(r){
         if (r){
            $.post('Action/cancel_producto.php',{idcompra:row.idcompra},function(result){
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

new Footer;
