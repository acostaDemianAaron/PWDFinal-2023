<?php
include_once('../../../Config/config.php');

// TODO check if user has privileges to see this page, otherwise redirect to index or ask login info.
$session == 2;

$array = [];
$abm = new ABMCompra;
$arrayCompras = $abm->Search();
foreach($arrayCompras as $compra){
   $col = [];
   // Add values in compra
   $col['idcompra'] = $compra->getIdCompra();
   $col['cofecha'] = $compra->getCoFecha();
   // Add usnombre
   $abmUsuario = new ABMUsuario;
   $col['usnombre'] = $abmUsuario->Search(['idusuario' => $compra->getObjUsuario()->getIdUsuario()])[0]->getUsNombre();
   // Add cefechaini
   $abmCompraEstado = new ABMCompraEstado;
   $col['cefechaini'] = $abmCompraEstado->Search(['idcompra' => $compra->getIdCompra()])[0]->getCeFechaIni() ;
   // Add estado tipo = cetdescripcion
   $resutl = $abmCompraEstado->Search(['idcompra' => $compra->getIdCompra()]);
   $abmCompraEstadoTipo = end($resutl)->getObjCompraEstadoTipo();
   $col['cetdescripcion'] = $abmCompraEstadoTipo->getCetDescripcion();
   array_push($array, $col);
}

// Return as JSON.
echo json_encode($array);