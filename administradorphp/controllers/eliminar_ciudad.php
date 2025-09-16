<?php
include "../models/conexion.php"; // Esto debe definir $conn

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Consulta SQL con parámetro
    $sql = "DELETE FROM colfar.CIUDAD WHERE ID_Ciudad = ?";
    $params = [$id];

    // Ejecutar la consulta con sqlsrv_query
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        // Redirigir después de eliminar
        header("Location: ../Ciudades.php");
        exit;
    } else {
        echo '<div class="alert alert-danger">❌ Error al eliminar la ciudad.</div>';
        die(print_r(sqlsrv_errors(), true)); // Muestra errores exactos
    }
} else {
    echo '<div class="alert alert-warning">⚠️ ID de ciudad no válido.</div>';
}
?>







