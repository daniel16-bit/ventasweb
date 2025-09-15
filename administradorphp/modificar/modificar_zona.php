<?php
// Incluir el archivo de conexión
include_once '../models/conexion.php';

// Verificar si 'id' está presente en la URL
if (!isset($_GET['id'])) {
    die('Error: El ID no está presente en la URL');
}

$id_zona = $_GET['id'];

// Consulta SQL para obtener los datos de la zona
$sql = "SELECT 
            Z.ID_Zona, 
            Z.NombreZona, 
            D.Nombre AS NombreDepartamento,
            Z.ID_Departamento
        FROM 
            colfar.ZONA Z
        JOIN 
            colfar.DEPARTAMENTO D ON Z.ID_Departamento = D.ID_Departamento
        WHERE
            Z.ID_Zona = ?";

// Preparar la consulta usando sqlsrv_query (no es necesario bindParam o execute)
$params = array($id_zona);
$stmt = sqlsrv_query($conn, $sql, $params);

// Verificar si hubo un error en la consulta
if (!$stmt) {
    die('Error en la consulta: ' . print_r(sqlsrv_errors(), true));
}

// Si no se encontró la zona
if (sqlsrv_has_rows($stmt) === false) {
    die('Zona no encontrada');
}

// Obtener la zona
$zona = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Obtener todos los departamentos disponibles para el select
$sql_departamentos = "SELECT ID_Departamento, Nombre FROM colfar.DEPARTAMENTO";
$result_departamentos = sqlsrv_query($conn, $sql_departamentos);
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
        <form action="modificar_zonas.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_zona); ?>" required>
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre Zona</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($zona['NombreZona']); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="departamento" class="form-label">Nombre Departamento</label>
                <select class="form-control" id="departamento" name="departamento" required>
                    <?php while ($departamento = sqlsrv_fetch_array($result_departamentos, SQLSRV_FETCH_ASSOC)) { ?>
                        <option value="<?php echo $departamento['ID_Departamento']; ?>" <?php echo $departamento['ID_Departamento'] == $zona['ID_Departamento'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($departamento['Nombre']); ?>
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



