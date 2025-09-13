<?php
include_once '../models/conexion.php';

if (!empty($_POST['modificar'])) {
    // Validar que todos los campos estén presentes
    if (!empty($_POST['nombre']) && !empty($_POST['pais']) && !empty($_POST['codigo_postal'])) {

        // Recoger los datos del formulario
        $idCiudad      = $_POST['id'];
        $nombreCiudad  = $_POST['nombre'];
        $pais          = $_POST['pais'];
        $codigoPostal  = $_POST['codigo_postal'];

        try {
            // Preparar la consulta con parámetros
            $sql = "UPDATE CIUDAD 
                    SET Nombre_ciudad = ?, Pais = ?, Codigo_postal = ? 
                    WHERE ID_Ciudad = ?";
            $stmt = $conexion->prepare($sql);

            // Ejecutar la consulta con los valores
            $stmt->execute([$nombreCiudad, $pais, $codigoPostal, $idCiudad]);

            // Redirigir a la lista de ciudades
            header("Location: ../Ciudades.php");
            exit();

        } catch (PDOException $e) {
            echo "❌ Error al actualizar la ciudad: " . $e->getMessage();
        }
    } else {
        echo "⚠️ Todos los campos son obligatorios.";
    }
}
?>

