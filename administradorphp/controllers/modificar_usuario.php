<?php
include_once '../models/conexion.php'; // conexión con SQL Server

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar datos del formulario
    $id_usuario       = $_POST['id'] ?? null;
    $prime_nombre     = $_POST['prime_nombre'] ?? null;
    $segundo_nombre   = $_POST['segundo_nombre'] ?? null;
    $prime_apellido   = $_POST['prime_apellido'] ?? null;
    $segundo_apellido = $_POST['segundo_apellido'] ?? null;
    $telefono         = $_POST['telefono'] ?? null;
    $correo           = $_POST['correo'] ?? null;
    $contraseña       = $_POST['contraseña'] ?? null;
    $rol              = $_POST['rol'] ?? null;

    if ($id_usuario) {
        $sql = "UPDATE colfar.USUARIO 
        SET Prime_Nombre = ?, 
            Segundo_Nombre = ?, 
            Prime_Apellido = ?, 
            Segundo_Apellido = ?, 
            Telefono = ?, 
            Correo = ?, 
            Contrasena = ?, 
            Rol = ?
        WHERE ID_Usuario = ?";


        $params = [
            $prime_nombre,
            $segundo_nombre,
            $prime_apellido,
            $segundo_apellido,
            $telefono,
            $correo,
            $contraseña,
            $rol,
            $id_usuario
        ];

        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die("Error al actualizar usuario: " . print_r(sqlsrv_errors(), true));
        }

        // Redirigir al listado
        header("Location: ../Usuarios.php");
        exit();
    } else {
        echo "⚠️ Falta el ID de usuario.";
    }
} else {
    echo "⚠️ Método no permitido.";
}



