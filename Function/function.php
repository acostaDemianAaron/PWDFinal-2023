<?php
function data_submitted()
{
    $_AAux = array();
    if (!empty($_POST))
        $_AAux = $_POST;
    else
            if (!empty($_GET)) {
        $_AAux = $_GET;
    }
    if (count($_AAux)) {
        foreach ($_AAux as $indice => $valor) {
            if ($valor == "")
                $_AAux[$indice] = 'null';
        }
    }
    return $_AAux;
}

spl_autoload_register(function ($class_name) { //Se ejecuta automáticamente cada vez que se llame el script configuracion.php que tiene incluido a este script funciones.php
    // echo "class ".$class_name ;
    $directorys = array( //Guarda las carpetas con clases (su creación) que usaremos
        $_SESSION['ROOT'] . '/Model/Class/',
        $_SESSION['ROOT'] . '/Model/Connection/',
        $_SESSION['ROOT'] . '/Controller/',
        $_SESSION['ROOT'] . '/View/Structure/'
        //  $GLOBALS['ROOT'].'util/class/',
    );
    foreach ($directorys as $directory) { //Busca la BaseDatos o las clases que esten siendo usadas, para que funcione TODAS LAS CLASES DEBEN TENER EL MISMO NOMBRE QUE SU SCRIPT 
        if (file_exists($directory . $class_name . '.php')) {
            // echo "se incluyo".$directory.$class_name . '.php';
            require_once($directory . $class_name . '.php');
            return;
        }
    }
});