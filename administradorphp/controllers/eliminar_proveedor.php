<?php
// Incluir conexión a SQL Server
include "../models/conexion.php"; // Aquí deberías tener $conn con sqlsrv_connect()

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id']; // Sanitizar ID recibido

    try {
        // Consulta preparada con parámetro
        $sql = "DELETE FROM colfar.PROVEEDOR WHERE ID_Proveedor = ?";
        $params = array($id);

        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt) {
            // ✅ Eliminación correcta
            sqlsrv_free_stmt($stmt);
            header("Location: ../Proveedores.php?mensaje=eliminado");
            exit;
        } else {
            // ❌ Error en la ejecución
            echo '<div class="alert alert-danger">❌ Error al eliminar el proveedor.</div>';
            die(print_r(sqlsrv_errors(), true));
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">⚠️ Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">⚠️ ID de proveedor no válido.</div>';
}
?>

