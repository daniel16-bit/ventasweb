<?php
include "../models/conexion.php"; // Conexión con PDO

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Preparar la consulta con PDO
        $sql = "DELETE FROM colfar.DEPARTAMENTO WHERE ID_Departamento = ?";
        $params = [$id];

         $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt) {
            // ✅ Eliminación correcta
            header("Location: ../Departamentos.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">❌ Error al eliminar el Departamento.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">⚠️ Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">⚠️ No se ha especificado un Departamento válido para eliminar.</div>';
}
?>

