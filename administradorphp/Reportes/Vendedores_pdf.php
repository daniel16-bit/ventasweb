<?php  
include "../models/conexion.php"; // Asegúrate de que la conexión use SQL Server

$where = "";
if (!empty($_POST['nom'])) {
    $valor = $_POST['nom'];
    $where = "WHERE U.Prime_Nombre LIKE '%$valor%' 
              OR U.Segundo_Nombre LIKE '%$valor%' 
              OR U.Prime_Apellido LIKE '%$valor%' 
              OR U.Segundo_Apellido LIKE '%$valor%'";
}

$sql = "SELECT 
    VE.ID_Vendedor, 
    U.Prime_Nombre AS Nombre_Vendedor, 
    U.Segundo_Nombre AS Segundo_Nombre_Vendedor, 
    U.Prime_Apellido AS Apellido_Vendedor, 
    U.Segundo_Apellido AS Segundo_Apellido_Vendedor,
    Z.NombreZona AS Zona
FROM colfar.VENDEDOR VE
JOIN colfar.USUARIO U ON VE.ID_Usuario = U.ID_Usuario
JOIN colfar.ZONA Z ON VE.ID_Zona = Z.ID_Zona
$where
ORDER BY VE.ID_Vendedor";

$resultado = sqlsrv_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vendedores</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/styles.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
<style>
.imagen-imprimir { text-align: center; margin-bottom: 20px; }
.botones-acciones { margin-bottom: 15px; }
</style>
</head>
<body>
<div class="container mt-4">

    <!-- Imagen -->
    <div class="imagen-imprimir">
        <img src="image.png" alt="Logo" class="img-fluid" style="max-height:100px;">
    </div>

    <!-- Botones -->
    <div class="botones-acciones">
        <a href="../Vendedores.php" class="btn btn-dark">Regresar</a>
        <a href="GenerarExcel_vendedores.php" class="btn btn-success">Generar Excel</a>
        <a href="#" class="btn btn-warning" onclick="window.print()">Imprimir / PDF</a>
    </div>

    <!-- Tabla -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla de Vendedores
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID_Vendedor</th>
                        <th>Nombre Completo</th>
                        <th>Zona</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($resultado) {
                        while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) { ?>
                            <tr>
                                <td><?php echo $row['ID_Vendedor']; ?></td>
                                <td><?php echo $row['Nombre_Vendedor'] . " " . $row['Segundo_Nombre_Vendedor'] . " " . $row['Apellido_Vendedor'] . " " . $row['Segundo_Apellido_Vendedor']; ?></td>
                                <td><?php echo $row['Zona']; ?></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="3" class="text-center">No se encontraron registros</td>
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
