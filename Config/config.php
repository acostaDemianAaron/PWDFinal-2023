<?php
session_start();
header('Content-Type: text/html; charset=utf-8;');
header('Cache-Control: no-cache, must-revalidate');

/////////////////////////////
//    CONFIGURACION APP    //
/////////////////////////////

// Array of directories
$DIRS = [];
$PROYECTO = 'PWDFinal-2023';

// Variable de rooteo de proyecto.
$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";

// Cargar funciones necesarias para forms y classes.
$FUNCIONES = $ROOT.'Function/function.php';
require($FUNCIONES);

// Root
$DIRS['ROOT'] = "/$PROYECTO/";

// Location of index
$DIRS['INDEX'] = "/$PROYECTO/View/";

// Location of Libraries.
$DIRS['LIBS'] = "/$PROYECTO/View/Libs/";

$_SESSION['ROOT']=$ROOT;
?>