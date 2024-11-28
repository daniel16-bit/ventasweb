<?php
include_once '../models/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar'])) {
    $id_zona = $_POST['id'];
    $nombreZona = $_POST['nombre'];
    $id_departamento = $_POST['departamento'];

    // Preparar la consulta para actualizar los datos de la zona
    $sql = "UPDATE ZONA SET NombreZona = ?, ID_Departamento = ? WHERE ID_Zona = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sii", $nombreZona, $id_departamento, $id_zona);

    if ($stmt->execute()) {
        // Redirigir a la página de zonas después de la actualización
        header("Location: ../Zonas.php");
        exit();
    } else {
        echo "Error al actualizar la zona: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
}
?>
