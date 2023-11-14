<?php
include_once("../../Config/config.php");
new Header("Test Page", $DIRS, null);

echo <<< HTML

<h1>Iniciaste sesion</h1>
<h3>Value: {$_SESSION['usnombre']}</h3>

HTML;