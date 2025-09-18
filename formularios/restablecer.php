<?php
include '../models/conexion.php'; // Conexión SQL Server

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar el token y fecha de expiración
    $sql = "SELECT ID_Usuario, expira_token FROM colfar.USUARIO WHERE token_recuperacion = ?";
    $params = [$token];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $usuario = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($usuario) {
        // Convertir fecha a DateTime
        $expira = $usuario['expira_token'];
        if ($expira instanceof DateTime) {
            $expiraDateTime = $expira;
        } else {
            $expiraDateTime = new DateTime($expira);
        }

        $ahora = new DateTime();

        if ($ahora > $expiraDateTime) {
            die("El enlace ha expirado.");
        }

        // Si se envió el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva_contrasena'])) {
            $nueva_contra = trim($_POST['nueva_contrasena']);
            $hash = password_hash($nueva_contra, PASSWORD_DEFAULT);

            $sqlUpdate = "UPDATE colfar.USUARIO SET Contraseña = ?, token_recuperacion = NULL, expira_token = NULL WHERE ID_Usuario = ?";
            $paramsUpdate = [$hash, $usuario['ID_Usuario']];
            $stmtUpdate = sqlsrv_query($conn, $sqlUpdate, $paramsUpdate);

            if ($stmtUpdate === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            echo "¡Contraseña restablecida correctamente!";
            exit;
        }

        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Restablecer Contraseña</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="container mt-5">
            <h2>Ingresa tu nueva contraseña</h2>
            <form method="POST">
                <div class="mb-3">
                    <input type="password" name="nueva_contrasena" class="form-control" placeholder="Nueva contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary">Restablecer</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "El enlace es inválido.";
    }
} else {
    echo "Token no válido.";
}
?>

