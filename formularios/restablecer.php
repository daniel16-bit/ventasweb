<?php
include '../models/conexion.php'; // Conexión SQL Server

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verificar token
    $sql = "SELECT ID_Usuario, expira_token FROM colfar.USUARIO WHERE token_recuperacion = ?";
    $params = [$token];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) die(print_r(sqlsrv_errors(), true));

    $usuario = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($usuario) {
        $expira = $usuario['expira_token'];
        $expiraDateTime = ($expira instanceof DateTime) ? $expira : new DateTime($expira);
        $ahora = new DateTime();

        if ($ahora > $expiraDateTime) {
            die('<div class="alert alert-danger text-center mt-5">El enlace ha expirado.</div>');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nueva_contrasena'])) {
            $nueva_contra = trim($_POST['nueva_contrasena']);
            $hash = password_hash($nueva_contra, PASSWORD_DEFAULT);

            $sqlUpdate = "UPDATE colfar.USUARIO SET Contrasena = ?, token_recuperacion = NULL, expira_token = NULL WHERE ID_Usuario = ?";
            $paramsUpdate = [$hash, $usuario['ID_Usuario']];
            $stmtUpdate = sqlsrv_query($conn, $sqlUpdate, $paramsUpdate);

            if ($stmtUpdate === false) die(print_r(sqlsrv_errors(), true));

            echo '<div class="alert alert-success text-center mt-5">
                    ¡Contraseña restablecida correctamente!<br>
                    Redirigiendo al login...
                  </div>';
            echo '<meta http-equiv="refresh" content="3;url=../index.php">';
            exit;
        }

        // Formulario HTML
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Restablecer Contraseña</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow">
                        <div class="card-body">
                            <h3 class="card-title text-center mb-4">Restablecer Contraseña</h3>
                            <form method="POST">
                                <div class="mb-3">
                                    <input type="password" name="nueva_contrasena" class="form-control" placeholder="Nueva contraseña" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Restablecer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo '<div class="alert alert-danger text-center mt-5">El enlace es inválido.</div>';
    }

} else {
    echo '<div class="alert alert-danger text-center mt-5">Token no válido.</div>';
}
?>


