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
      <h2>Basic CRUD Application</h2>
      <p>Useful for checking if DB is working correctly.</p>

      <table id="dg" title="Menues" class="easyui-datagrid" style="width:550px;height:250px"
        url="test_menu.php" toolbar="#toolbar" rownumbers="true" fitColumns="true" singleSelect="true">
         <thead>
            <tr>
               <th field="idmenu" width="50">ID Menu</th>
               <th field="menombre" width="50">Nombre</th>
               <th field="medescripcion" width="50">Descripcion</th>
               <th field="idpadre" width="50">ID Padre</th>
               <th field="medeshabilitado" width="50">Deshabilitado</th>
            </tr>
         </thead>
      </table>
   </div>
   
   <br><hr><br>
   <!-- Show Data -->
   <div class="container">
      <p class="showData">
         {$showdata($menuArray)}
      </p>
   </div>

   <br><hr><br>
   <!-- Show Result of SHA512/256 convertion -->
   <div class="container">
      <p id="passwords-hash">
         Admin: {$passAdmin} = admin <br>
         Usuario: {$passUser} = usuario <br>
         Deposito: {$passDepo} = deposito <br>
      </p>
   </div>
</body>

HTML;