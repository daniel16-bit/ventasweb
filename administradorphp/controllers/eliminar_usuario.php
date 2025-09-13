<?php
include "../models/conexion.php"; // Conexión PDO

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Consulta con parámetro
        $sql = "DELETE FROM USUARIO WHERE ID_Usuario = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$id])) {
            // ✅ Eliminación correcta
            header("Location: ../Usuarios.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">❌ Error al eliminar el usuario.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">⚠️ Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">⚠️ No se ha especificado un usuario para eliminar.</div>';
}
?>
