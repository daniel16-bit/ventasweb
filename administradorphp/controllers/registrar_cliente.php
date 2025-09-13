<?php
include "../models/conexion.php"; // conexión PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtener los datos del formulario
        $tipo      = $_POST["tipo"];
        $nombre    = $_POST['nombre'];
        $telefono  = $_POST['telefono'];
        $direccion = $_POST['direccion'];

        // Preparar la consulta con parámetros
        $sql = "INSERT INTO CLIENTE (Tipo, Nombre, Telefono, Direccion) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $conexion->prepare($sql);

        // Ejecutar con los valores
        $resultado = $stmt->execute([$tipo, $nombre, $telefono, $direccion]);

        if ($resultado) {
            // Redirigir si todo salió bien
            header("Location: ../Clientes.php");
            exit();
        } else {
            echo "Error al registrar el cliente.";
        }

    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "Método de solicitud no válido.";
}
