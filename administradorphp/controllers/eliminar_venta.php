<?php
include "../models/conexion.php"; // Conexión PDO

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Preparar la consulta para eliminar la venta
        $sql = "DELETE FROM VENTA WHERE ID_Venta = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$id])) {
            // Redirigir a la página de ventas
            header("Location: ../Ventas.php");
            exit();
        } else {
            echo '<div class="alert alert-danger">Error al eliminar la venta.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">No se ha especificado una venta válida para eliminar.</div>';
}
?>
