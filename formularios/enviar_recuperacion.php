<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

include '../models/conexion.php'; // Conexión SQL Server

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Verificar si el correo existe
    $sql = "SELECT ID_Usuario FROM colfar.USUARIO WHERE Correo = ?";
    $params = [$email];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $usuario = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($usuario) {
        // Generar token
        $token = bin2hex(random_bytes(32));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Guardar token y fecha en DB
        $sqlUpdate = "UPDATE colfar.USUARIO SET token_recuperacion = ?, expira_token = ? WHERE ID_Usuario = ?";
        $paramsUpdate = [$token, $expira, $usuario['ID_Usuario']];
        $stmtUpdate = sqlsrv_query($conn, $sqlUpdate, $paramsUpdate);
        if ($stmtUpdate === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Enviar correo
        $mail = new PHPMailer(true);
        try {
                        $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'camargocamargodaniel0@gmail.com';
            $mail->Password   = 'pzwq prdw volx iobo'; // usar app password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('tu_correo@gmail.com', 'COLFAR');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Recupera tu contraseña';
            $mail->Body    = "
                <h1>Solicitud de restablecimiento de contraseña</h1>
                <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
                <a href='https://colfar-hda8gyhpbzf0cnhf.canadacentral-01.azurewebsites.net/formularios/restablecer.php?token=$token'>Restablecer contraseña</a>
                <p>Este enlace expirará en 1 hora.</p>
            ";

            $mail->send();
            echo "Revisa tu correo para restablecer tu contraseña.";
        } catch (Exception $e) {
            echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
        }

    } else {
        echo "El correo no está registrado.";
    }
}
?>

