<?php
include '../models/conexion.php'; // conexión PDO a Azure SQL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Recibir datos del formulario
        $id_zona    = $_POST['id_zona'] ?? null;
        $id_usuario = $_POST['id_usuario'] ?? null;

        // Validar
        if (!empty($id_zona) && !empty($id_usuario)) {
            // Consulta con parámetros para evitar SQL Injection
            $sql = "INSERT INTO VENDEDOR (ID_Zona, ID_Usuario) VALUES (?, ?)";
            $stmt = $conexion->prepare($sql);
            $resultado = $stmt->execute([$id_zona, $id_usuario]);

            if ($resultado) {
                header("Location: ../Vendedores.php");
                exit();
            } else {
                echo "Error al registrar el vendedor.";
            }
        } else {
            echo "Por favor, complete todos los campos.";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
}
?>

