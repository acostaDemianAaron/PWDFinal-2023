<?php
require_once("../../../Config/config.php");


$array = [];
$abmUsRol = new ABMUsuarioRol;
$abm = new ABMUsuario;
$arrayUser = $abmUsRol->Search();
foreach ($arrayUser as $user) {
    $col = [];
    $col['idusuario'] = $user->getObjUsuario()->getIdUsuario();
    $col['usnombre'] = $user->getObjUsuario()->getUsNombre();
    $col['usmail'] = $user->getObjUsuario()->getUsMail();
    $col['usdeshabilitado'] = $user->getObjUsuario()->getUsDeshabilitado();
    $col['rol'] = $user->getObjRol()->getRoDescripcion();
    array_push($array, $col);
}
echo json_encode($array);
