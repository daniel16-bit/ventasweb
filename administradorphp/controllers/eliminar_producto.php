<?php
include "../models/conexion.php"; // Conexión con PDO

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Preparar consulta con parámetro
        $sql = "DELETE FROM PRODUCTO WHERE ID_Producto = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$id])) {
            // ✅ Eliminación correcta
            header("Location: ../Productos.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">❌ Error al eliminar el producto.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">⚠️ Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">⚠️ ID de producto no válido.</div>';
}
?>


