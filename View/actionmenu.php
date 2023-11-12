<?php

if(data_submitted()){
   // Elegir objeto
   $obj = new stdClass;
   switch(data_submitted()['typeObject']){
      case 'Usuario': $obj = new ABMUsuario(); crearListaUsuario(); break;
      case 'Menu': $obj = new ABMMenu(); break;
      case 'Rol': $obj = new ABMRol(); break;
   }

   // Conseguir lista
   $res = $obj->Search();

   // Encode segun lo que recibe EasyUI
   echo json_encode($res);
}