<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

include '../models/conexion.php'; // tu conexión a SQL Server
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Verificar si el correo existe
    $sql = "SELECT ID_Usuario FROM colfar.usuario WHERE Correo = ?";
    $params = [$email];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($row) {
        // Generar token
        $token = bin2hex(random_bytes(32));
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Guardar token y fecha en la base de datos
        $sqlUpdate = "UPDATE colfar.usuario SET token_recuperacion = ?, expira_token = ? WHERE Correo = ?";
        $paramsUpdate = [$token, $expira, $email];
        $stmtUpdate = sqlsrv_query($conn, $sqlUpdate, $paramsUpdate);

        if ($stmtUpdate === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Enviar correo con PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'camargocamargodaniel0@gmail.com';
            $mail->Password   = 'pzwq prdw volx iobo'; // usar app password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('camargocamargodaniel0@gmail.com', 'COLFAR');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Recupera tu contraseña';
            $mail->Body    = "
                <h1>Solicitud de restablecimiento de contraseña</h1>
                <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
                <a href='https://tusitio.com/restablecer.php?token=$token'>Restablecer contraseña</a>
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
