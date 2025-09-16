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

        // Consulta SQL con parámetros
        $sql = "UPDATE colfar.CIUDAD 
                SET Nombre_ciudad = ?, Pais = ?, Codigo_postal = ? 
                WHERE ID_Ciudad = ?";

        $params = array($nombreCiudad, $pais, $codigoPostal, $idCiudad);

        // Ejecutar consulta
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            echo "❌ Error al actualizar la ciudad: ";
            die(print_r(sqlsrv_errors(), true));
        }

        // Redirigir a la lista de ciudades
        header("Location: ../Ciudades.php");
        exit();

    } else {
        echo "⚠️ Todos los campos son obligatorios.";
    }
}
?>

