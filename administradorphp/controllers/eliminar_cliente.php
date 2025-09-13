<?php
include "../models/conexion.php"; // Conexión con PDO

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Preparar la consulta para eliminar el cliente
        $sql = "DELETE FROM CLIENTE WHERE ID_Cliente = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$id])) {
            // Redirigir a la página de clientes después de la eliminación
            header("Location: ../Clientes.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">❌ Error al eliminar el cliente.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">⚠️ Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">⚠️ No se ha especificado un cliente válido para eliminar.</div>';
}
?>



