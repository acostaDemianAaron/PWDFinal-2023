<?php
include_once("../../Config/config.php");

$session = new Session();
if ($session->onSession()) {
   $session->close();
   header("Location: {$DIRS['INDEX']}?msg=logout");
   exit;
}
header("Location: {$DIRS['INDEX']}");
