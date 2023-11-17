<?php
require_once("../../../Config/config.php");

$data = data_submitted();

$abmMenu = new AbmMenu;
if($abmMenu->Add($data)){
   $res['success'] = true;
} else {
   
   $res['errorMsg'] = "no se puede procesar el pedido";
}
return $res;