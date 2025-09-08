<?php
session_start();
include 'models/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['usuarios_seleccionados'])) {
        $ids = $_POST['usuarios_seleccionados'];

        // Obtener correos de los usuarios seleccionados
        $ids_sanitizados = array_map('intval', $ids); // sanitizar IDs para evitar SQL Injection
        $ids_str = implode(',', $ids_sanitizados);

        $sql = "SELECT Correo, Prime_Nombre FROM USUARIO WHERE ID_Usuario IN ($ids_str)";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            $correos_enviados = 0;
            while ($usuario = $result->fetch_assoc()) {
                $correo = $usuario['Correo'];
                $nombre = $usuario['Prime_Nombre'];

                // Aquí deberías usar tu función de envío de correo, por ejemplo:
                $asunto = "Mensaje desde tu sistema";
                $mensaje = "Hola $nombre,\n\nEste es un mensaje de prueba enviado desde el sistema.";
                $headers = "From: tu_correo@dominio.com";

                // mail() es la función nativa de PHP para enviar correos, puede requerir configuración en tu servidor
                if (mail($correo, $asunto, $mensaje, $headers)) {
                    $correos_enviados++;
                }
            }

            $_SESSION['correos_enviados'] = $correos_enviados > 0;
            header("Location: Usuarios.php");
            exit;
        } else {
            $_SESSION['correos_enviados'] = false;
            header("Location: Usuarios.php");
            exit;
        }
    } else {
        // No se seleccionaron usuarios
        $_SESSION['correos_enviados'] = false;
        header("Location: Usuarios.php");
        exit;
    }
}
?>
