<?php
include_once '../models/conexion.php';
// Verificar si el formulario fue enviado
if (!empty($_POST['modificar'])) {
    // Verificar si los campos no están vacíos
    if (!empty($_POST['tipo']) && !empty($_POST['nombre']) && !empty($_POST['telefono']) && !empty($_POST['direccion'])) {
        // Recoger los datos del formulario y escapar los valores
        $idcliente = $_POST['id'];
        $tipo = mysqli_real_escape_string($conexion, $_POST['tipo']);
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
        $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
        // Comprobar que la conexión esté activa
        if ($conexion) {
            // Preparar la consulta SQL para actualizar los datos
            $sql = "UPDATE CLIENTE SET Tipo = '$tipo', Nombre = '$nombre', Telefono = '$telefono', Direccion = '$direccion' WHERE ID_Cliente = '$idcliente'";
            // Ejecutar la consulta
            if (mysqli_query($conexion, $sql)) {
                echo "Cliente actualizado exitosamente.";
                // Corregir la redirección
                header("Location: ../Clientes.php"); // Asegúrate de poner el espacio después de "Location:"
                exit(); // Asegúrate de terminar el script después de redirigir
            } else {
                echo "Error al actualizar el cliente: " . mysqli_error($conexion); // Mostrar error si no se puede actualizar
            }
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>
