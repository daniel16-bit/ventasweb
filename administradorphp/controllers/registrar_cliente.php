<?php
include "../models/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $tipo = $_POST["tipo"];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Preparar la consulta
    $sql = "INSERT INTO CLIENTE (Tipo, Nombre, Telefono, Direccion) VALUES (?, ?, ?, ?);";
    $stmt = $conexion->prepare($sql);
    
    if ($stmt === false) {
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt->bind_param("ssss", $tipo, $nombre, $telefono, $direccion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redireccionar 
        header("location:../Clientes.php"); // Cambia a la página que desees
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conexion->close();
} else {
    echo "Método de solicitud no válido.";
}
?>