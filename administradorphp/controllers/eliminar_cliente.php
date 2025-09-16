<?php
include "../models/conexion.php"; // Asegúrate de que la conexión está incluida

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    // Preparar la consulta para eliminar el departamento
    $sql = "DELETE FROM colfar.CLIENTE WHERE ID_Cliente = ?";  
    $params = [$id];


     $stmt = sqlsrv_query($conn, $sql, $params);
    // Preparar y ejecutar la declaración
    if ($stmt) {
        
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

?>