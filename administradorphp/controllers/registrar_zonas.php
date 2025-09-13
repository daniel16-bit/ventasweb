<?php
include '../models/conexion.php'; // Conexión PDO configurada para Azure SQL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Recoger los datos del formulario
        $nombreZona = $_POST['nombreZona'];
        $nombre_departamento = $_POST['nombre_departamento'];

        // Verificar si el departamento ya existe
        $sql = "SELECT ID_Departamento FROM DEPARTAMENTO WHERE Nombre = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$nombre_departamento]);
        $id_departamento = $stmt->fetchColumn();

        // Si el departamento no existe, crearlo
        if (!$id_departamento) {
            $sql_insert_departamento = "INSERT INTO DEPARTAMENTO (Nombre) VALUES (?); SELECT SCOPE_IDENTITY();";
            $stmt_insert_departamento = $conexion->prepare($sql_insert_departamento);
            $stmt_insert_departamento->execute([$nombre_departamento]);

            // Obtener el ID del nuevo departamento insertado
            $id_departamento = $stmt_insert_departamento->fetchColumn();
        }

        // Ahora insertar la zona asociada al departamento
        $sql_insert_zona = "INSERT INTO ZONA (NombreZona, ID_Departamento) VALUES (?, ?)";
        $stmt_insert_zona = $conexion->prepare($sql_insert_zona);
        $stmt_insert_zona->execute([$nombreZona, $id_departamento]);

        // Redirigir a la página de zonas
        header("Location: ../Zonas.php");
        exit();

    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
}
?>




