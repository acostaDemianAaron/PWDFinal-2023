<?php
include_once("../Config/config.php");
$database = new Database;

$data = data_submitted();
 
$sql = "insert into menu(menombre,medescripcion,idpadre,medeshabilitado) values('{$data["menombre"]}','{$data["medescripcion"]}','{$data["idpadre"]}','{$data["medeshabilitado"]}')";

// $database->Execute($sql);

// echo json_encode(array(
//     'idmenu' => $database->getIndex(),
//     'menombre' =>$data["menombre"],
//     'medescripcion' => $data["medescripcion"],
//     'idpadre' => $data["idpadre"],
//     'medeshabilitado' => $data["medeshabilitado"]
// ));