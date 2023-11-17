<?php
include_once('../../../Config/config.php');

$data = data_submitted();

$compraEstado = new ABMCompraEstado();
$data['cefechafin'] = "NULL";
$objCompraEstado = $compraEstado->Search($data)[0];
if ($objCompraEstado->getObjCompraEstadoTipo()->getIdCompraEstadoTipo() != 4) {
    $data['cefechafin'] = date("Y-m-d H:i:s");
    $data['idcompraestado'] = $objCompraEstado->getIdCompraEstado();
    // $compraEstado->Edit($data);

    $data['cefechaini'] = $data['cefechafin'];
    unset($data['cefechafin']);
    unset($data['idcompraestado']);

    $data['idcompraestadotipo'] = 4;
    // $compraEstado->Add($data)
    if(TRUE){
        $compI = new ABMCompraItem();
        $compA = $compI->Search(['idcompra' => $data['idcompra']]);
        print_r(count($compA));
        $cantItem = 0;
        $stock = 0;
        foreach($compA as $cum){
            $cantItem = $cum->getCiCantidad();
            $product = $cum->getObjProducto();
            $stock = $product->getProCantStock();
            $suma = $cantItem + $stock;
            echo "<br> ESTO ES SUMA: ";
            echo $cantItem . " + " . $stock . " = " . $suma;
            echo "<br>";
            $product->setProCantStock($suma);
            $product->Modify();
        print_r($cum);
        echo "<br> <br>";
        }
    }
    $res['success'] = TRUE;
} else {
    $res['errorMsg'] = "el pedido ya esta cancelado";
}
// echo json_encode($compA);
