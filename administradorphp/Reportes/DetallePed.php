<?php
include "../models/conexion.php"; // Conexión a SQL Server

$where = "";
$params = array();

if (!empty($_POST['nom'])) {
    $where = "WHERE ID_Pedido LIKE ?";
    $params[] = "%".$_POST['nom']."%";
}

// Consulta SQL Server
$sql = "SELECT * FROM PEDIDO $where";

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
<title>Listado de Pedidos</title>
</head>
<body>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Tabla Pedidos
    </div>
    <div class="card-body">
        <div class="container mb-3">
            <a href="../../vendedor/Pedidos.php" class="btn btn-dark">Regresar</a>
            <a href="GenerarExcel_pedidos.php" class="btn btn-success">Generar Excel</a>
            <button class="btn btn-warning" onclick="window.print()">Imprimir/Descargar PDF</button>
        </div>

        <table id="datatablesSimple" class="table table-striped">
            <thead>
                <tr>
                    <th>Numero de pedido</th>
                    <th>Cliente</th>
                    <th>Fecha del pedido</th>
                    <th>Producto</th>
                    <th>Valor total del pedido</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row['ID_Pedido'] ?></td>
                    <td><?= $row['ID_Cliente'] ?></td>
                    <td><?= $row['Fecha']->format('Y-m-d') ?></td>
                    <td><?= $row['ID_Producto'] ?></td>
                    <td><?= $row['Valor_Total'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4"></div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
</body>
</html>
