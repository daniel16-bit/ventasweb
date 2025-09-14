<?php 
include '../models/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $valor_producto = $_POST['valor_producto'];
    $valor_venta = $_POST['valor_venta'];
    $id_proveedor = $_POST['id_proveedor'];
    $stock = $_POST['stock'];
    $existencia = trim($_POST['existencia']);

    // Validar que los campos numéricos realmente lo sean
    if (!is_numeric($valor_producto) || !is_numeric($valor_venta) || 
        !is_numeric($id_proveedor) || !is_numeric($stock) || !is_numeric($existencia)) {
        die("Entrada no válida.");
    }

    // Consulta con parámetros
    $sql = "INSERT INTO PRODUCTO (Nombre, ValorProducto, ValorVenta, ID_Proveedor, Stock, Existencia) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $params = array($nombre, $valor_producto, $valor_venta, $id_proveedor, $stock, $existencia);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        header("Location: ../Productos.php");
        exit();
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
} else {
    echo "Método de solicitud no válido.";
}
?>

