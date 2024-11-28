<?php
include "../models/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $pais = $_POST['pais'];
    $codigo_postal = $_POST['codigo_postal'];

    $sql = "INSERT INTO CIUDAD (Nombre_ciudad, Pais, Codigo_postal) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    if ($stmt === false) {
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt->bind_param("ssi", $nombre, $pais, $codigo_postal);

    if ($stmt->execute()) {
        header("location:../Ciudades.php");
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