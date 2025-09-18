<?php
include "../models/conexion.php"; // conexión con $conn

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $sql = "DELETE FROM colfar.CIUDAD WHERE ID_Ciudad = ?";
    $params = [$id];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        header("Location: ../Ciudades.php?msg=eliminado");
        exit;
    } else {
        echo '<div class="alert alert-danger">❌ Error al eliminar la ciudad.</div>';
        die(print_r(sqlsrv_errors(), true));
    }
} else {
    echo '<div class="alert alert-warning">⚠️ ID no válido.</div>';
}
?>








