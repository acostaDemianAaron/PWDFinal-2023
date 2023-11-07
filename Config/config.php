<?php
header('Content-Type: text/html; charset=utf-8;');
header ("Cache-Control: no-cache, must-revalidate ");

/////////////////////////////
//    CONFIGURACION APP    //
/////////////////////////////

// Array of libraries
$DIRS = [];

// Variable de rooteo de proyecto.
$PROYECTO = 'PWDFinal-2023';
$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO";
$DIRS["ROOT"] = $ROOT;

// Cargar funciones necesarias para forms y classes.
$FUNCIONES = $ROOT.'/Function/function.php';
require($FUNCIONES);

// Location of index
$DIRS["INDEX"] = "http://". $_SERVER['HTTP_HOST'] . "/$PROYECTO/View/";

// Location of Libraries.
$DIRS['LIBS'] = "/$PROYECTO/View/Libs/";

$_SESSION['ROOT']=$ROOT;
?>