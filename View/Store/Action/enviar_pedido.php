<?php
include_once("../../../Config/config.php");

$session = new Session();
$compra = new ABMCompra();
$idUser['idusuario'] = $session->getIdUsuarioSession();
$idUser['cofecha'] = date("Y-m-d H:i:s");

// Test array
$idUser = array( 'idusuario' => 3);
$idUser['cofecha'] = date("Y-m-d H:i:s");
$carrito = array ( array ( 'title' => 'HyperX RAM 8Gbx2', 'quantity' => 4, 'unit_price' => 24000 ) , array ( 'title' => 'Monitor 360hz', 'quantity' => 3, 'unit_price' => 180000 ) );

echo "Fecha: ";
print_r($idUser['cofecha']);
echo "<br>";
echo "<br>";

// print_r($carrito);
// echo "<br>";
// print_r(json_decode($carrito, true));
// echo "<br>";
// die;

if ($compra->Add($idUser)) {
    $idCompra = $compra->Search(['cofecha' => $idUser['cofecha']])[0]->getIdCompra();
    echo "Ultima compra: ";
    print_r($idCompra);
    echo "<br>";
    $abmCompraEstado = new ABMCompraEstado;
    $abmCompraEstado->Add(['idcompra' => $idCompra, 'cefechaini' => $idUser['cofecha'], 'idcompraestadotipo' => 1]);

    $compraItem = new ABMCompraItem();
    $carrito = data_submitted();

    foreach ($carrito as $item) {
        print_r($item);
        echo "<br>";
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
    }
}
