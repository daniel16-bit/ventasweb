<?php
include "../models/conexion.php"; // Archivo de conexión a SQL Server

$where = "";
$params = array();

if (!empty($_POST['nom'])) {
    $where = "WHERE Nombre LIKE ?";
    $params[] = "%".$_POST['nom']."%";
}

// Consulta SQL Server
$sql = "SELECT ID_Cliente, Tipo, Nombre, Telefono, Direccion FROM CLIENTE $where";
$stmt = sqlsrv_query($conexion, $sql, $params);

if(!$stmt){
    die(print_r(sqlsrv_errors(), true));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/styles.css" media="screen">
<link rel="stylesheet" href="../css/styles.css" media="print">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<title>Listado de Clientes</title>
</head>
<body>
<div class="imagen-imprimir">
    <img src="image.png" alt="" class="img-fluid" id="imagen-imprimir">
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="container mb-3">
            <a href="../Clientes.php" class="btn btn-dark">Regresar</a>
            <a href="GenerarExcel_clientes.php" class="btn btn-success">Generar Excel</a>
            <button class="btn btn-warning" onclick="window.print()">Imprimir/Descargar PDF</button>
        </div>

        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Clientes
        </div>  

        <table id="datatablesSimple" class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= $row['ID_Cliente'] ?></td>
                    <td><?= $row['Tipo'] ?></td>
                    <td><?= $row['Nombre'] ?></td>
                    <td><?= $row['Telefono'] ?></td>
                    <td><?= $row['Direccion'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
        </div>
    </div>
</footer>
</body>
</html>
