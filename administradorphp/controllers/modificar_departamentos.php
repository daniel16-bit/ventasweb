<?php
// Incluir la conexión PDO
include_once '../models/conexion.php';

if (isset($_POST['modificar'])) {
    $idDepartamento = $_POST['id'] ?? null;
    $nombreDepartamento = $_POST['nombre'] ?? null;

    if (!empty($idDepartamento) && !empty($nombreDepartamento)) {
        try {
            // Sentencia preparada con parámetros
            $sql = "UPDATE DEPARTAMENTO SET Nombre = ? WHERE ID_Departamento = ?";
            $stmt = $conexion->prepare($sql);

            // Ejecutar consulta con parámetros
            $stmt->execute([$nombreDepartamento, $idDepartamento]);

            // Redirigir después de la actualización
            header("Location: ../Departamentos.php");
            exit;
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">Error al actualizar el departamento: ' . $e->getMessage() . '</div>';
        }
    } else {
        echo '<div class="alert alert-warning">El nombre del departamento es obligatorio.</div>';
    }
}
?>


