<?php
include_once("../../../Config/config.php");
// TODO header call

$datos = $_POST;
print_r($datos);
new Header("Titulo", $DIRS, null);

echo <<< HTML


<h1>Pedido en proceso</h1>
HTML;
