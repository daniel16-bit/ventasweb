<?php 
include "../models/conexion.php"; // Tu conexión PDO a Azure SQL

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Obtener los datos del formulario
        $prime_nombre     = $_POST['prime_nombre'];
        $segundo_nombre   = $_POST['segundo_nombre'];
        $prime_apellido   = $_POST['prime_apellido'];
        $segundo_apellido = $_POST['segundo_apellido'];
        $telefono         = $_POST['telefono'];
        $correo           = $_POST['correo'];
        $contraseña       = $_POST['contraseña'];
        $rol              = $_POST['rol'];

        // Consulta con parámetros
        $sql = "INSERT INTO USUARIO 
                (Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Telefono, Correo, Contraseña, Rol) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);

        // Ejecutar con arreglo de parámetros
        $resultado = $stmt->execute([
            $prime_nombre,
            $segundo_nombre,
            $prime_apellido,
            $segundo_apellido,
            $telefono,
            $correo,
            $contraseña,
            $rol
        ]);

        if ($resultado) {
            header("Location: ../Usuarios.php");
            exit();
        } else {
            echo "Error al insertar usuario.";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "Método de solicitud no válido.";
}
?>
