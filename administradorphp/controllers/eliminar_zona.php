<?php
include "../models/conexion.php"; // Asegúrate de que la conexión está incluida

// Verificamos si el ID de la zona ha sido proporcionado en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Consulta para eliminar la zona según el ID proporcionado
    $sql = "DELETE FROM ZONA WHERE ID_Zona = ?";    
    
    // Preparar y ejecutar la declaración
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $id); // 'i' indica que el parámetro es un entero
        if ($stmt->execute()) {
            // Redirigir a la página de zonas después de la eliminación
            header("Location:../Zonas.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error al eliminar la zona.</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger">Error al preparar la consulta.</div>';
    }
} else {
    echo '<div class="alert alert-warning">No se ha especificado una zona para eliminar.</div>';
}
?>
