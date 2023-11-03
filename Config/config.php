<?php
header('Content-Type: text/html; charset=utf-8;');
header ("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
//    CONFIGURACION APP    //
/////////////////////////////

// Variable de rooteo de proyecto.
$PROYECTO = 'PWDFinal-2023';
$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO";

// Cargar funciones necesarias para forms y classes.
$FUNCIONES = $ROOT.'/Function/function.php';
require($FUNCIONES);

// Location of index
$INICIO = "http://". $_SERVER['HTTP_HOST'] . "/$PROYECTO/View/";

// Location of menu (repo index)
$PRINCIPAL = "http://". $_SERVER['HTTP_HOST'] . "/$PROYECTO/";

// Location of Libraries.
$LIBS = "/$PROYECTO/View/Libs/";

$_SESSION['ROOT']=$ROOT;
?>