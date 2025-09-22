<?php
include "../models/conexion.php"; // aquí deberías tener tu conexión con sqlsrv_connect()

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        // Redirigir si se insertó correctamente
        header("Location: ../Usuarios.php");
        exit();
    } else {
        // Mostrar error si falla
        echo "Error al insertar usuario: <br>";
        die(print_r(sqlsrv_errors(), true));
    }
} else {
    echo "Método de solicitud no válido.";
}
?>
