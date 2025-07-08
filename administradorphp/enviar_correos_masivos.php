<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

include '../models/conexion.php';

// Aumentar tiempo de ejecución
ini_set('max_execution_time', 300);

$sql = "SELECT Correo, Prime_Nombre FROM USUARIO";
$result = $conexion->query($sql);

$correos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $correos[] = $row;
    }
} else {
    $_SESSION['correos_enviados'] = false;
    header('Location: ./Usuarios.php');
    exit;
}

foreach ($correos as $usuario) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'camargocamargodaniel0@gmail.com';
        $mail->Password   = 'pzwq prdw volx iobo'; // tu clave de aplicación
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('camargocamargodaniel0@gmail.com', 'Administrador del Sistema');
        $mail->addAddress($usuario['Correo'], $usuario['Prime_Nombre']);

        $mail->isHTML(true);
        $mail->Subject = 'Notificación para todos los usuarios';

        $mail->Body = '
        <table style="max-width:600px; margin:auto; font-family: Arial, sans-serif; border:1px solid #ddd; border-radius:8px; padding:20px; background-color:#f9f9f9;">
            <tr>
                <td style="text-align:center; padding-bottom:20px;">
                    <h1 style="color:#4CAF50; margin:0;">¡Hola ' . htmlspecialchars($usuario['Prime_Nombre']) . '!</h1>
                </td>
            </tr>
            <tr>
                <td style="font-size:16px; color:#333; line-height:1.5;">
                    <p>Este es un mensaje automático enviado a todos los usuarios registrados en el sistema.</p>
                    <p>Gracias por ser parte de nuestra plataforma.</p>
                </td>
            </tr>
            <tr>
                <td style="padding-top:20px; text-align:center;">
                    <a href="https://tusitio.com" style="display:inline-block; padding:12px 25px; font-size:16px; color:#ffffff; background-color:#4CAF50; text-decoration:none; border-radius:5px;">Visita nuestro sitio</a>
                </td>
            </tr>
            <tr>
                <td style="padding-top:30px; font-size:12px; color:#777; text-align:center; border-top:1px solid #ddd;">
                    <p>No responda a este mensaje. Fue generado automáticamente.</p>
                </td>
            </tr>
        </table>
        ';

        $mail->send();
    } catch (Exception $e) {
        // Aquí puedes guardar logs de errores si quieres
    }
}

$_SESSION['correos_enviados'] = true;
header('Location: ./Usuarios.php');
exit;


