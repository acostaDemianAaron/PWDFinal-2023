<?php
require_once("../../../Config/config.php");

$data = data_submitted();
$data['idusuario'] = $_GET['idusuario'];


$data['uspass'] = encrypPassword($data['uspass']);
$abm = new ABMUsuario();
$abm->Edit($data);
$abmUsRol = new ABMUsuarioRol();
$abmUsRol->Edit($data);