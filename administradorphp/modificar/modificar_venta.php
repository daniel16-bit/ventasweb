<?php
// Incluir conexión
include_once '../models/conexion.php';

// Verificar si 'id' está en la URL
if (!isset($_GET['id'])) {
    die('Error: El ID no está presente en la URL');
}

$id_venta = $_GET['id'];

// Consulta para obtener datos de la venta
$sql = "SELECT 
            V.ID_Venta,
            V.Fecha,
            V.Descuentos,
            V.Total,
            V.ID_Cliente,
            C.Nombre AS Nombre_Cliente,
            V.ID_Producto,
            P.Nombre AS Nombre_Producto
        FROM colfar.VENTA V
        INNER JOIN colfar.CLIENTE C ON V.ID_Cliente = C.ID_Cliente
        INNER JOIN colfar.PRODUCTO P ON V.ID_Producto = P.ID_Producto
        WHERE V.ID_Venta = ?";

$params = array($id_venta);
$stmt = sqlsrv_query($conn, $sql, $params);

if (!$stmt) {
    die('Error en la consulta: ' . print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt) === false) {
    die('Venta no encontrada');
}

$venta = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Obtener clientes
$sql_clientes = "SELECT ID_Cliente, Nombre FROM colfar.CLIENTE";
$result_clientes = sqlsrv_query($conn, $sql_clientes);

// Obtener productos
$sql_productos = "SELECT ID_Producto, Nombre FROM colfar.PRODUCTO";
$result_productos = sqlsrv_query($conn, $sql_productos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Modificar Venta</h1>
    <form action="../controllers/modificar_ventas.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_venta); ?>">

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="datetime-local" class="form-control" id="fecha" name="fecha" 
                   value="<?php echo $venta['Fecha']->format('Y-m-d\TH:i'); ?>" required>
        </div>

        <div class="mb-3">
            <label for="descuentos" class="form-label">Descuentos</label>
            <input type="number" step="0.01" class="form-control" id="descuentos" name="descuentos" 
                   value="<?php echo htmlspecialchars($venta['Descuentos']); ?>">
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" step="0.01" class="form-control" id="total" name="total" 
                   value="<?php echo htmlspecialchars($venta['Total']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente</label>
            <select class="form-control" id="cliente" name="cliente" required>
                <?php while ($cliente = sqlsrv_fetch_array($result_clientes, SQLSRV_FETCH_ASSOC)) { ?>
                    <option value="<?php echo $cliente['ID_Cliente']; ?>" 
                        <?php echo $cliente['ID_Cliente'] == $venta['ID_Cliente'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cliente['Nombre']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="producto" class="form-label">Producto</label>
            <select class="form-control" id="producto" name="producto" required>
                <?php while ($producto = sqlsrv_fetch_array($result_productos, SQLSRV_FETCH_ASSOC)) { ?>
                    <option value="<?php echo $producto['ID_Producto']; ?>" 
                        <?php echo $producto['ID_Producto'] == $venta['ID_Producto'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($producto['Nombre']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="../views/Ventas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
