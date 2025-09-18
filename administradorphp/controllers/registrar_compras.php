<?php
// Incluye el archivo de conexión que usa la extensión sqlsrv
include '../models/conexion.php';

// Verifica si la solicitud se hizo a través del método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos del formulario de manera segura
    $fecha        = $_POST['fecha'] ?? null;
    $cantidad     = $_POST['cantidad'] ?? null;
    $id_producto  = $_POST['id_producto'] ?? null;
    $id_proveedor = $_POST['id_proveedor'] ?? null;

    // Validación básica para asegurar que todos los campos estén llenos
    if (empty($fecha) || empty($cantidad) || empty($id_producto) || empty($id_proveedor)) {
        die("Por favor, complete todos los campos.");
    }

    // Consulta SQL para insertar los datos en la tabla COMPRA
    // La conexión sqlsrv maneja la seguridad de los parámetros automáticamente
    $sql = "INSERT INTO colfar.COMPRA (Fecha, Cantidad, ID_Producto, ID_Proveedor) 
            VALUES (?, ?, ?, ?)";
    
    // Prepara el array de parámetros
    $params = array($fecha, $cantidad, $id_producto, $id_proveedor);

    // Ejecuta la consulta
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Verifica si la consulta fue exitosa
    if ($stmt === false) {
        // Manejo de errores detallado
        die("Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true));
    } else {
        // Redirecciona a la página de compras si el registro es exitoso
        header("Location: ../Compras.php");
        exit();
    }
} else {
    // Si la solicitud no es POST, redirecciona para evitar acceso directo al script
    header("Location: ../Compras.php");
    exit();
}
?>

