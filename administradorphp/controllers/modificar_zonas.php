<?php
include_once '../models/conexion.php'; // conexión con PDO

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar'])) {
    $id_zona         = $_POST['id'] ?? null;
    $nombreZona      = $_POST['nombre'] ?? null;
    $id_departamento = $_POST['departamento'] ?? null;

    if (!empty($id_zona) && !empty($nombreZona) && !empty($id_departamento)) {
        try {
            // Preparar consulta
            $sql = "UPDATE ZONA 
                    SET NombreZona = ?, ID_Departamento = ? 
                    WHERE ID_Zona = ?";
            $stmt = $conexion->prepare($sql);

            // Ejecutar con parámetros
            $resultado = $stmt->execute([$nombreZona, $id_departamento, $id_zona]);

            if ($resultado) {
                header("Location: ../Zonas.php");
                exit();
            } else {
                echo "Error al actualizar la zona.";
            }
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
?>

