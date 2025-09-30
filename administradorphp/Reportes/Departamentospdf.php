<?php
include "../models/conexion.php"; // Conexión a SQL Server

$where = "";
$params = array();

if (!empty($_POST['nom'])) {
    $where = "WHERE Nombre LIKE ?";
    $params[] = "%".$_POST['nom']."%";
}

// Consulta SQL Server
$sql = "SELECT * FROM DEPARTAMENTO $where";

$stmt = sqlsrv_query($conexion, $sql, $params);
if(!$stmt){
    die(print_r(sqlsrv_errors(), true));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/styles.css" media="screen">
<link rel="stylesheet" href="../css/styles.css" media="print">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<title>Listado de Departamentos</title>
</head>
<body>
<div class="imagen-imprimir">
    <img src="image.png"
