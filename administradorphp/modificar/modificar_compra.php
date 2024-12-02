<?php
include_once '../models/conexion.php';

$id_compra = $_GET['id'];
$sql = "SELECT * FROM COMPRA WHERE ID_Compra = '$id_compra'";
$result = $conexion->query($sql);
if ($result->num_rows > 0) {
    $compra = $result->fetch_array(MYSQLI_ASSOC);
} else {
    die("No se encontró la compra.");
}
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
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $compra['Fecha']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" value="<?php echo $compra['Cantidad']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_producto" class="form-label">ID Producto</label>
                <input type="number" class="form-control" id="id_producto" name="id_producto" value="<?php echo $compra['ID_Producto']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_proveedor" class="form-label">ID Proveedor</label>
                <input type="number" class="form-control" id="id_proveedor" name="id_proveedor" value="<?php echo $compra['ID_Proveedor']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="modificar" value="ok">Actualizar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
