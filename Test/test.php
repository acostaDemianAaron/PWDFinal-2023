<?php
include_once("../Config/config.php");
new Header("Test Page", $DIRS, null);

// { Turn to SHA512/256
   $passAdmin = hash("SHA512/256", "admin");
   $passUser = hash("SHA512/256", "usuario");
   $passDepo = hash("SHA512/256", "deposito");
// }

// { Testing with MENU

   // Getting data directly from model. Test
   // $menu = new Menu;
   // $data = $menu->List();
   // print_r($data);

   // Getting data directly from Database.
   $menuModel = new Menu;
   $manuArray = $menuModel->List();
   // print_r($data);

   function showData($data){
      $blockText = "";
      $i = 0;
      foreach($data as $entry){
         $blockText .= ++$i . ": " . $entry->getIdMenu() . " " . $entry->getMeNombre() . " " . $entry->getMeDescripcion() . " " . $entry->getIdPadre() . " <br>"; 
      }
      return $blockText;
   }

   // Convert function to arrow, so it can be called in HTML block.
   $showdata = fn($data) => showData($data);
// }

echo <<<HTML

<body>
   <!-- Call of EasyUI using menu -->
   <div class="container">
      <div class="container">
         <h4>Test header menues</h4>
         <br>
      </div>
      <!-- Show Result of SHA512/256 convertion with AJAX -->
      <div class="container">
         <h4>Convertir password con SHA512/256</h4>
         <input type="text" id="pass" name="pass">
         <button id="updateButton">Convert</button>
         <p>Pass: <span id="pass-response"></span></p>
         <div id="loading" hidden>Loading...</div>
         <br>
         <p id="passwords-hash">
            <h5>Passwords usadas en la base de datos</h5>
            <h6>Nobmre Usuario: hash = pass</h6>
            Admin: {$passAdmin} = admin <br>
            Usuario: {$passUser} = usuario <br>
            Deposito: {$passDepo} = deposito <br>
         </p>
      </div>
      <script>
         $(document).ready(function () {
            $("#updateButton").on("click", function () {
               // You can set the value before handing value to AJAXexample.php
               $("#pass-response").html("");
               // And can set other attributes
               $("#loading").attr('hidden', false);
               $.ajax({
                  type: "POST", // Or 'GET', depending on your needs
                  url: "AJAXexample.php", // URL where your server-side script should handle the data
                  data: {pass : $("#pass").val()},
                  success: function (response) {
                     // Once the function resolves in success, you can set again the attribute and show the response
                     $("#loading").attr('hidden', true);
                     $("#pass-response").html(response); // Update the div with the response from the server
                  },
                  error: function () {
                     $("#pass-response").html("Error updating the div");
                  }
               });
            });
         });
      </script>
   </div>

   <br><hr><br>
   <!-- Test of EasyUI -->
   <div class="container">
      <h2>Basic CRUD Application</h2>
      <p>Useful for checking if DB is working correctly.</p>

      <table id="dg" title="Menues" class="easyui-datagrid" style="width:550px;height:250px"
        url="test_menu.php" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true">
         <thead>
            <tr>
               <th field="idmenu" name="idmenu" width="50">ID Menu</th>
               <th field="menombre" name="menombre" width="50">Nombre</th>
               <th field="medescripcion" name="medescripcion" width="50">Descripcion</th>
               <th field="idpadre" name="idpadre" width="50">ID Padre</th>
               <th field="medeshabilitado" name="medeshabilitado" width="50">Deshabilitado</th>
            </tr>
         </thead>
      </table>
   </div>

   <!-- TODO Buttons don't work -->
   <div id="toolbar">
      <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newMenu()">New Menu</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editMenu()">Edit Menu</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyMenu()">Remove Menu</a>
   </div>
   <!-- TODO Repair modal, doesn't actually update info, just closes. -->
   <div id="dlg" class="easyui-dialog" style="width:400px;height:280px;padding:10px 20px"
        closed="true" buttons="#dlg-buttons">
      <div class="ftitle">Menu Information</div>
         <form id="fm" method="post" novalidate>
            <div class="fitem">
                  <label>ID Menu:
                  <input id="id-idmenu" class="easyui-textbox" required="true">
                  </label>
            </div>
            <div class="fitem">
                  <label>Nombre:
                  <input id="id-menombre" class="easyui-textbox" required="true">
                  </label>
            </div>
            <div class="fitem">
                  <label>Descripcion:
                  <input id="id-medescripcion" class="easyui-textbox" required="true">
                  </label>
            </div>
            <div class="fitem">
                  <label>ID Padre:
                  <input id="id-mepadre" class="easyui-textbox">
                  </label>
            </div>
            <div class="fitem">
                  <label>Deshabilitado:
                  <input id="id-medeshabilitado" class="easyui-textbox">
                  </label>
            </div>
         </form>
      </div>
   <div id="dlg-buttons">
      <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveMenu()" style="width:90px">Save</a>
      <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
   </div>
   <!-- TODO Check functions -->
   <script>
      function newMenu(){
         $('#dlg').dialog('open').dialog('setTitle','New Menu');
         $('#fm').form('clear');
         url = 'save_menu.php';
      } 

      function editMenu(){
         var row = $('#dg').datagrid('getSelected');
         if (row){
            $('#dlg').dialog('open').dialog('setTitle','Edit Menu');
            $('#fm').form('load',row);
            url = 'update_menu.php?id='+row.id;
         }
      }

      function saveMenu(){
         $('#fm').form('submit',{
            url: url,
            onSubmit: function(){
               return $(this).form('validate');
            },
            success: function(result){
               // var result = eval('('+result+')');
               // if (result.errorMsg){
               //    $.messager.show({
               //       title: 'Error',
               //       msg: result.errorMsg
               //    });
               // } else {
                  $('#dlg').dialog('close');        // close the dialog
                  $('#dg').datagrid('reload');    // reload the user data
               // }
            }
         });
      }
   </script>
   
   <br><hr><br>
   <!-- Show Data -->
   <div class="container">
      <p class="showData">
         {$showdata($menuArray)}
      </p>
   </div>

   <br><hr><br>
</body>

HTML;