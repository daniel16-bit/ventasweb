<?php
include_once '../models/conexion.php';

if (isset($_POST['modificar']) && $_POST['modificar'] === 'ok') {
    // Obtener los datos del formulario
    $id_compra   = $_POST['id'] ?? null;
    $fecha       = $_POST['fecha'] ?? null;
    $cantidad    = $_POST['cantidad'] ?? null;
    $id_producto = $_POST['id_producto'] ?? null;
    $id_proveedor = $_POST['id_proveedor'] ?? null;

    // Validar datos obligatorios
    if ($id_compra && $fecha && $cantidad && $id_producto && $id_proveedor) {
        try {
            // Consulta con parámetros preparados
            $sql = "UPDATE COMPRA 
                    SET Fecha = ?, Cantidad = ?, ID_Producto = ?, ID_Proveedor = ? 
                    WHERE ID_Compra = ?";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([$fecha, $cantidad, $id_producto, $id_proveedor, $id_compra]);

            // Mensaje de éxito o redirección
            header("Location: ../Compras.php");
            exit;

        } catch (PDOException $e) {
            echo "Error al actualizar la compra: " . $e->getMessage();
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>

