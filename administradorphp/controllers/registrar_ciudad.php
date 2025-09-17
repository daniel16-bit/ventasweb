<?php
include "../models/conexion.php"; // $conn es tu conexión sqlsrv_connect()

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener y limpiar los datos del formulario
    $nombre        = trim($_POST['nombre'] ?? '');
    $pais          = trim($_POST['pais'] ?? '');
    $codigo_postal = trim($_POST['codigo_postal'] ?? '');

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($pais) || empty($codigo_postal)) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    if (!is_numeric($codigo_postal)) {
        echo "El código postal debe ser un número.";
        exit();
    }

    // Preparar la consulta con parámetro
    $sql = "INSERT INTO colfar.CIUDAD (Nombre_ciudad, Pais, Codigo_postal) VALUES (?, ?, ?)";
    $params = array($nombre, $pais, (int)$codigo_postal);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Error al registrar la ciudad: " . print_r(sqlsrv_errors(), true));
    } else {
        sqlsrv_free_stmt($stmt);
        header("Location: ../Ciudades.php");
        exit();
    }
}
?>
