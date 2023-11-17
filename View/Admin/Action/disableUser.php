<?php
require_once("../../../Config/config.php");

$data = data_submitted();
$session = new Session();
if ($session->getIdUsuarioSession() != $data['idusuario']) {
    $usuario = new ABMUsuario();
    if ($usuario->State($data)) {
        $data['success'] = TRUE;
    } else {
        $data['errorMsg'] = "No se pudo deshabilitar.";
    }
} else {
    $data['errorMsg'] = "No se pudo deshabilitar a usted mismo.";
}
echo json_encode($data);