<?php
include_once('../../../Config/config.php');

$data = data_submitted();

$compraEstado = new ABMCompraEstado();
$data['cefechafin'] = "NULL";
$objCompraEstado = $compraEstado->Search($data)[0];
if ($ultimoEstado != 4) {
    $data['cefechafin'] = date("Y-m-d H:i:s");
    $data['idcompraestado'] = $objCompraEstado->getIdCompraEstado();
    $compraEstado->Edit($data);

    $data['cefechaini'] = $data['cefechafin'];
    unset($data['cefechafin']);
    unset($data['idcompraestado']);

    $data['idcompraestadotipo'] = 4;
    $compraEstado->Add($data);
    $res['success'] = TRUE;
} else {
    $res['errorMsg'] = "no se puede procesar el pedido";
}
echo json_encode($res);
