<?php
include '../models/conexion.php';
$sqlFacturas = "SELECT f.ID_Factura, f.Fecha_Factura, c.Nombre AS Cliente, p.Valor_Total
    FROM colfar.factura f
    JOIN colfar.pedido p ON f.ID_Venta = p.ID_Pedido
    JOIN colfar.cliente c ON p.ID_Cliente = c.ID_Cliente
    ORDER BY f.Fecha_Factura DESC";

$result = sqlsrv_query($conn, $sqlFacturas);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>ID Factura</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Valor Total</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) { ?>
            <tr>
                <td><?= $row['ID_Factura'] ?></td>
                <td><?= $row['Fecha_Factura']->format('Y-m-d H:i') ?></td>
                <td><?= $row['Cliente'] ?></td>
                <td><?= $row['Valor_Total'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>