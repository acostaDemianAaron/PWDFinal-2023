<?php
include_once("../../../Config/config.php");

$session = new Session();
$compra = new ABMCompra();
$idUser['idusuario'] = $session->getIdUsuarioSession();
$idUser['cofecha'] = date("Y-m-d H:i:s");


if ($compra->Add($idUser)) {
    $idCompra = $compra->Search(['cofecha' => $idUser['cofecha']])[0]->getIdCompra();
    $abmCompraEstado = new ABMCompraEstado;
    $abmCompraEstado->Add(['idcompra' => $idCompra, 'cefechaini' => $idUser['cofecha'], 'idcompraestadotipo' => 1]);

    $compraItem = new ABMCompraItem();
    $carrito = data_submitted();
    foreach ($carrito as $item) {
        $item = json_decode($item, true);
        $item = $item[0];
        $item['pronombre'] = $item['title'];
        $item['cicantidad'] = $item['quantity'];
        $item['proprecio'] = $item['unit_price'];
        unset($item['title']);
        unset($item['quantity']);
        unset($item['unit_price']);
        $item['idcompra'] = $idCompra;
        $compraItem->Add($item);
        header("Location: ../catalogo.php");
    }
}
