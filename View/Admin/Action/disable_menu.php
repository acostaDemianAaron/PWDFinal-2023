<?php
require_once("../../../Config/config.php");

$data = data_submitted();
$data['medeshabilitado'] = date("Y-m-d H:i:s");

$menu = new ABMMenu();
if ($menu->Edit($data)) {
   $res['success'] = true;
} else {
   $res['errorMsg'] = "No se pudo deshabilitar.";
}

echo json_encode($res);