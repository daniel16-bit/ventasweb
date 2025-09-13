<?php
include "../models/conexion.php"; // Aquí está tu conexión PDO con Azure SQL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtener los datos del formulario
        $nombre        = $_POST['nombre'];
        $pais          = $_POST['pais'];
        $codigo_postal = $_POST['codigo_postal'];

        // Consulta SQL con parámetros
        $sql = "INSERT INTO CIUDAD (Nombre_ciudad, Pais, Codigo_postal) 
                VALUES (?, ?, ?)";

        $stmt = $conexion->prepare($sql);

        // Ejecutar con los valores
        $resultado = $stmt->execute([$nombre, $pais, $codigo_postal]);

        if ($resultado) {
            header("Location: ../Ciudades.php");
            exit();
        } else {
            echo "Error al registrar la ciudad.";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "Método de solicitud no válido.";
}
