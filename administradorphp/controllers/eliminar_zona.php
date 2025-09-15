<?php
include "../models/conexion.php"; // Asegúrate de que la conexión está incluida

// Verificamos si el ID de la zona ha sido proporcionado en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Asegúrate de que el ID sea un número entero válido para evitar inyecciones SQL
    if (is_numeric($id)) {
        
        // Consulta para eliminar la zona según el ID proporcionado
        $sql = "DELETE FROM ZONA WHERE ID_Zona = ?";
        
        // Preparamos la consulta
        $stmt = sqlsrv_prepare($conn, $sql, array(&$id));
        
        if ($stmt === false) {
            // Si la preparación de la consulta falla, muestra un mensaje de error
            die(print_r(sqlsrv_errors(), true));
        }
        
        // Ejecutamos la consulta
        if (sqlsrv_execute($stmt)) {
            // Redirigir a la página de zonas después de la eliminación
            header("Location: ../Zonas.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error al eliminar la zona: ' . print_r(sqlsrv_errors(), true) . '</div>';
        }
    } else {
        echo '<div class="alert alert-warning">ID de zona no válido.</div>';
    }
} else {
    echo '<div class="alert alert-warning">No se ha especificado una zona para eliminar.</div>';
}
?>



