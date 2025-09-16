<?php
include "../models/conexion.php"; // Conexión con SQL Server usando sqlsrv

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Consulta SQL con parámetro
        $sql = "DELETE FROM colfar.COMPRA WHERE ID_Compra = ?";
        $params = [$id];

        // Ejecutar consulta
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            // ❌ Error al ejecutar
            echo '<div class="alert alert-danger">❌ Error al eliminar compra.</div>';
            die(print_r(sqlsrv_errors(), true));
        } else {
            // ✅ Eliminación exitosa
            header("Location: ../Compras.php");
            exit;
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">⚠️ Error inesperado: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">⚠️ No se ha especificado una compra válida para eliminar.</div>';
}
?>

