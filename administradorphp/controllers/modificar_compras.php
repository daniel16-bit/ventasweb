<?php
include_once '../models/conexion.php';

if (isset($_POST['modificar']) && $_POST['modificar'] == 'ok') {
    // Obtener los datos del formulario
    $id_compra = $_POST['id'];
    $fecha = $_POST['fecha'];
    $cantidad = $_POST['cantidad'];
    $id_producto = $_POST['id_producto'];
    $id_proveedor = $_POST['id_proveedor'];

    // Validar los datos si es necesario

    // Actualizar la base de datos
    $sql = "UPDATE COMPRA SET Fecha = '$fecha', Cantidad = '$cantidad', ID_Producto = '$id_producto', ID_Proveedor = '$id_proveedor' WHERE ID_Compra = '$id_compra'";

    if ($conexion->query($sql)) {
        echo "Compra actualizada exitosamente.";
        // Redirigir a otra página si es necesario
        
    } else {
        echo "Error al actualizar la compra: " . $conexion->error;
    }
}
?>
