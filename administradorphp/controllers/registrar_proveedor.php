<?php
include "../models/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO PROVEEDOR (Nombe, Telefono, Dirección) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die("Error en la preparación: " . $conexion->error);
    }

    // Usar 's' para string (porque son campos de texto)
    $stmt->bind_param("sss", $nombre, $telefono, $direccion);

    // Ejecutar la consulta y verificar si se ejecutó correctamente
    if ($stmt->execute()) {
        header("location:../Proveedores.php");
        exit();
    } else {
        echo "Error al registrar el proveedor: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conexion->close();
} else {
    echo "Método de solicitud no válido.";
}
?>
