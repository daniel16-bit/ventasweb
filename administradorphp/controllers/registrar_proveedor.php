<?php
include "../models/conexion.php"; // Aquí tu conexión PDO a Azure SQL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtener los valores del formulario
        $nombre    = $_POST['nombre'];
        $telefono  = $_POST['telefono'];
        $direccion = $_POST['direccion'];

        // ⚠️ Ojo: en tu SQL pusiste "Nombe" en vez de "Nombre"
        // ⚠️ También usaste "Dirección" con tilde, y en SQL Server normalmente es "Direccion"
        $sql = "INSERT INTO PROVEEDOR (Nombre, Telefono, Direccion) VALUES (?, ?, ?)";

        $stmt = $conexion->prepare($sql);

        // Ejecutar con arreglo de parámetros
        $resultado = $stmt->execute([$nombre, $telefono, $direccion]);

        if ($resultado) {
            header("Location: ../Proveedores.php");
            exit();
        } else {
            echo "Error al registrar el proveedor.";
        }

    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "Método de solicitud no válido.";
}
?>

