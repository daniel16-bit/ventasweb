<?php 
include 'models/conexion.php'; // conexión con Azure SQL
session_start();

// Verificar sesión
if (!isset($_SESSION['Prime_Nombre'])) {
    header("Location: formulario.php?error=Debe iniciar sesión");
    exit();
}

// Consulta productos con su proveedor
$sql = "SELECT 
            P.ID_Producto, 
            P.Nombre AS Nombre_Producto, 
            P.ValorProducto, 
            P.ValorVenta, 
            PR.Nombre AS Nombre_Proveedor, 
            P.Stock, 
            P.Existencia
        FROM PRODUCTO P
        JOIN PROVEEDOR PR ON P.ID_Proveedor = PR.ID_Proveedor";

$stmt = sqlsrv_query($conn, $sql);

$productos = [];
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $productos[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="mb-4">📦 Lista de Productos</h2>

        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Valor Producto</th>
                    <th>Valor Venta</th>
                    <th>Proveedor</th>
                    <th>Stock</th>
                    <th>Existencia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($productos)): ?>
                    <?php foreach ($productos as $prod): ?>
                        <tr>
                            <td><?= $prod['ID_Producto'] ?></td>
                            <td><?= $prod['Nombre_Producto'] ?></td>
                            <td><?= $prod['ValorProducto'] ?></td>
                            <td><?= $prod['ValorVenta'] ?></td>
                            <td><?= $prod['Nombre_Proveedor'] ?></td>
                            <td><?= $prod['Stock'] ?></td>
                            <td><?= $prod['Existencia'] ?></td>
                            <td>
                                <a href="controllers/eliminar_producto.php?id=<?= $prod['ID_Producto'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="text-center">No hay productos registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
