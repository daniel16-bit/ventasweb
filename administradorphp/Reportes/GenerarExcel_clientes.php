<?php
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=Clientes.xls");

include "../models/conexion.php"; // Conexión a SQL Server

$where = "";
$params = array();

if (!empty($_POST['nom'])) {
    $where = "WHERE Nombre LIKE ?";
    $params[] = "%" . $_POST['nom'] . "%";
}

// Consulta SQL Server
$sql = "SELECT * FROM CLIENTE $where";
$stmt = sqlsrv_query($conexion, $sql, $params);

if(!$stmt){
    die(print_r(sqlsrv_errors(), true));
}
?>

<html>
<head>
<meta charset="UTF-8">
<title>Exportar Clientes</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <t
