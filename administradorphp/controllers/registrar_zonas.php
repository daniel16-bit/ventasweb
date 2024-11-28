<?php
include '../models/conexion.php'; // Asegúrate de que este archivo esté correctamente configurado

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $nombreZona = $_POST['nombreZona'];
    $nombre_departamento = $_POST['nombre_departamento'];

    // Primero, verificar si el departamento ya existe
    $sql = "SELECT ID_Departamento FROM DEPARTAMENTO WHERE Nombre = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $nombre_departamento);
    $stmt->execute();
    $stmt->bind_result($id_departamento);
    $stmt->fetch();
    
    // Si el departamento no existe, crearlo
    if (!$id_departamento) {
        $sql_insert_departamento = "INSERT INTO DEPARTAMENTO (Nombre) VALUES (?)";
        $stmt_insert_departamento = $conexion->prepare($sql_insert_departamento);
        $stmt_insert_departamento->bind_param("s", $nombre_departamento);

        if ($stmt_insert_departamento->execute()) {
            // Obtener el ID del nuevo departamento insertado
            $id_departamento = $stmt_insert_departamento->insert_id;
        } else {
            echo "Error al insertar departamento: " . $stmt_insert_departamento->error;
            $stmt_insert_departamento->close();
            $conexion->close();
            exit();
        }
        $stmt_insert_departamento->close();
    }
    
    // Ahora insertar la zona asociada al departamento
    $sql_insert_zona = "INSERT INTO ZONA (NombreZona, ID_Departamento) VALUES (?, ?)";
    $stmt_insert_zona = $conexion->prepare($sql_insert_zona);
    $stmt_insert_zona->bind_param("si", $nombreZona, $id_departamento);

    if ($stmt_insert_zona->execute()) {
        // Redirigir a la página de zonas (o cualquier página que desees)
        header("Location: ../Zonas.php"); 
        exit();
    } else {
        echo "Error al insertar zona: " . $stmt_insert_zona->error;
    }
    $stmt_insert_zona->close();
    $conexion->close();
}
?>


