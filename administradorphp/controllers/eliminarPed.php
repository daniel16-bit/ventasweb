<?php
include '../models/conexion.php'; // Asegúrate de que la conexión está incluida
if (!$conexion) {
    die("No se pudo conectar a la base de datos.");
}

if (isset($_GET['id'])) {
    $id = $_GET['id']; // Obtenemos el ID del pedido desde el parámetro GET
    // Preparar la consulta para eliminar el pedido
    $sql = "DELETE FROM PEDIDO WHERE ID_Pedido = ?";
    
    // Preparar y ejecutar la declaración
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $id); // 'i' indica que el parámetro es un entero
        if ($stmt->execute()) {
            // Redirigir a la página de pedidos después de la eliminación
            header("Location: ../../vendedor/Pedidos.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error al eliminar el Pedido.</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger">Error al preparar la consulta.</div>';
    }
} else {
    echo '<div class="alert alert-warning">No se ha especificado un Pedido para eliminar.</div>';
}
?>
