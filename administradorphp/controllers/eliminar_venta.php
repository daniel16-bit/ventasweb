<?php
include "../models/conexion.php"; // Aquí defines la conexión con SQLSRV en $conn

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Consulta SQL con esquema + tabla
    $sql = "DELETE FROM colfar.VENTA WHERE ID_Venta = ?";
    $params = [$id];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo '<div class="alert alert-danger">❌ Error al eliminar la venta.</div>';
        die(print_r(sqlsrv_errors(), true));
    } else {
        // ✅ Eliminación exitosa
        header("Location: ../Ventas.php");
        exit();
    }
} else {
    echo '<div class="alert alert-warning">⚠️ No se ha especificado una venta válida para eliminar.</div>';
}
?>

