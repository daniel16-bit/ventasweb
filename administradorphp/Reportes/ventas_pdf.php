<?php  
include "../models/conexion.php"; // Conexión SQL Server

$where = "";
if (!empty($_POST['nom'])) {
    $valor = $_POST['nom'];
    $where = "WHERE C.Nombre LIKE '%$valor%' OR P.Nombre LIKE '%$valor%' OR D.Nombre LIKE '%$valor%'";
}

$sql = "SELECT 
    V.ID_Venta,
    V.Fecha,
    V.Descuentos,
    V.Total,
    C.Nombre AS Nombre_Cliente,
    U.Prime_Nombre AS Nombre_Vendedor,
    U.Prime_Apellido AS Apellido_Vendedor,
    Z.NombreZona AS Nombre_Zona,
    D.Nombre AS Nombre_Departamento,
    P.Nombre AS Nombre_Producto
FROM colfar.VENTA V
INNER JOIN colfar.CLIENTE C ON V.ID_Cliente = C.ID_Cliente
INNER JOIN colfar.VENDEDOR VE ON V.ID_Vendedor = VE.ID_Vendedor
INNER JOIN colfar.USUARIO U ON VE.ID_Usuario = U.ID_Usuario
INNER JOIN colfar.ZONA Z ON V.ID_Zona = Z.ID_Zona
INNER JOIN colfar.DEPARTAMENTO D ON V.ID_Departamento = D.ID_Departamento
INNER JOIN colfar.PRODUCTO P ON V.ID_Producto = P.ID_Producto
$where
ORDER BY V.ID_Venta";

$resultado = sqlsrv_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ventas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/styles.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
<style>
.botones-acciones { margin-bottom: 15px; }
</style>
</head>
<body>
<div class="container mt-4">

    <!-- Botones -->
    <div class="botones-acciones">
        <a href="../Ventas.php" class="btn btn-dark">Regresar</a>
        <a href="GenerarExcel_ventas.php" class="btn btn-success">Generar Excel</a>
        <a href="#" class="btn btn-warning" onclick="window.print()">Imprimir / PDF</a>
    </div>

    <!-- Tabla -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Ventas
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Descuentos</th>
                        <th>Total</th>
                        <th>Vendedor</th>
                        <th>Zona</th>
                        <th>Departamento</th>
                        <th>Producto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($resultado) {
                        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) { ?>
                            <tr>
                                <td><?php echo $row['ID_Venta']; ?></td>
                                <td><?php echo $row['Fecha']->format('Y-m-d'); ?></td>
                                <td><?php echo $row['Descuentos']; ?></td>
                                <td><?php echo $row['Total']; ?></td>
                                <td><?php echo $row['Nombre_Vendedor'] . ' ' . $row['Apellido_Vendedor']; ?></td>
                                <td><?php echo $row['Nombre_Zona']; ?></td>
                                <td><?php echo $row['Nombre_Departamento']; ?></td>
                                <td><?php echo $row['Nombre_Producto']; ?></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">No se encontraron registros</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid text-center">
        <small>&copy; <?php echo date("Y"); ?> Mi Sistema</small>
    </div>
</footer>
</body>
</html>