<?php
include "../models/conexion.php"; // Asegúrate de que $conn esté definido

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Consulta para eliminar al vendedor
    $sql = "DELETE FROM colfar.VENDEDOR WHERE ID_Vendedor = ?";
    $params = [$id];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        // ✅ Eliminado correctamente, redirigir
        header("Location: ../Vendedores.php");
        exit;
    } else {
        echo '<div class="alert alert-danger">❌ Error al eliminar el vendedor.</div>';
        die(print_r(sqlsrv_errors(), true)); // Mostrar errores
    }
} else {
    echo '<div class="alert alert-warning">⚠️ No se ha especificado un vendedor válido para eliminar.</div>';
}
?>

