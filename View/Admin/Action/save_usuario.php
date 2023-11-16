<?php
require_once("../../../Config/config.php");

$data = data_submitted();

$abm = new ABMUsuario();

echo json_encode($data);


$abm->Add($data);