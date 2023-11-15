<?php
include_once("../../../Config/config.php");

new Header("Actualizar Datos", $DIRS);
$usuario = new ABMUsuario();
$session = new Session();
$idUser = $session->getIdUsuarioSession();

$dataUser = data_submitted();
$dataUser['idusuario'] = $idUser;


$usuario->Edit($dataUser);


//print_r($dataUser);