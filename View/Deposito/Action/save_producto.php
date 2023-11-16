<?php
require_once("../../../Config/config.php");

$data = data_submitted();

$abmProducto = new AbmProducto;
if($abmProducto->Add($data)){
   $res['success'] = true;
} else {
   $res['errorMsg'] = "no se puede procesar el pedido";
}

echo json_encode($res);