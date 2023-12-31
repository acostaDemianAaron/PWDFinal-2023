<?php
include_once("../../Config/config.php");
// TODO header call
$objProductos = new AbmProducto();
$productos = $objProductos->Search();

echo <<<HTML
<div class="container mt-5">
    <div class="row">
HTML;
if ((array_key_exists('idusuario', $_SESSION))) {
    new Header("Store", $DIRS, null);
    foreach ($productos as $product) {
        echo <<<HTML
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-img">
                        <img src="{$DIRS['IMG']}{$product->getProDetalle()}" class="card-img-top" alt="Producto 1">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{$product->getProNombre()}</h5>
                        <p class="card-text">ARG$ {$product->getProPrecio()}</p>
                        <p class="card-text">Cant Stock: {$product->getProCantStock()}</p>
                        <input class="cantStock{$product->getIdProducto()}" value="{$product->getProCantStock()}" hidden>
                        <button class="btn btn-primary" onclick="agregarAlCarrito('{$product->getIdProducto()}', 1, {$product->getProPrecio()})">Agregar al carrito</button>
                    </div>
                </div>
            </div>
        HTML;
    }
    echo <<<HTML
        </div>
    </div>
        <!-- Puedes seguir añadiendo más productos siguiendo el mismo patrón -->
    </div>
    <!-- Carrito de compras -->
    <br>
    <div class="container mt-5">
    <div id="cart">
    </div>
    </div>
    </div>
    <script src="../js/carrito.js"></script>
    </div>
    <div class = "mb-5">
    HTML;
} else {
    $_POST['msg'] = 'store';
    new Header("Store", $DIRS, null);
    echo <<<HTML
    <div class="container mt-5">
        <h1 class="mb-4"> Tienda en línea</h1>
        <div class="row">
    HTML;
    foreach ($productos as $product) {
        echo <<<HTML
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-img">
                        <img src="{$DIRS['IMG']}{$product->getProDetalle()}" class="card-img-top" alt="Producto 1">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{$product->getProNombre()}</h5>
                        <p class="card-text">ARG$ {$product->getProPrecio()}</p>
                        <p class="card-text">Cant Stock:{$product->getProCantStock()}</p>
                    </div>
                </div>
            </div>
        HTML;
    }
}

echo <<<HTML
    </div>
</div>
</div>
</div>
HTML;

new Footer;