<?php
require_once("../../../Config/config.php");

$data = data_submitted();
$data['idmenu'] = $_GET['idmenu'];

json_encode($data);

$abm = new ABMMenu;
if($abm->Edit($data)){
   $res['success'] = true;
} else {
   $res['errorMsg'] = "no se puede procesar el pedido";
}