<?php
// Incluir la conexión SQL Server
include "../models/conexion.php"; // Aquí debes tener $conn con sqlsrv_connect()

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitizar el id recibido

    try {
        // Consulta preparada con parámetro
        $sql = "DELETE FROM colfar.USUARIO WHERE ID_Usuario = ?";
        $params = array($id);

        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt) {
            // ✅ Eliminación correcta
            sqlsrv_free_stmt($stmt);
            header("Location: ../Usuarios.php?mensaje=eliminado");
            exit;
        } else {
            // ❌ Error en la consulta
            echo '<div class="alert alert-danger">❌ Error al eliminar el usuario.</div>';
            die(print_r(sqlsrv_errors(), true));
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">⚠️ Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">⚠️ No se ha especificado un usuario válido para eliminar.</div>';
}
?>

