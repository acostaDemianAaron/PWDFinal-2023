<?php
include_once("../../../Config/config.php");
$msg = "";
$session = new Session();
if ($session->getIdUsuarioSession() != null) {
   $session->close();
   $msg = "?msg=logoutSuccess";
} else {
   $msg = "?msg=logoutError";
}

header("Location: {$DIRS['INDEX']}index.php" . $msg);
exit;