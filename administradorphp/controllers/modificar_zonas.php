<?php
include_once '../models/conexion.php'; // conexión con PDO

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar'])) {
    $id_zona         = $_POST['id'] ?? null;
    $nombreZona      = $_POST['nombre'] ?? null;
    $id_departamento = $_POST['departamento'] ?? null;

    // Validación de campos no vacíos y asegurarnos de que ID es numérico
    if (!empty($id_zona) && !empty($nombreZona) && !empty($id_departamento)) {
        if (!is_numeric($id_zona) || !is_numeric($id_departamento)) {
            echo "El ID de zona y el ID de departamento deben ser numéricos.";
            exit();
        }

        try {
            // Preparar consulta
            $sql = "UPDATE colfar.ZONA SET NombreZona = ?, ID_Departamento = ? WHERE ID_Zona = ?";
            
            // Preparar la consulta usando sqlsrv_prepare
            $stmt = sqlsrv_prepare($conn, $sql, array(&$nombreZona, &$id_departamento, &$id_zona));
            
            // Verificar si la preparación fue exitosa
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            // Ejecutar la consulta
            $resultado = sqlsrv_execute($stmt);

            // Verificar si la ejecución fue exitosa
            if ($resultado) {
                // Redirigir después de la actualización exitosa
                header("Location: ../Zonas.php");
                exit(); // Asegúrate de llamar a exit() después de la redirección.
            } else {
                echo "Error al actualizar la zona.";
            }
        } catch (Exception $e) {
            echo "Error en la base de datos: " . $e->getMessage();
        }
    } else { 
        echo "Por favor, complete todos los campos.";
    }
}
?>




