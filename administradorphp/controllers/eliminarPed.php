<?php
include '../models/conexion.php'; // Conexión PDO

if (!$conexion) {
    die("No se pudo conectar a la base de datos.");
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id']; // ID del pedido

    try {
        // Preparar la consulta para eliminar el pedido
        $sql = "DELETE FROM PEDIDO WHERE ID_Pedido = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$id])) {
            // Redirigir a la página de pedidos
            header("Location: ../../vendedor/Pedidos.php");
            exit();
        } else {
            echo '<div class="alert alert-danger">Error al eliminar el pedido.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">No se ha especificado un pedido válido para eliminar.</div>';
}
?>

