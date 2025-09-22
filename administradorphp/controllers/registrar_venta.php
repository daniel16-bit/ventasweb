<?php
include '../models/conexion.php';
session_start();

$id_cliente = $_POST['id_cliente'];
$id_vendedor = $_POST['id_vendedor'];
$id_zona = $_POST['id_zona'];
$id_departamento = $_POST['id_departamento'];
$id_producto = $_POST['id_producto'];
$fecha = $_POST['fecha'];
$descuento = $_POST['descuento'];
$total = $_POST['total'];
$cantidad = 1; // Aquí puedes modificar si más adelante agregas un campo "cantidad" en el formulario

// Paso 1: Verificar stock actual
$sql_stock = "SELECT Stock FROM colfar.PRODUCTO WHERE ID_Producto = ?";
$params_stock = array($id_producto);
$stmt_stock = sqlsrv_query($conn, $sql_stock, $params_stock);

if ($stmt_stock && ($row = sqlsrv_fetch_array($stmt_stock, SQLSRV_FETCH_ASSOC))) {
    $stock_actual = $row['Stock'];

    if ($stock_actual >= $cantidad) {
        // Paso 2: Registrar la venta
        $sql_insert = "INSERT INTO colfar.VENTA 
            (ID_Cliente, ID_Vendedor, ID_Zona, ID_Departamento, ID_Producto, Fecha, Descuentos, Total)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params_insert = array($id_cliente, $id_vendedor, $id_zona, $id_departamento, $id_producto, $fecha, $descuento, $total);
        $stmt_insert = sqlsrv_query($conn, $sql_insert, $params_insert);

        if ($stmt_insert) {
            // Paso 3: Descontar del stock
            $nuevo_stock = $stock_actual - $cantidad;
            $sql_update = "UPDATE colfar.PRODUCTO SET Stock = ? WHERE ID_Producto = ?";
            $params_update = array($nuevo_stock, $id_producto);
            $stmt_update = sqlsrv_query($conn, $sql_update, $params_update);

            if ($stmt_update) {
                $_SESSION['mensaje'] = '✅ Venta registrada y stock actualizado correctamente.';
            } else {
                $_SESSION['mensaje'] = '⚠️ Venta registrada, pero error al actualizar el stock.';
            }
        } else {
            $_SESSION['mensaje'] = '❌ Error al registrar la venta.';
        }

    } else {
        $_SESSION['mensaje'] = '❌ Stock insuficiente. Solo hay ' . $stock_actual . ' unidades.';
    }

} else {
    $_SESSION['mensaje'] = '❌ Error al consultar el stock.';
}

header("Location: ../Ventas.php");
exit();
?>
