<?php
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=Compras.xls");

include "../models/conexion.php"; // Conexión a SQL Server

$where = "";
$params = array();

if (!empty($_POST['nom'])) {
    $where = "WHERE p.Nombre LIKE ?";
    $params[] = "%" . $_POST['nom'] . "%";
}

// Consulta SQL Server
$sql = "SELECT 
    c.ID_Compra,
    c.Fecha,
    c.Cantidad,
    p.Nombre AS Nombre_Producto,
    u.Prime_Nombre AS Nombre_Vendedor,
    u.Prime_Apellido AS Apellido_Vendedor,
    v.Fecha AS Fecha_Venta,
    v.Descuentos,
    v.Total
FROM COMPRA c
JOIN PRODUCTO p ON c.ID_Producto = p.ID_Producto
JOIN VENTA v ON c.ID_Compra = v.ID_Venta
JOIN VENDEDOR vd ON v.ID_Vendedor = vd.ID_Vendedor
JOIN USUARIO u ON vd.ID_Usuario = u.ID_Usuario
$where";

$stmt = sqlsrv_query($conexion, $sql, $params);
if(!$stmt){
    die(print_r(sqlsrv_errors(), true));
}
?>

<html>
<head>
<meta charset="UTF-8">
<title>Exportar Compras</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>ID_Compra</th>
                <th>Fecha</th>
                <th>Cantidad</th>
                <th>Nombre Producto</th>
                <th>Nombre Vendedor</th>
            </tr>
        </thead>
