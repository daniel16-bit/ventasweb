<?php
include "../models/conexion.php"; // Asegúrate de que la conexión está incluida

// Verificamos si el ID de la zona ha sido proporcionado en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Consulta para eliminar la zona según el ID proporcionado
    $sql = "DELETE FROM ZONA WHERE ID_Zona = ?";    
    
    // Ejecutamos la consulta
    if ($stmt = sqlsrv_query($conn, $sql, array($id))) {
        // Redirigir a la página de zonas después de la eliminación
        header("Location:../Zonas.php");
        exit;
    } else {
        echo '<div class="alert alert-danger">Error al eliminar la zona.</div>';
    }
} else {
    echo '<div class="alert alert-warning">No se ha especificado una zona para eliminar.</div>';
}
?>


