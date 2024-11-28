<?php
  // Verificar si el formulario ha sido enviado
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $mensaje = $_POST["mensaje"];

    // Validar los datos
    if (empty($nombre) || empty($correo) || empty($mensaje)) {
      echo "Por favor, complete todos los campos.";
      exit;
    }

    // Enviar el correo electrónico
    $asunto = "Mensaje de contacto desde $nombre";
    $cuerpo = "Nombre: $nombre\nCorreo electrónico: $correo\nMensaje: $mensaje";
    $cabeceras = "From: $correo\r\nReply-To: $correo";

    mail("camargocamargodaniel0@gmail.com", $asunto, $cuerpo, $cabeceras);

    echo "Mensaje enviado con éxito.";
  }
?>
