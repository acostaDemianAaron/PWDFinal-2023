<?php
$pass = $_POST['pass'];

sleep(1);

if($pass != null){
   echo hash("SHA512/256", $pass);
} else {
   echo 'No pass';
}