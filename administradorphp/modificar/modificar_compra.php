<?php 
include_once '../models/conexion.php'; // conexión con Azure SQL

$id_compra = $_GET['id'] ?? null;

if (!$id_compra) {
    die("⚠️ ID de compra no especificado.");
}

// Consulta de la compra a editar
$sql = "SELECT * FROM colfar.COMPRA WHERE ID_Compra = ?";
$params = [$id_compra];
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$compra = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if (!$compra) {
    die("No se encontró la compra.");
}

// Traer productos
$sqlProductos = "SELECT ID_Producto, Nombre FROM colfar.PRODUCTO";
$stmtProductos = sqlsrv_query($conn, $sqlProductos);

// Traer proveedores (corregido: ahora usa Nombre)
$sqlProveedores = "SELECT ID_Proveedor, Nombre FROM colfar.PROVEEDOR";
$stmtProveedores = sqlsrv_query($conn, $sqlProveedores);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Compra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Modificar Compra</h1>
        <form action="../controllers/modificar_compras.php" method="post">
            <!-- Campo oculto para pasar el ID -->
            <input type="hidden" name="id" value="<?php echo $id_compra; ?>" required>
            
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" 
                       value="<?php echo $compra['Fecha']->format('Y-m-d'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" 
                       value="<?php echo $compra['Cantidad']; ?>" required>
            </div>

            <!-- Select Producto -->
            <div class="mb-3">
                <label for="id_producto" class="form-label">Producto</label>
                <select class="form-select" id="id_producto" name="id_producto" required>
                    <?php while ($row = sqlsrv_fetch_array($stmtProductos, SQLSRV_FETCH_ASSOC)): ?>
                        <option value="<?php echo $row['ID_Producto']; ?>" 
                            <?php echo ($row['ID_Producto'] == $compra['ID_Producto']) ? 'selected' : ''; ?>>
                            <?php echo $row['Nombre']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Select Proveedor -->
<!-- Select Proveedor -->
<div class="mb-3">
    <label for="id_proveedor" class="form-label">Proveedor</label>
    <select class="form-control" name="id_proveedor" required>
        <option value="">Seleccione un proveedor</option>
        <?php
        $sqlProveedores = "SELECT ID_Proveedor, Nombe FROM colfar.PROVEEDOR"; 
        $stmtProveedores = sqlsrv_query($conn, $sqlProveedores);

        if ($stmtProveedores === false) {
            die(print_r(sqlsrv_errors(), true)); // Muestra error si la consulta falla
        }

        while ($rowProv = sqlsrv_fetch_array($stmtProveedores, SQLSRV_FETCH_ASSOC)) {
            $selected = ($rowProv['ID_Proveedor'] == $compra['ID_Proveedor']) ? "selected" : "";
            echo "<option value='" . $rowProv['ID_Proveedor'] . "' $selected>" . htmlspecialchars($rowProv['Nombe']) . "</option>";
        }
        ?>
    </select>
</div>


            <button type="submit" class="btn btn-primary" name="modificar" value="ok">Actualizar</button>
            <a href="../views/Compras.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


