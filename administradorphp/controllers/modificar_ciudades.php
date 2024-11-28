<?php
include_once '../models/conexion.php';


if (!empty($_POST['modificar'])) {

    // Verificar si los campos no están vacíos
    if (!empty($_POST['nombre']) && !empty($_POST['pais']) && !empty($_POST['codigo_postal'])) {

        // Recoger los datos del formulario y escapar los valores
        $idCiudad = $_POST['id'];
        $nombreCiudad = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $pais = mysqli_real_escape_string($conexion, $_POST['pais']);
        $codigoPostal = mysqli_real_escape_string($conexion, $_POST['codigo_postal']);

        // Comprobar que la conexión esté activa
        if ($conexion) {
            // Preparar la consulta SQL para actualizar los datos
            $sql = "UPDATE CIUDAD SET Nombre_ciudad = '$nombreCiudad', Pais = '$pais', Codigo_postal = '$codigoPostal' WHERE ID_Ciudad = '$idCiudad'";

            // Ejecutar la consulta
            if (mysqli_query($conexion, $sql)) {
                echo '<div class="alert alert-danger">Ciudad actualizada exitosamente.</div>';;
            }
            header("Location:../Ciudades.php"); 
        } 
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>
