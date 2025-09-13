<?php
include "../models/conexion.php"; // Conexión PDO

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Preparar la consulta con PDO
        $sql = "DELETE FROM PROVEEDOR WHERE ID_Proveedor = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$id])) {
            // ✅ Eliminación correcta
            header("Location: ../Proveedores.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">❌ Error al eliminar el proveedor.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">⚠️ Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">⚠️ ID de proveedor no válido.</div>';
}
?>
