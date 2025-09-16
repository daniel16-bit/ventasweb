<?php
include "../models/conexion.php"; // conexión con sqlsrv_connect

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Primero borro las compras relacionadas a ese producto
        $sql1 = "DELETE FROM colfar.compra WHERE ID_Producto = ?";
        $params = array($id);
        $stmt1 = sqlsrv_query($conn, $sql1, $params);

        if ($stmt1) {
            // Ahora sí borro el producto
            $sql2 = "DELETE FROM colfar.PRODUCTO WHERE ID_Producto = ?";
            $stmt2 = sqlsrv_query($conn, $sql2, $params);

            if ($stmt2) {
                // ✅ Eliminación completa
                sqlsrv_free_stmt($stmt1);
                sqlsrv_free_stmt($stmt2);
                header("Location: ../Productos.php?mensaje=eliminado");
                exit;
            } else {
                echo '<div class="alert alert-danger">❌ Error al eliminar el producto.</div>';
                die(print_r(sqlsrv_errors(), true));
            }
        } else {
            echo '<div class="alert alert-danger">❌ Error al eliminar compras relacionadas.</div>';
            die(print_r(sqlsrv_errors(), true));
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">⚠️ Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">⚠️ ID de producto no válido.</div>';
}
?>


