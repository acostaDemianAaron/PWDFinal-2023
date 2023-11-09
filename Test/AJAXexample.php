<?php
$pass = $_POST['pass'];

if($pass != null){
   echo hash("SHA512/256", $pass);
} else {
   echo 'No pass';
}