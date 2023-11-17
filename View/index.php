<?php
include_once("../Config/config.php");
new Header("Menu Principal", $DIRS);

$session = new Session;
if($session->getUser()){
   $nombre = $session->getUser()->getUsNombre();
// TODO Menu principal.
echo <<<HTML
   <div class="container">
      <h1>Bienvenido nuevamente {$nombre}!</h1>
   </div>
HTML;
} else {
   echo <<<HTML
   <div class="container">
      <h1>Bienvenido a E-Commerce!</h1>
   </div>
HTML;
}

new Footer;