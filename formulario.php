<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer-master/src/Exception.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['name'] ?? '';
    $correo = $_POST['email'] ?? '';
    $asunto = $_POST['subject'] ?? '';
    $mensajeUsuario = $_POST['message'] ?? '';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'camargocamargodaniel0@gmail.com';  
        $mail->Password = 'pzwq prdw volx iobo'; // Sustituye con tu clave real
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('camargocamargodaniel0@gmail.com', $nombre);
        $mail->addAddress('camargocamargodaniel0@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = $asunto;

        $mail->Body = "
            <div style='font-family: Arial, sans-serif; font-size:16px; max-width:600px; margin:auto; padding:20px; border:1px solid #ddd; border-radius:8px; background:#f9f9f9;'>
                <h2 style='color:#2c3e50;'>📩 Nuevo mensaje de contacto</h2>
                <p><strong>👤 Nombre:</strong> <span style='font-size:18px;'>$nombre</span></p>
                <p><strong>✉️ Correo:</strong> <span style='font-size:18px;'>$correo</span></p>
                <p><strong>📝 Asunto:</strong> <span style='font-size:18px;'>$asunto</span></p>
                <hr style='margin:20px 0;'>
                <p><strong>💬 Mensaje:</strong></p>
                <p style='background:#fff; padding:10px; border:1px solid #ccc; border-radius:5px; font-size:17px;'>$mensajeUsuario</p>
                <p style='margin-top:30px; font-size:14px; color:#888;'>Enviado desde el sitio web</p>
            </div>
        ";

        $mail->send();
        $mensaje = '<p style="color: green;">✅ El mensaje ha sido enviado correctamente.</p>';
    } catch (Exception $e) {
        $mensaje = '<p style="color: red;">❌ Error al enviar el mensaje: ' . $mail->ErrorInfo . '</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <div>
                <a href="index.php" class="for">Volver al inicio</a>
            </div>
            <h1>Formulario de Contacto</h1>

            <?= $mensaje; ?> <!-- Mostrar mensaje de estado -->

            <form action="" method="post" class="contact-form" novalidate>
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" class="form-user" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" class="form-user" required>
                </div>
                <div class="form-group">
                    <label for="subject">Asunto:</label>
                    <input type="text" id="subject" name="subject" class="form-user" required>
                </div>
                <div class="form-group">
                    <label for="message">Mensaje:</label>
                    <textarea id="message" name="message" rows="4" class="form-user" required></textarea>
                </div>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>
</html>
