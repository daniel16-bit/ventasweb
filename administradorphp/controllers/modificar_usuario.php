<?php
include_once '../models/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_usuario = $_POST['id'];  // ID del usuario a modificar
    $prime_nombre = $_POST['prime_nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $prime_apellido = $_POST['prime_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $rol = $_POST['rol'];  // ID del rol a asignar al usuario

    // Consulta para actualizar los datos
    $sql = "UPDATE USUARIO 
            SET Prime_Nombre = ?, Segundo_Nombre = ?, Prime_Apellido = ?, Segundo_Apellido = ?, 
                Telefono = ?, Correo = ?, Contraseña = ?, rol = ?
            WHERE ID_Usuario = ?";
    
    $stmt = $conexion->prepare($sql);
    
    if ($stmt === false) {
        die("Error en la preparación: " . $conexion->error);
    }

    // Vincula los parámetros
    $stmt->bind_param("ssssssssi", $prime_nombre, $segundo_nombre, $prime_apellido, $segundo_apellido, $telefono, $correo, $contraseña, $rol, $id_usuario);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        // Redirige a la página de usuarios
        header("Location: ../Usuarios.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cierra la sentencia y la conexión
    $stmt->close();
    $conexion->close();
} else {
    echo "Método de solicitud no válido.";
}
?>

