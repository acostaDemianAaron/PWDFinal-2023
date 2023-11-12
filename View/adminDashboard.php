<?php
include_once("../Config/config.php");
// TODO header call
new Header("Dashboard", $DIRS, null);

// Getting data directly from Database.
$menuModel = new Menu;
$menuArray = $menuModel->List();
$usModel = new Usuario;
$usArray = $usModel->List();
$usRolModel = new UsuarioRol;
$usRolArray = $usRolModel->List();

function showData($dataArray){
   $blockText = "";
   foreach($dataArray as $obj){
      $methods = get_class_methods($obj);

      foreach($methods as $method){
         if(mb_substr($method, 0, 3) == "get" && mb_substr($method, 3, 3) != "Obj"){
            $blockText .=  " " . $obj->$method();
         }
      }

      $blockText .= " <br>";
   }
   return $blockText;
}

$showOnBlock = fn($data) => showData($data);

// showData($menuArray);

// TODO Blocks can be changed to a table to show data by rows and columns

echo <<<HTML
   <p>
      {$showOnBlock($menuArray)}
   </p>
   <br><hr><br>
   <p>
      {$showOnBlock($usArray)}
   </p>
   <br><hr><br>
   <p>
      {$showOnBlock($usRolArray)}
   </p>
   <br><hr><br>

HTML;

// TODO footer call