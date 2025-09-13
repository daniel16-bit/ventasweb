<?php
include "../models/conexion.php"; // Conexión con PDO

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Preparar la consulta
        $sql = "DELETE FROM COMPRA WHERE ID_Compra = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$id])) {
            // ✅ Eliminación exitosa
            header("Location: ../Compras.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">❌ Error al eliminar la compra.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">⚠️ Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">⚠️ No se ha especificado una compra válida para eliminar.</div>';
}
?>
