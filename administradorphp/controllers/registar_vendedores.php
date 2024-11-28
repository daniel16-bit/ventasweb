<?php
include '../models/conexion.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $id_zona = $_POST['id_zona'];
    $id_usuario = $_POST['id_usuario'];

    // Validar que los campos no estén vacíos
    if (!empty($id_zona) && !empty($id_usuario)) {
        // Insertar el nuevo vendedor en la base de datos
        $sql = "INSERT INTO VENDEDOR (ID_Zona, ID_Usuario) VALUES ('$id_zona', '$id_usuario')";

        if ($conexion->query($sql) === TRUE) {
            // Redirigir a la página de vendedores después de registrar
            header("Location: ../Vendedores.php");
        } else {
            echo "Error al registrar el vendedor: " . $conexion->error;
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
?>
