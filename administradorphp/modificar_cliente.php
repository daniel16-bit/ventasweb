<?php
include_once 'models/conexion.php';
$id_cliente = $_GET['id'];
$sql = "SELECT * FROM CLIENTE WHERE ID_Cliente = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
$clientes = $result->fetch_array(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Ciudad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Modificar Cliente</h1>
        <form action="controllers/modificar_clientes.php" method="post">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>   
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $clientes['Tipo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $clientes['Nombre']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="tel" class="form-label">Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $clientes['Telefono']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $clientes['Direccion']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="modificar" value="ok">Actualizar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
