<?php
include_once("../Config/config.php");
new Header("Test Page", $DIRS, null);

// Turn to SHA512/256
$passAdmin = hash("SHA512/256", "admin");
$passUser = hash("SHA512/256", "usuario");
$passDepo = hash("SHA512/256", "deposito");

// Getting data directly from model. Test
// $menu = new Menu;
// $data = $menu->List();
// print_r($data);

// Getting data directly from Database.
$database = new Database;
$data = $database->Select("SELECT * FROM menu"); // Query
print_r($data);

echo <<<HTML

<body>
   <div class="container">
      <p id="data">
      </p>
   </div>
   <br><hr><br>
   <div class="container">
      <p id="passwords-hash">
         Admin: {$passAdmin} = admin <br>
         Usuario: {$passUser} = usuario <br>
         Deposito: {$passDepo} = deposito <br>
      </p>
   </div>
</body>

HTML;

// Footer call