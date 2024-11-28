<?php
// Incluir la conexión a la base de datos
include_once '../models/conexion.php';

// Verificar si el formulario fue enviado para actualizar los datos
if (isset($_POST['modificar'])) {
    // Verificar que el nombre no esté vacío
    if (!empty($_POST['nombre'])) {
        // Recoger los datos del formulario y escaparlos para prevenir inyecciones SQL
        $idDepartamento = $_POST['id'];  // ID del departamento que se va a actualizar
        $nombreDepartamento = mysqli_real_escape_string($conexion, $_POST['nombre']);

        // Usar una sentencia preparada para la actualización
        $sql = "UPDATE DEPARTAMENTO SET Nombre = ? WHERE ID_Departamento = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("si", $nombreDepartamento, $idDepartamento);  // "si" significa: string, entero

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo '<div class="alert alert-success">Departamento actualizado exitosamente.</div>';
            // Redirigir después de la actualización para evitar reenvío del formulario
            header("Location: ../Departamentos.php");
            exit;
        } else {
            echo '<div class="alert alert-danger">Error al actualizar el departamento: ' . $conexion->error . '</div>';
        }
    } else {
        echo '<div class="alert alert-warning">El nombre del departamento es obligatorio.</div>';
    }
}
?>

