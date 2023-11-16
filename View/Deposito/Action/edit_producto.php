<?php
require_once("../../../Config/config.php");

$data = data_submitted(); // Needs url params, sent by dg of EasyUI
$data['idproducto'] = $_GET['idproducto'];

$abmProducto = new AbmProducto;
if($abmProducto->Edit($data)){
   $res['success'] = true;
} else {
   $res['errorMsg'] = "no se puede procesar el pedido";
}

echo json_encode($res);