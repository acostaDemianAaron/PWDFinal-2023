<?php
include_once("../../../Config/config.php");

$sesion = new Session();
//$sesion->close();
if (!$sesion->onSession()) {
    $data = data_submitted();
    $cUsuario = new CUsuario();
    $resp = $cUsuario->Login($data);
    if ($resp == TRUE) {
        header('Location: ../inicio.php');
        exit;
    } else if ($resp == FALSE) {
        header("Location: ../login.php");
        exit;
    }
}
