<?php
include_once '../models/conexion.php';
$id_zona = $_GET['id'];
$sql = "SELECT 
            Z.ID_Zona, 
            Z.NombreZona, 
            D.Nombre AS NombreDepartamento,
            Z.ID_Departamento
        FROM 
            ZONA Z
        JOIN 
            DEPARTAMENTO D ON Z.ID_Departamento = D.ID_Departamento
        WHERE
            Z.ID_Zona = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_zona);
$stmt->execute();
$result = $stmt->get_result();
$zona = $result->fetch_array(MYSQLI_ASSOC);

// Obtener todos los departamentos disponibles para el select
$sql_departamentos = "SELECT ID_Departamento, Nombre FROM DEPARTAMENTO";
$result_departamentos = $conexion->query($sql_departamentos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Zona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>    
    <div class="container">
        <h1 class="mt-4">Modificar Zona</h1>
        <form action="../controllers/modificar_zonas.php" method="post">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre Zona</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $zona['NombreZona']; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="departamento" class="form-label">Nombre Departamento</label>
                <select class="form-control" id="departamento" name="departamento" required>
                    <?php while ($departamento = $result_departamentos->fetch_assoc()) { ?>
                        <option value="<?php echo $departamento['ID_Departamento']; ?>" <?php echo $departamento['ID_Departamento'] == $zona['ID_Departamento'] ? 'selected' : ''; ?>>
                            <?php echo $departamento['Nombre']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary" name="modificar" value="ok">Actualizar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
