<?php
include '../models/conexion.php';
session_start();

// Validar que llegue por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id          = intval($_POST['ID_Producto']);
    $nombre      = trim($_POST['Nombre']);
    $idProveedor = intval($_POST['ID_Proveedor']);
    $valorProd   = floatval($_POST['ValorProducto']);
    $valorVenta  = floatval($_POST['ValorVenta']);
    $stock       = intval($_POST['Stock']);
    $existencia  = intval($_POST['Existencia']);

    // Query UPDATE
    $sql = "UPDATE colfar.PRODUCTO 
            SET Nombre = ?, 
                ID_Proveedor = ?, 
                ValorProducto = ?, 
                ValorVenta = ?, 
                Stock = ?, 
                Existencia = ?
            WHERE ID_Producto = ?";

    $params = [$nombre, $idProveedor, $valorProd, $valorVenta, $stock, $existencia, $id];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die("Error al actualizar producto: " . print_r(sqlsrv_errors(), true));
    } else {
        // Redirigir de vuelta a la vista de productos
        header("Location: ../Productos.php?msg=Producto actualizado correctamente");
        exit;
    }
} else {
    header("Location: ..Productos.php?error=Acceso inválido");
    exit;
}
