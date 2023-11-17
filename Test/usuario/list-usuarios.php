<?php
include_once("../../Config/config.php");
/**
 * Convert Object to associative Array.
 * Uses every 'get' method and uses its name to create the key associated.
 * @param Object $object Object of any type that has 'get' methods.
 * @return array $array Object as associative Array.
 */
function ObjectToArray($object)
{
   $array = [];
   $methodsArray = get_class_methods($object);
   foreach ($methodsArray as $method) {
      if (mb_substr($method, 0, 3) == "get" && mb_substr($method, 3, 3) != "Obj") {
         $key = strtolower(mb_substr($method, 3));
         $array[$key] = $object->$method();
      }
    }
    return $array; // For now echo.
}

if(data_submitted()['type']){
   // Create the object of the respective class.
   switch(data_submitted()['type']){
      case 'usuario': $obj = new ABMUsuario(); break;
      case 'menu': $obj = new ABMMenu(); break;
      case 'usuario': $obj = new ABMUsuario(); break;
      case 'usuario': $obj = new ABMUsuario(); break;
   }

   // Convert objects in the array to arrays.
   // Returns a two dimentional array.
   $array = [];
   foreach($obj->Search() as $objUsuario){
      array_push($array, ObjectToArray($objUsuario));
   }

   // Return as JSON.
   echo json_encode($array);
}