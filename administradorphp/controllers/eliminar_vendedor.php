<?php
include "../models/conexion.php"; // Conexión con PDO

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Consulta para eliminar el vendedor
        $sql = "DELETE FROM VENDEDOR WHERE ID_Vendedor = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$id])) {
            // ✅ Eliminación correcta → redirigir
            header("Location: ../Vendedores.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">❌ Error al eliminar el vendedor.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">⚠️ Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">⚠️ No se ha especificado un vendedor para eliminar.</div>';
}
?>
