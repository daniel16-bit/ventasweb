<?php
include_once '../models/conexion.php'; // Aquí ya deberías tener la conexión con PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_usuario      = $_POST['id'] ?? null;
    $prime_nombre    = $_POST['prime_nombre'] ?? null;
    $segundo_nombre  = $_POST['segundo_nombre'] ?? null;
    $prime_apellido  = $_POST['prime_apellido'] ?? null;
    $segundo_apellido= $_POST['segundo_apellido'] ?? null;
    $telefono        = $_POST['telefono'] ?? null;
    $correo          = $_POST['correo'] ?? null;
    $contraseña      = $_POST['contraseña'] ?? null;
    $rol             = $_POST['rol'] ?? null;  // ID del rol

    if ($id_usuario) {
        try {
            // Consulta con parámetros
            $sql = "UPDATE USUARIO 
                    SET Prime_Nombre = ?, 
                        Segundo_Nombre = ?, 
                        Prime_Apellido = ?, 
                        Segundo_Apellido = ?, 
                        Telefono = ?, 
                        Correo = ?, 
                        Contraseña = ?, 
                        rol = ?
                    WHERE ID_Usuario = ?";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                $prime_nombre,
                $segundo_nombre,
                $prime_apellido,
                $segundo_apellido,
                $telefono,
                $correo,
                $contraseña,
                $rol,
                $id_usuario
            ]);

            // Redirigir a la página de usuarios
            header("Location: ../Usuarios.php");
            exit();

        } catch (PDOException $e) {
            echo "Error al actualizar el usuario: " . $e->getMessage();
        }
    } else {
        echo "Falta el ID de usuario.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>


