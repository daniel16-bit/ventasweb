<?php
include_once '../models/conexion.php'; // Aquí $conn con sqlsrv_connect()

// Verificar que se reciba el ID
if (!isset($_GET['id'])) {
    die("ID de proveedor no proporcionado.");
}

$id_proveedor = $_GET['id'];

// Consulta parametrizada para traer el proveedor
$sql = "SELECT * FROM colfar.PROVEEDOR WHERE ID_Proveedor = ?";
$params = [$id_proveedor];

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$proveedor = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if (!$proveedor) {
    die("No se encontró el proveedor.");
}

sqlsrv_free_stmt($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Modificar Proveedor</h1>
        <form action="../controllers/modificar_provedores.php" method="post">
            <!-- Campo oculto para pasar el ID -->
            <input type="hidden" name="id" value="<?php echo $id_proveedor; ?>" required>
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" 
                       value="<?php echo $proveedor['Nombe']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" 
                       value="<?php echo $proveedor['Telefono']; ?>" required>
            </div>
            
            
            <button type="submit" class="btn btn-primary" name="modificar" value="ok">Actualizar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>