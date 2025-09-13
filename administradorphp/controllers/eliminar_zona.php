<?php
include "../models/conexion.php"; // Conexión PDO

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Preparar la consulta para eliminar la zona
        $sql = "DELETE FROM ZONA WHERE ID_Zona = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt->execute([$id])) {
            // Redirigir a la página de zonas
            header("Location: ../Zonas.php");
            exit();
        } else {
            echo '<div class="alert alert-danger">Error al eliminar la zona.</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Error en la base de datos: ' . $e->getMessage() . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">No se ha especificado una zona válida para eliminar.</div>';
}
?>

