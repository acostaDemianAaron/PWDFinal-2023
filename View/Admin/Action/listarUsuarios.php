<?php
require_once("../../../Config/config.php");

$objUsuario = new ABMUsuario;
$objUsuarioRol = new ABMUsuarioRol;
$arrayUsers = $objUsuario->Search(NULL);
if($arrayUsers != null)
{
    $cantUsers = count($arrayUsers);
    $roles = $objUsuarioRol->RolDescrip($arrayUsers);
} else {
    $cantUsers = -1;
}

$i = 0;
print_r($roles)

?>

