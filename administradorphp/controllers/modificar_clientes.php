<?php
include_once '../models/conexion.php';

if (!empty($_POST['modificar'])) {
    // Validar campos
    if (!empty($_POST['tipo']) && !empty($_POST['nombre']) && !empty($_POST['telefono']) && !empty($_POST['direccion'])) {

        // Datos del formulario
        $idcliente  = $_POST['id'];
        $tipo       = $_POST['tipo'];
        $nombre     = $_POST['nombre'];
        $telefono   = $_POST['telefono'];
        $direccion  = $_POST['direccion'];

        // Consulta con parámetros
        $sql = "UPDATE colfar.CLIENTE 
                SET Tipo = ?, Nombre = ?, Telefono = ?, Direccion = ? 
                WHERE ID_Cliente = ?";
        $params = array($tipo, $nombre, $telefono, $direccion, $idcliente);

        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            echo "❌ Error al actualizar el cliente:<br>";
            die(print_r(sqlsrv_errors(), true));
        } else {
            // ✅ Redirigir después de actualizar
            header("Location: ../Clientes.php");
            exit();
        }

    } else {
        echo "⚠️ Todos los campos son obligatorios.";
    }
}
?>


