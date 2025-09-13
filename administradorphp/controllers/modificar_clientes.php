<?php
include_once '../models/conexion.php';

if (!empty($_POST['modificar'])) {
    // Verificar que todos los campos requeridos estén presentes
    if (!empty($_POST['tipo']) && !empty($_POST['nombre']) && !empty($_POST['telefono']) && !empty($_POST['direccion'])) {
        
        // Recoger los datos del formulario
        $idcliente = $_POST['id'];
        $tipo = $_POST['tipo'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];

        try {
            // Preparar la consulta SQL con parámetros
            $sql = "UPDATE CLIENTE 
                    SET Tipo = ?, Nombre = ?, Telefono = ?, Direccion = ? 
                    WHERE ID_Cliente = ?";
            $stmt = $conexion->prepare($sql);

            // Ejecutar con los valores del formulario
            $stmt->execute([$tipo, $nombre, $telefono, $direccion, $idcliente]);

            // Redirigir después de actualizar
            header("Location: ../Clientes.php");
            exit();

        } catch (PDOException $e) {
            echo "Error al actualizar el cliente: " . $e->getMessage();
        }
    } else {
        echo "⚠️ Todos los campos son obligatorios.";
    }
}
?>

