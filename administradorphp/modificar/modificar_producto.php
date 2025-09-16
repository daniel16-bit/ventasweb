<?php
include '../models/conexion.php';
session_start();

if (!isset($_GET['id'])) {
    die("ID de producto no especificado.");
}

$id = intval($_GET['id']);

// Consultar el producto
$sql = "SELECT 
            P.ID_Producto, 
            P.Nombre AS Nombre_Producto, 
            P.ValorProducto, 
            P.ValorVenta, 
            P.ID_Proveedor,
            PR.Nombe AS Nombre_Proveedor, 
            P.Stock, 
            P.Existencia
        FROM colfar.PRODUCTO P
        JOIN colfar.PROVEEDOR PR ON P.ID_Proveedor = PR.ID_Proveedor
        WHERE P.ID_Producto = ?";

$params = [$id];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false || !($producto = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))) {
    die("Producto no encontrado.");
}

// Consultar proveedores
$sqlProv = "SELECT ID_Proveedor, Nombe FROM colfar.PROVEEDOR";
$stmtProv = sqlsrv_query($conn, $sqlProv);
$proveedores = [];
while ($prov = sqlsrv_fetch_array($stmtProv, SQLSRV_FETCH_ASSOC)) {
    $proveedores[] = $prov;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg">
            <form action="../controllers/modificar_producto.php" method="POST">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Editar Producto</h5>
                    <a href="../views/Productos.php" class="btn-close btn-close-white"></a>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="ID_Producto" value="<?= $producto['ID_Producto'] ?>">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" name="Nombre" value="<?= htmlspecialchars($producto['Nombre_Producto']) ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Proveedor</label>
                            <select name="ID_Proveedor" class="form-select" required>
                                <?php foreach ($proveedores as $prov): ?>
                                    <option value="<?= $prov['ID_Proveedor'] ?>" 
                                        <?= $producto['ID_Proveedor'] == $prov['ID_Proveedor'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($prov['Nombe']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Valor Producto</label>
                            <input type="number" name="ValorProducto" value="<?= $producto['ValorProducto'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Valor Venta</label>
                            <input type="number" name="ValorVenta" value="<?= $producto['ValorVenta'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Stock</label>
                            <input type="number" name="Stock" value="<?= $producto['Stock'] ?>" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Existencia</label>
                            <input type="number" name="Existencia" value="<?= $producto['Existencia'] ?>" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="../views/Productos.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
