<?php
// Correct URL
$sURL = strtolower($_SERVER['REQUEST_URI']);
if($sURL === "/pwdfinal-2023" || $sURL === "/pwdfinal-2023/"){
   header("Location: /PWDFinal-2023/View");
   die();
}
?>