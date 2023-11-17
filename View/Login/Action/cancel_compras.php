<?php
include_once('../../../Config/config.php');

$data = data_submitted();

$compraEstado = new ABMCompraEstado();
$data['cefechafin'] = "NULL";
$objCompraEstado = $compraEstado->Search($data)[0];
if ($objCompraEstado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo() == 1) {
    $data['cefechafin'] = date("Y-m-d H:i:s");
    $data['idcompraestado'] = $objCompraEstado->getIdCompraEstado();
    $compraEstado->Edit($data);

    $data['cefechaini'] = $data['cefechafin'];
    unset($data['cefechafin']);
    unset($data['idcompraestado']);

    $data['idcompraestadotipo'] = 4;
    $compraEstado->Add($data);
    $res['success'] = TRUE;
} else if ($objCompraEstado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo() == 4) {
    $res['errorMsg'] = "El pedido ya esta cancelado";
} else if ($objCompraEstado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo() == 3) {
    $res['errorMsg'] = "El pedido ya fue enviado";
} else {
    $res['errorMsg'] = "No se puede cancelar el pedido en proceso";
}
echo json_encode($res);
