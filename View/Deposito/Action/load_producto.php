<?php
include_once('../../../Config/config.php');

$array = [];
$abm = new AbmProducto;
$arrayProductos = $abm->Search();
foreach($arrayProductos as $producto){
   $col = [];
   $col['idproducto'] = $producto->getIdProducto();
   $col['proprecio'] = $producto->getProPrecio();
   $col['pronombre'] = $producto->getProNombre();
   $col['prodetalle'] = $producto->getProDetalle();
   $col['procantstock'] = $producto->getProCantStock();
   array_push($array, $col);
}

// Return as JSON.
echo json_encode($array);