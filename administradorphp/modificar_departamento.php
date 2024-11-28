<?php
include_once 'models/conexion.php';

$id_departamento = $_GET['id'];
$sql= "SELECT * FROM DEPARTAMENTO WHERE ID_Departamento = '$id_departamento'";

$result= $conexion->query($sql);
$departamento = $result->fetch_array(MYSQLI_ASSOC);
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
        <h1 class="mt-4">Modificar Departamento</h1>
        <form action="controllers/modificar_departamentos.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Departamento</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $departamento['Nombre']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" value="ok" name="modificar">Actualizar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>