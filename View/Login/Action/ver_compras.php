<?php
include_once("../../../Config/config.php");

$array = [];
$abm = new ABMCompra;
$session = new Session();
$idUser['idusuario'] = $session->getIdUsuarioSession();
$arrayCompras = $abm->Search($idUser);
foreach ($arrayCompras as $compra) {
    $col = [];
    // Add values in compra
    $col['idcompra'] = $compra->getIdCompra();
    $col['cofecha'] = $compra->getCoFecha();
    // Add usnombre
    $abmUsuario = new ABMUsuario;
    $col['usnombre'] = $abmUsuario->Search(['idusuario' => $compra->getObjUsuario()->getIdUsuario()])[0]->getUsNombre();
    // Add cefechaini
    $abmCompraEstado = new ABMCompraEstado;
    $col['cefechaini'] = $abmCompraEstado->Search(['idcompra' => $compra->getIdCompra()])[0]->getCeFechaIni();
    // Add estado tipo = cetdescripcion
    $resutl = $abmCompraEstado->Search(['idcompra' => $compra->getIdCompra()]);
    $abmCompraEstadoTipo = end($resutl)->getObjCompraEstadoTipo();
    $col['cetdescripcion'] = $abmCompraEstadoTipo->getCetDescripcion();
    $ambCompraItem = new ABMCompraItem;
    $compraItem = $ambCompraItem->Search(['idcompra' => $col['idcompra']]);
    $producto = $compraItem[0]->getObjProducto()->getProPrecio();
    $col['proprecio'] = $producto;

    array_push($array, $col);

}
echo json_encode($array);
