<?php
include_once('../../../Config/config.php');

$array = [];
$abm = new ABMCompra;
$arrayCompras = $abm->Search();
foreach ($arrayCompras as $compra) {
   $col = [];
   // Add values in compra
   $col['idcompra'] = $compra->getIdCompra();
   $col['cofecha'] = $compra->getCoFecha();

   $objCompraEstado = new ABMCompraEstado();
   $compraEstado = $objCompraEstado->Search(['idcompra' => $col['idcompra']]);
   $colNombre = array('cefechaini', 'cefechaace', 'cefechaevi', 'cefechacan');
   foreach($compraEstado as $estado) {
   $nombreEstado = $colNombre[$estado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo() - 1];
      $col[$nombreEstado] = $estado->getCeFechaIni();
   }
   array_push($array, $col);
}

// // Return as JSON.
echo json_encode($array);
