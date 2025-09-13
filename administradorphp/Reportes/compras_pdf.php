<?php
include "../models/conexion_sqlsrv.php"; // Archivo de conexión a SQL Server

$where = "";
$params = array();

if (!empty($_POST['nom'])) {
    $where = "WHERE p.Nombre LIKE ?";
    $params[] = "%".$_POST['nom']."%";
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
<title>Listado de Compras</title>
</head>
<body>
<div class="imagen-imprimir">
    <img src="image.png" alt="" class="img-fluid" id="imagen-imprimir">
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="container mb-3">
            <a href="../Compras.php" class="btn btn-dark">Regresar</a>
            <a href="GenerarExcel_compra.php" class="btn btn-success">Generar Excel</a>
            <button class="btn btn-warning" onclick="window.print()">Imprimir/Descargar PDF</button>
        </div>

        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Compras
        </div>  

        <table id="datatablesSimple" class="table table-striped">
            <thead>
                <tr>
                    <th>ID_Compra</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Nombre Producto</th>
                    <th>Nombre Vendedor</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row['ID_Compra'] ?></td>
                    <td><?= $row['Fecha']->format('Y-m-d') ?></td>
                    <td><?= $row['Cantidad'] ?></td>
                    <td><?= $row['Nombre_Producto'] ?></td>
                    <td><?= $row['Nombre_Vendedor'] . ' ' . $row['Apellido_Vendedor'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small"></div>
    </div>
</footer>
</body>
</html>
