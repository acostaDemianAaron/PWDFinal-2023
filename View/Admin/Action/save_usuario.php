<?php
require_once("../../../Config/config.php");

$data = data_submitted();

$data['uspass'] = encrypPassword($data['uspass']);

$abm = new ABMUsuario();
$abm->Add($data);

$usuario = $abm->Search($data);
$data['idusuario'] = $usuario[0]->getIdUsuario();

$abmUsRol = new ABMUsuarioRol();
$abmUsRol->Add($data);