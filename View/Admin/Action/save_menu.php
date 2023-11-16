<?php
require_once("../../../Config/config.php");

$data = data_submitted();

echo json_encode($data);