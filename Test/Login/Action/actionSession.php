<?php
include_once("../../../Config/config.php");

$sesion = new Session();
if (!$sesion->onSession()) {
    $data = data_submitted();

    $cUsuario = new CUsuario();
    $resp = $cUsuario->Login($data);

    $msg = ($resp['msgError'] != "?msgError=") ? $resp['msgError'] : $resp['msg'];
    $location = ($resp['msgError'] != "?msgError=") ? '../login.php' : '../inicio.php';

    header("Location: $location?msg=" . urlencode($msg));
    exit;
} else {
    header('Location: ../home/inicio.php?msgError=' . urlencode("Sesión ya iniciada"));
    exit;
}
