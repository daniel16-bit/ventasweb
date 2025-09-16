<?php
include_once '../models/conexion.php'; // aquí deberías tener $conn con sqlsrv_connect

if (isset($_POST['modificar']) && $_POST['modificar'] === 'ok') {
    // Obtener los datos del formulario
    $id_compra    = $_POST['id'] ?? null;
    $fecha        = $_POST['fecha'] ?? null;
    $cantidad     = $_POST['cantidad'] ?? null;
    $id_producto  = $_POST['id_producto'] ?? null;
    $id_proveedor = $_POST['id_proveedor'] ?? null;

    // Validar que todos los campos tengan datos
    if ($id_compra && $fecha && $cantidad && $id_producto && $id_proveedor) {
        // Consulta con parámetros
        $sql = "UPDATE colfar.COMPRA 
                SET Fecha = ?, 
                    Cantidad = ?, 
                    ID_Producto = ?, 
                    ID_Proveedor = ?
                WHERE ID_Compra = ?";

        $params = [$fecha, $cantidad, $id_producto, $id_proveedor, $id_compra];

        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            // Mostrar error si la consulta falla
            die("Error al actualizar la compra: " . print_r(sqlsrv_errors(), true));
        }

        // Redirigir a la lista de compras
        header("Location: ../Compras.php");
        exit;
    } else {
        echo "⚠️ Todos los campos son obligatorios.";
    }
}
?>


