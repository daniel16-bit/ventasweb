<?php
include "../models/conexion.php"; // Conexión PDO

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Preparar la consulta para eliminar la ciudad
        $sql = "DELETE FROM CIUDAD WHERE ID_Ciudad = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$id])) {
            // Redirigir a la página de ciudades
            header("Location: ../Ciudades.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">❌ Error al eliminar la ciudad.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">⚠️ Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert a








