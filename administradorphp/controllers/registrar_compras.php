<?php
// Incluir la conexión a la base de datos
include '../models/conexion.php';

// Comprobar si los datos fueron enviados via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $fecha = $_POST['fecha'];
    $cantidad = $_POST['cantidad'];
    $id_producto = $_POST['id_producto'];
    $id_proveedor = $_POST['id_proveedor'];

    // Validar que los campos no estén vacíos (puedes agregar más validaciones si es necesario)
    if (empty($fecha) || empty($cantidad) || empty($id_producto) || empty($id_proveedor)) {
        die("Por favor complete todos los campos.");
    }

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO COMPRA (Fecha, Cantidad, ID_Producto, ID_Proveedor) 
            VALUES ('$fecha', '$cantidad', '$id_producto', '$id_proveedor')";

    // Ejecutar la consulta
    if ($conexion->query($sql) === TRUE) {
        echo "Compra registrada con éxito.";
        // Redirigir al listado de compras (o a donde prefieras)
        header("Location:../Compras.php"); // Asegúrate de que la ruta sea correcta
        exit();
    } else {
        echo "Error al registrar la compra: " . $conexion->error;
    }
} else {
    // Si no se hizo una solicitud POST, redirigir a la página de compras
    header("Location: Compras.php");
    exit();
}
?>
