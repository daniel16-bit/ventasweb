<?php 
include '../models/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $valor_producto = $_POST['valor_producto'];
    $valor_venta = $_POST['valor_venta'];
    $id_proveedor = $_POST['id_proveedor'];
    $stock =  $_POST['stock'];
    $existencia = trim($_POST['existencia']);

    $sql = "INSERT INTO PRODUCTO (Nombre, ValorProducto, ValorVenta, ID_Proveedor, Stock, Existencia) VALUES (?, ?, ?, ?, ?, ?)";
    if (!is_numeric($valor_producto) || !is_numeric($valor_venta) || !is_numeric($id_proveedor) || !is_numeric($stock) || !is_numeric($existencia)) {
        die("Entrada no válida.");
    }
    
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("ssiiii", $nombre, $valor_producto, $valor_venta, $id_proveedor, $stock, $existencia);

        if ($stmt->execute()) {
            header("location:../Productos.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $conexion->error;
    }
    $stmt->close();
    $conexion->close();
} else {
    echo "Método de solicitud no válido.";
}

?>
