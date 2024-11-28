<?php
include "../models/conexion.php"; // Asegúrate de que la conexión está incluida

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Preparar la consulta para eliminar el producto
    $sql = "DELETE FROM PROVEEDOR WHERE ID_Proveedor = ?";
    
    // Preparar y ejecutar la declaración
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $id); // 'i' indica que el parámetro es un entero
        if ($stmt->execute()) {
            // Redirigir a la página de productos después de la eliminación
            header("Location:../Proveedores.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error al eliminar el producto: ' . $stmt->error . '</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger">Error al preparar la consulta: ' . $conexion->error . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">ID de producto no válido.</div>';
}
?>