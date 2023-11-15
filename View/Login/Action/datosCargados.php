<?php
include_once("../../../Config/config.php");

$usuario = new ABMUsuario();
$session = new Session();
$idUser = $session->getIdUsuarioSession();

$dataUser = data_submitted();
$dataUser['idusuario'] = $idUser;

$dataUser['uspass'] = encrypPassword($dataUser['uspass']);

foreach($dataUser as $key => $data)
{
    if($data == "null" || $data == null)
    {
        unset($dataUser[$key]);
        echo " Se encontro null en: " . $key;
    }
}

if(count($dataUser) > 1){
$usuario->Edit($dataUser);
} else {
    header("Location: ../profile.php?msg=UpdateError");
}
