<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

// Conexión a SQL Server con PDO
$serverName = "localhost"; // Cambia por tu servidor
$database   = "COLFAR";    // Tu base de datos
$username   = "sa";         // Usuario SQL Server
$password   = "tu_password"; // Contraseña

try {
    $conexion = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['usuarios_seleccionados'])) {
        $ids = $_POST['usuarios_seleccionados'];
        $ids_sanitizados = array_map('intval', $ids);
        $placeholders = implode(',', array_fill(0, count($ids_sanitizados), '?'));

        $stmt = $conexion->prepare("SELECT Correo, Prime_Nombre FROM USUARIO WHERE ID_

