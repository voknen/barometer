<?php 
session_start();

unset($_SESSION['isLogged']);

session_destroy();

echo "<meta charset='UTF-8' http-equiv='refresh' content='1;URL=login.php'>Вие излязохте!";

?>