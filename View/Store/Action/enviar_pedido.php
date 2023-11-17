<?php
include_once("../../../Config/config.php");

$session = new Session();
$compra = new ABMCompra();
$idUser['idusuario'] = $session->getIdUsuarioSession();
$idUser['cofecha'] = date("Y-m-d H:i:s");
$carrito = data_submitted();

if ($compra->Add($idUser)) {
    $idCompra = $compra->Search(['cofecha' => $idUser['cofecha']])[0]->getIdCompra();
    $abmCompraEstado = new ABMCompraEstado;
    $abmCompraEstado->Add(['idcompra' => $idCompra, 'cefechaini' => $idUser['cofecha'], 'idcompraestadotipo' => 1]);

    $compraItem = new ABMCompraItem();
    $carrito = data_submitted();
    $i = 0;
    $aux = 0;
    foreach ($carrito as $item) {
        $item = json_decode($item, true);
        foreach ($item as $ci) {
            $itemb['idproducto'] = (int)$ci['title'];
            $itemb['cicantidad'] = $ci['quantity'];
            $product = new AbmProducto();
            $products = $product->Search($itemb);
            $resta = $products[0]->getProCantStock() - $itemb['cicantidad'];
            $cambio['idproducto'] = $itemb['idproducto'];
            $cambio['procantstock'] = $resta;
            $product->Edit($cambio);
            $itemb['idcompra'] = $idCompra;
            $compraItem->Add($itemb);
        }
        header("Location: ../catalogo.php");
    }
}
