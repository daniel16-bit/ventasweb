<?php
include_once '../models/conexion.php';

$id_cliente = $_GET['id'] ?? null;
$cliente = null;

if ($id_cliente) {
    // Consulta con parámetros
    $sql = "SELECT * FROM colfar.CLIENTE WHERE ID_Cliente = ?";
    $params = array($id_cliente);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $cliente = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Modificar Cliente</h1>
        <?php if ($cliente): ?>
        <form action="../controllers/modificar_clientes.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_cliente); ?>" required>   
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" 
                       value="<?php echo htmlspecialchars($cliente['Tipo']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" 
                       value="<?php echo htmlspecialchars($cliente['Nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" 
                       value="<?php echo htmlspecialchars($cliente['Telefono']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" 
                       value="<?php echo htmlspecialchars($cliente['Direccion']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="modificar" value="ok">Actualizar</button>
        </form>
        <?php else: ?>
            <div class="alert alert-danger">⚠️ Cliente no encontrado.</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

