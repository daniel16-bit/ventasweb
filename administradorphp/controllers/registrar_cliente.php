<?php
include "../models/conexion.php"; // $conn es sqlsrv_connect()

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y limpiar los datos del formulario
    $tipo      = trim($_POST["tipo"] ?? '');
    $nombre    = trim($_POST['nombre'] ?? '');
    $telefono  = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');

    // Validar que los campos no estén vacíos
    if (empty($tipo) || empty($nombre) || empty($telefono) || empty($direccion)) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    // Preparar la consulta con parámetros
    $sql = "INSERT INTO colfar.CLIENTE (Tipo, Nombre, Telefono, Direccion) VALUES (?, ?, ?, ?)";
    $params = array($tipo, $nombre, $telefono, $direccion);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Error al registrar el cliente: " . print_r(sqlsrv_errors(), true));
    } else {
        sqlsrv_free_stmt($stmt);
        header("Location: ../Clientes.php");
        exit();
    }
}
?>
