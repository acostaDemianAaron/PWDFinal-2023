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
$FUNCIONES = $ROOT.'/Function/functions.php';
require($FUNCIONES);

// Location of index
$INICIO = "http://". $_SERVER['HTTP_HOST'] . "/$PROYECTO/View/";

// Location of menu (repo index)
$PRINCIPAL = "http://". $_SERVER['HTTP_HOST'] . "/PWD-2023/";

// Location of Libraries.
$LIBS = "/$PROYECTO/View/Libs/";

$_SESSION['ROOT']=$ROOT;

// Setting keys on browser's session, so it can be deleted after closing it.
// $_SESSION['apiKey'] = ""; // Agregar Key
// $_SESSION['workspaceID'] = ""; // Agregar mail o Workspace ID
// $_SESSION['secretKey'] = ""; // Agregar Secret
// $_SESSION['access'] = "private"; // Opcional, si se quiere restringir la vista.
?>