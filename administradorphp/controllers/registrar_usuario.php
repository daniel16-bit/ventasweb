<?php 
include "../models/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $prime_nombre = $_POST['prime_nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $prime_apellido = $_POST['prime_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $sql = "INSERT INTO USUARIO (Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Telefono, Correo, Contraseña) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    if ($stmt === false) {
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt->bind_param("sssssss", $prime_nombre, $segundo_nombre, $prime_apellido, $segundo_apellido, $telefono, $correo, $contraseña);

    if ($stmt->execute()) {
        header("Location: ../Usuarios.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conexion->close();
} else {
    echo "Método de solicitud no válido.";
}
?>