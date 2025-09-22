<?php
include "../models/conexion.php"; // conexión con SQL Server

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $prime_nombre     = $_POST['prime_nombre'];
    $segundo_nombre   = $_POST['segundo_nombre'];
    $prime_apellido   = $_POST['prime_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];
    $telefono         = $_POST['telefono'];
    $correo           = $_POST['correo'];
    $contraseña       = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // ✅ ENCRIPTACIÓN AQUÍ
    $rol              = $_POST['rol'];

    // Consulta con parámetros
    $sql = "INSERT INTO colfar.USUARIO 
            (Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Telefono, Correo, Contrasena, Rol) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Parámetros en el mismo orden que la consulta
    $params = [
        $prime_nombre,
        $segundo_nombre,
        $prime_apellido,
        $segundo_apellido,
        $telefono,
        $correo,
        $contraseña,
        $rol
    ];

    // Ejecutar consulta
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        header("Location: ../Usuarios.php");
        exit();
    } else {
        echo "Error al insertar usuario: <br>";
        die(print_r(sqlsrv_errors(), true));
    }
} else {
    echo "Método de solicitud no válido.";
}
?>

