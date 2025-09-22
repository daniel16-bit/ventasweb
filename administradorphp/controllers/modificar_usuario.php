<?php
include_once '../models/conexion.php'; // conexión con SQL Server

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario       = $_POST['id'] ?? null;
    $prime_nombre     = $_POST['prime_nombre'] ?? null;
    $segundo_nombre   = $_POST['segundo_nombre'] ?? null;
    $prime_apellido   = $_POST['prime_apellido'] ?? null;
    $segundo_apellido = $_POST['segundo_apellido'] ?? null;
    $telefono         = $_POST['telefono'] ?? null;
    $correo           = $_POST['correo'] ?? null;
    $nueva_contra     = $_POST['contraseña'] ?? null;
    $rol              = $_POST['rol'] ?? null;

    if ($id_usuario) {

        // Obtener la contraseña actual desde la base de datos
        $sql_actual = "SELECT Contrasena FROM colfar.USUARIO WHERE ID_Usuario = ?";
        $stmt_actual = sqlsrv_query($conn, $sql_actual, [$id_usuario]);
        $row_actual = sqlsrv_fetch_array($stmt_actual, SQLSRV_FETCH_ASSOC);

        if ($row_actual === false) {
            die("Error al obtener la contraseña actual: " . print_r(sqlsrv_errors(), true));
        }

        $contraseña_actual = $row_actual['Contrasena'];

        // Si la nueva contraseña es diferente de la actual, hashearla
        if (!password_verify($nueva_contra, $contraseña_actual)) {
            $contraseña_final = password_hash($nueva_contra, PASSWORD_DEFAULT);
        } else {
            $contraseña_final = $contraseña_actual; // no ha cambiado
        }

        // Actualizar usuario
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
            $contraseña_final,
            $rol,
            $id_usuario
        ];

        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die("Error al actualizar usuario: " . print_r(sqlsrv_errors(), true));
        }

        header("Location: ../Usuarios.php");
        exit();
    } else {
        echo "⚠️ Falta el ID de usuario.";
    }
} else {
    echo "⚠️ Método no permitido.";
}




