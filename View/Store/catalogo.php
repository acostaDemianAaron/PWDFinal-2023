<?php
include_once("../../Config/config.php");
// TODO header call
new Header("Titulo", $DIRS, null);

echo <<< HTML

<body>
    <div class="container mt-5">
        <h1 class="mb-4"> Tienda en línea</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-img">
                        <img src="../img/furyRam.png" class="card-img-top" alt="Producto 1">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Memoria RAM - Marca Fury</h5>
                        <p class="card-text">Precio: $25</p>
                        <button class="btn btn-primary" onclick="agregarAlCarrito('Memoria RAM - Marca Fury', 1, 25)">Agregar al carrito</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-img">
                        <img src="../img/furysRam.png" class="card-img-top" alt="Producto 2">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Memoria RAM - Marca Fury - x2</h5>
                        <p class="card-text">Precio: $50</p>
                        <button class="btn btn-primary" onclick="agregarAlCarrito('Memoria RAM - Marca Fury - x2', 1, 50)">Agregar al carrito</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="../img/intelTres.png" class="card-img-top" alt="Producto 3">
                    <div class="card-body">
                        <h5 class="card-title">Procesador - Marca I3</h5>
                        <p class="card-text">Precio: $150</p>
                        <button class="btn btn-primary" onclick="agregarAlCarrito('Procesador - Marca I3', 1, 150)">Agregar al carrito</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="../img/interXeon.png" class="card-img-top" alt="Producto 3">
                    <div class="card-body">
                        <h5 class="card-title">Procesador - Marca Xeon</h5>
                        <p class="card-text">Precio: $250</p>
                        <button class="btn btn-primary" onclick="agregarAlCarrito('Procesador - Marca Xeon', 1, 250)">Agregar al carrito</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="../img/motherboardAORUS.png" class="card-img-top" alt="Producto 3">
                    <div class="card-body">
                        <h5 class="card-title">Motherboard - Marca Aorus</h5>
                        <p class="card-text">Precio: $325</p>
                        <button class="btn btn-primary" onclick="agregarAlCarrito('Motherboard - Marca Aorus', 1, 325)">Agregar al carrito</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="../img/motherboardGG.png" class="card-img-top" alt="Producto 3">
                    <div class="card-body">
                        <h5 class="card-title">Motherboard - Marca Gygabyte</h5>
                        <p class="card-text">Precio: $499</p>
                        <button class="btn btn-primary" onclick="agregarAlCarrito('Motherboard - Marca Gygabyte', 1, 499)">Agregar al carrito</button>
                    </div>
                </div>
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
HTML;
