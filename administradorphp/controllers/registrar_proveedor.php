<?php
include "../models/conexion.php"; // Asegúrate que $conn es tu conexión con sqlsrv_connect()

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre    = $_POST['nombre'] ?? null;
    $telefono  = $_POST['telefono'] ?? null;
    $direccion = $_POST['direccion'] ?? null;

    // Validación simple (puedes mejorarla)
    if (empty($nombre) || empty($telefono) || empty($direccion)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Consulta SQL con parámetros
    $sql = "INSERT INTO colfar.PROVEEDOR (Nombe, Telefono, Dirección) VALUES (?, ?, ?)";
    $params = array($nombre, $telefono, $direccion);

    // Ejecutar consulta
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "❌ Error al registrar el proveedor:<br>";
        die(print_r(sqlsrv_errors(), true));
    } else {
        // Redirección si todo fue bien
        header("Location: ../Proveedores.php");
        exit();
    }
} else {
    echo "Método de solicitud no válido.";
}
?>


