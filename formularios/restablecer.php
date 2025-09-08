<?php
include '../models/conexion.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar el token
    $stmt = $conexion->prepare("SELECT ID_Usuario, expira_token FROM USUARIO WHERE token_recuperacion = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario && strtotime($usuario['expira_token']) > time()) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva_contrasena'])) {
            $nueva_contra = trim($_POST['nueva_contrasena']);

            $update = $conexion->prepare("UPDATE USUARIO SET Contraseña = ?, token_recuperacion = NULL, expira_token = NULL WHERE ID_Usuario = ?");
            $update->bind_param("si", $nueva_contra, $usuario['ID_Usuario']);
            $update->execute();

            echo "¡Contraseña restablecida correctamente!";
            exit;
        }
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Restablecer Contraseña</title>
        </head>
        <body>
            <h2>Ingresa tu nueva contraseña</h2>
            <form method="POST">
                <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña" required>
                <button type="submit">Restablecer</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "El enlace ha expirado o es inválido.";
    }
} else {
    echo "Token no válido.";
}
?>
