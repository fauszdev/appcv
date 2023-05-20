<?php

//Nombre del dominio, direccion IP //127.0.0.1
$servidor = "localhost";
//Nombre de la BD
$baseDeDatos= "appcv";
//Usuario de la BD
$usuario="root";
//Contraseña del usuario de la BD
$contrasenia="";

//Intentamos establecer conexion a la BD, en caso de no poder mostramos la excepcion por pantalla
try{
    $conexion = New PDO("mysql:host=$servidor;dbname=$baseDeDatos",$usuario,$contrasenia);
}catch(Exception $ex){
    echo $ex->getMessage();
}
    
?>