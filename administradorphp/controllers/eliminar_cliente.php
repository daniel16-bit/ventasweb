<?php
include "../models/conexion.php"; // Asegúrate de que la conexión está incluida
if (isset($_GET['id'])) {
    $id = $_GET['id'];
 
    // Preparar la consulta para eliminar el departamento
    $sql = "DELETE FROM CLIENTE WHERE ID_Cliente = ?";    
    // Preparar y ejecutar la declaración
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $id); // 'i' indica que el parámetro es un entero
        if ($stmt->execute()) {
            // Redirigir a la página de departamentos después de la eliminación
            header("Location:../Clientes.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error al eliminar el cliente.</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger">Error al preparar la consulta.</div>';
    }
} else {
    echo '<div class="alert alert-warning">No se ha especificado un cliente para eliminar.</div>';
}
?>


