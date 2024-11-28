<?php
include_once '../models/conexion.php';

if (isset($_POST['modificar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $sql = "UPDATE PROVEEDOR SET Nombe = '$nombre', Telefono = '$telefono', Dirección = '$direccion' WHERE ID_Proveedor = '$id'";

    if ($conexion->query($sql) === TRUE) {
        echo "Proveedor actualizado exitosamente";
        header("Location:../Proveedores.php"); // Redirect to the providers page
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>
