<?php
include "../models/conexion.php";

$where = "";
$valor = "";
$params = [];

if (!empty($_POST['nom'])) {
    $valor = $_POST['nom'];
    $where = "WHERE Z.NombreZona LIKE ? OR D.Nombre LIKE ?";
    $params = ["%$valor%", "%$valor%"];
}

$sql = "SELECT 
    Z.ID_Zona, 
    Z.NombreZona, 
    D.Nombre AS NombreDepartamento
FROM colfar.ZONA Z
JOIN colfar.DEPARTAMENTO D ON Z.ID_Departamento = D.ID_Departamento
$where
ORDER BY Z.ID_Zona";

// Ejecutar consulta con opción Scrollable para poder contar filas si es necesario
$options = ["Scrollable" => SQLSRV_CURSOR_KEYSET];
$resultado = !empty($params) 
    ? sqlsrv_query($conn, $sql, $params, $options) 
    : sqlsrv_query($conn, $sql, [], $options);

if ($resultado === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zonas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/styles.css" media="print">
</head>
<body>
    <div class="imagen-imprimir">
        <img src="image.png" alt="" class="img-fluid" id="imagen-imprimir">
    </div>

    <div class="card mb-4">
        <div class="card-body">             
            <div class="container mb-3">
                <a href="../Zonas.php" class="btn btn-dark r">Regresar</a>        
                <a href="GenerarExcel_zona.php" class="btn btn-success">Generar Excel</a>       
                <a href="#" class="btn btn-warning botimpr" onclick="window.print()">Imprimir/PDF</a>                
            </div>

            <div class="card-header mb-3">
                <i class="fas fa-table me-1"></i> Tabla Zonas 
            </div>    

            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Id zona</th>
                        <th>Nombre zona</th>
                        <th>Nombre Departamento</th>     
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mostrar filas
                    while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ID_Zona']); ?></td>
                            <td><?php echo htmlspecialchars($row['NombreZona']); ?></td>
                            <td><?php echo htmlspecialchars($row['NombreDepartamento']); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>         
        </div>
    </div>

    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <!-- Puedes agregar contenido aquí -->
            </div>
        </div>
    </footer>
</body>
</html>
