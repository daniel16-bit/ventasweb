<?php
include '../models/conexion.php';

if(isset($_POST['modificar'])){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];

    // Quitar acentos del nombre de columna
    $sql = "UPDATE colfar.PROVEEDOR SET Nombe = ?, Telefono = ?, Dirección = ? WHERE ID_Proveedor = ?";
    $params = [$nombre, $telefono, $id];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if($stmt === false){
        die(print_r(sqlsrv_errors(), true));
    } else {
        header("Location: ../Proveedores.php");
        exit();
    }
}
?>


