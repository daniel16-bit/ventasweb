<?php
include_once '../models/conexion.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id_venta   = $_POST['id'];
    $fecha      = $_POST['fecha'];
    $descuentos = $_POST['descuentos'] ?? 0;
    $total      = $_POST['total'];
    $id_cliente = $_POST['cliente'];
    $id_producto = $_POST['producto'];

    // Validar campos
    if (!empty($id_venta) && !empty($fecha) && !empty($total) && !empty($id_cliente) && !empty($id_producto)) {
        
        // Convertir fecha a formato DateTime para SQL Server
        $fecha_sql = date('Y-m-d H:i:s', strtotime($fecha));

        $sql = "UPDATE colfar.VENTA
                SET Fecha = ?, Descuentos = ?, Total = ?, ID_Cliente = ?, ID_Producto = ?
                WHERE ID_Venta = ?";

        $params = array($fecha_sql, $descuentos, $total, $id_cliente, $id_producto, $id_venta);

        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die("Error al actualizar la venta: " . print_r(sqlsrv_errors(), true));
        } else {
            // Redirigir de nuevo a la tabla de ventas
            header("Location: ../Ventas.php");
            exit;
        }
    } else {
        echo "Todos los campos obligatorios deben estar completos.";
    }
} else {
    echo "Acceso inválido.";
}
