<?php
// Getting an instance of Database
include_once("../Config/config.php");
$database = new Database;
// Can be replaced by functions of Control calling List() on that ABM

// Query
$rs = $database->Execute('SELECT * FROM menu');
$result = array();
// Array of response
while($row = $database->Register()){
   array_push($result, $row);
}
// Show response on screen
echo json_encode($result);