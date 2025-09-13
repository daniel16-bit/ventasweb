<?php
include_once '../models/conexion.php';

if (isset($_POST['modificar'])) {
    $id        = $_POST['id'] ?? null;
    $nombre    = $_POST['nombre'] ?? null;
    $telefono  = $_POST['telefono'] ?? null;
    $direccion = $_POST['direccion'] ?? null;

    if ($id && $nombre && $telefono && $direccion) {
        try {
            // Consulta preparada con parámetros
            $sql = "UPDATE PROVEEDOR 
                    SET Nombe = ?, Telefono = ?, Dirección = ? 
                    WHERE ID_Proveedor = ?";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([$nombre, $telefono, $direccion, $id]);

            // Redirigir después de actualizar
            header("Location: ../Proveedores.php");
            exit();
        } catch (PDOException $e) {
            echo "Error al actualizar el proveedor: " . $e->getMessage();
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>

