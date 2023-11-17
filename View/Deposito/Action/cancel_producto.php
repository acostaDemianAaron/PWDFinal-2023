<?php
include_once('../../../Config/config.php');

$data = data_submitted();

$compraEstado = new ABMCompraEstado();
$data['cefechafin'] = "NULL";
$objCompraEstado = $compraEstado->Search($data)[0];
if ($objCompraEstado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo() != 4) {
    $data['cefechafin'] = date("Y-m-d H:i:s");
    $data['idcompraestado'] = $objCompraEstado->getIdCompraEstado();
    $compraEstado->Edit($data);

    $data['cefechaini'] = $data['cefechafin'];
    unset($data['cefechafin']);
    unset($data['idcompraestado']);

    $data['idcompraestadotipo'] = 4;
    if($compraEstado->Add($data)){
        $compI = new ABMCompraItem();
        $compA = $compI->Search(['idcompra' => $data['idcompra']]);
        $cantItem = 0;
        $stock = 0;
        foreach($compA as $cum){
            $cantItem = $cum->getCiCantidad();
            $product = $cum->getObjProducto();
            $stock = $product->getProCantStock();
            $suma = $cantItem + $stock;
            $product->setProCantStock($suma);
            $product->Modify();
        }
    }
    $res['success'] = TRUE;
} else {
    $res['errorMsg'] = "el pedido ya esta cancelado";
}
echo json_encode($res);
