<?php
    $servidor = "127.0.0.1";
    $usuario = "root";
    $contrasena ="";
    $db = "colfar";

    // Crear conexión
    $conexion = new mysqli($servidor, $usuario, $contrasena, $db);
    

    // Verificar conexión
    if ($conexion->connect_error){
        die("falla en la conexión". $conexion->connect_error);
    }
    $conexion->set_charset('UTF-8');
?>