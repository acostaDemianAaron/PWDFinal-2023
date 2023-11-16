<?php
require_once("../../../Config/config.php");

$array = [];
$abmMenu = new AbmMenu;
$arrayMenu = $abmMenu->Search();
foreach ($arrayMenu as $menu) {
    $col = [];
    $col['idmenu'] = $menu->getIdMenu();
    $col['menombre'] = $menu->getMeNombre();
    $col['medescripcion'] = $menu->getMeDescripcion();
    $col['medeshabilitado'] = $menu->getMeDeshabilitado();
    array_push($array, $col);
}
echo json_encode($array);
