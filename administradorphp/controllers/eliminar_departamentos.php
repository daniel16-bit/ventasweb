<?php
include "../models/conexion.php"; // Asegúrate de que la conexión está incluida
if (isset($_GET['id'])) {
    $id = $_GET['id'];
 
    $sql = "DELETE FROM DEPARTAMENTO WHERE ID_Departamento = ?";    
     if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {         
            header("Location:../Departamentos.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error al eliminar el Departamento.</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger">Error al preparar la consulta.</div>';
    }
} else {
    echo '<div class="alert alert-warning">No se ha especificado un Departamento para eliminar.</div>';
}
?>
