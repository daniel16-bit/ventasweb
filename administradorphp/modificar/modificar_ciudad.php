<?php
include_once '../models/conexion.php';
$id_ciudad = $_GET['id'];
$sql= "SELECT * FROM ciudad WHERE ID_Ciudad = '$id_ciudad'";
$result= $conexion->query($sql);
$city = $result->fetch_array(MYSQLI_ASSOC);
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
        <h1 class="mt-4">Modificar Ciudad</h1>
        <form action="../controllers/modificar_ciudades.php" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre Ciudad</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $city['Nombre_ciudad']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="pais" class="form-label">País</label>
                <input type="text" class="form-control" id="pais" name="pais" value="<?php echo $city['Pais']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="codigo_postal" class="form-label">Código Postal</label>
                <input type="number" class="form-control" id="codigo_postal" name="codigo_postal" value="<?php echo $city['Codigo_postal']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="modificar" value="ok" >Actualizar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>