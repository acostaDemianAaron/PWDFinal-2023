<?php
include_once("../Config/config.php");
// TODO header call
new Header("Titulo", $DIRS);

print_r($_SESSION);

// TODO contents
if(array_key_exists('msg', data_submitted())){
   if(data_submitted()['msg'] == 'logout'){
      echo <<<HTML
      <h1>Successful Log out!</h1>
      HTML;
   }
} else if(null !== session_id()){
   echo <<<HTML
      <h1>Logged In!</h1>
      HTML;
}
// TODO footer call