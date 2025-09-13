<?php
// Incluir la conexión a la base de datos (PDO con Azure SQL)
include '../models/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Recibir los datos del formulario
        $fecha        = $_POST['fecha'];
        $cantidad     = $_POST['cantidad'];
        $id_producto  = $_POST['id_producto'];
        $id_proveedor = $_POST['id_proveedor'];

        // Validación básica
        if (empty($fecha) || empty($cantidad) || empty($id_producto) || empty($id_proveedor)) {
            die("Por favor complete todos los campos.");
        }

        // Preparar la consulta con parámetros
        $sql = "INSERT INTO COMPRA (Fecha, Cantidad, ID_Producto, ID_Proveedor) 
                VALUES (?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);

        // Ejecutar con los valores
        $resultado = $stmt->execute([$fecha, $cantidad, $id_producto, $id_proveedor]);

        if ($resultado) {
            header("Location: ../Compras.php");
            exit();
        } else {
            echo "Error al registrar la compra.";
        }

    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    // Si no viene por POST, redirigir a Compras
    header("Location: ../Compras.php");
    exit();
}

