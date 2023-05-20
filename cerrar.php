<?php
//Cargamos la sesion para despues destruirla
session_start();
//Destruimos la sesion
session_destroy();
//Redirecciona al login para poder iniciar sesion de nuevo
header("Location:./login.php");
?>