<?php
include_once("../../Config/config.php");
new Header("Compras", $DIRS, 3);


echo <<<HTML
<div class="container">
   <h2>Historial de compras</h2>
   <p>Dentro de esta tabla se visualizan y el historial de compras de cada usuario.</p>

   <table id="dg" title="Compras" class="easyui-datagrid" style="width:100%;height:500px"
      url="Action/ver_compras.php" toolbar="#toolbar" fitColumns="true" singleSelect="true">
      <thead>
         <tr id="menu-fields">
            <th field="cetdescripcion" width="30">Estado Compra</th>
            <th field="cefechaini" width="30">Fecha de Estado</th>
            <th field="cofecha" width="30">Fecha Inicio Compra</th>
            <th field="proprecio" width="30">Precio</th>
         </tr>
      </thead>
   </table>
   <div id="toolbar">
      <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="cancelProducto()">Cancel Order</a>
   </div>
</div>

<script>
function cancelProducto(){
var row = $('#dg').datagrid('getSelected');
if (row){
   $.messager.confirm('Confirm','Are you sure you want to cancel the order?',function(r){
         if (r){
            $.post('Action/cancel_compras.php',{idcompra:row.idcompra},function(result){
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