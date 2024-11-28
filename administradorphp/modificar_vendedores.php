<?php 
include_once 'models/conexion.php';
if (isset($_GET['id'])) {
    $id_vendedor = $_GET['id'];
    $sql = "SELECT 
                VE.ID_Vendedor, 
                U.Prime_Nombre AS Nombre_Vendedor, 
                U.Segundo_Nombre AS Segundo_Nombre_Vendedor, 
                U.Prime_Apellido AS Apellido_Vendedor, 
                U.Segundo_Apellido AS Segundo_Apellido_Vendedor,
                Z.NombreZona AS Zona
            FROM 
                VENDEDOR VE
            JOIN 
                USUARIO U ON VE.ID_Usuario = U.ID_Usuario
            JOIN 
                ZONA Z ON VE.ID_Zona = Z.ID_Zona
            WHERE VE.ID_Vendedor = '$id_vendedor'"; // Agregado WHERE para asegurar que buscamos el vendedor correcto
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $vendedor = $result->fetch_array(MYSQLI_ASSOC);
    } else {
        die("No se encontró el vendedor.");
    }
} else {
    die("El parámetro 'id' es necesario.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Vendedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Modificar Vendedor</h1>
        <form action="controllers/modificar_vendedor.php" method="post">
            <input type="hidden" name="id" value="<?php echo $vendedor['ID_Vendedor']; ?>" required>
            <div class="mb-3">
                <label for="nombre_completo" class="form-label">Nombre Completo del Vendedor</label>
                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" 
                value="<?php echo $vendedor['Nombre_Vendedor'] . ' ' . $vendedor['Segundo_Nombre_Vendedor'] . ' ' . $vendedor['Apellido_Vendedor'] . ' ' . $vendedor['Segundo_Apellido_Vendedor']; ?>" required>
                <small class="form-text text-muted">Ingrese el nombre completo (Primer Nombre, Segundo Nombre, Apellido, Segundo Apellido).</small>
            </div>
            <div class="mb-3">
                <label for="zona" class="form-label">Zona</label>
                <input type="text" class="form-control" id="zona" name="zona" value="<?php echo $vendedor['Zona']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="modificar" value="ok">Actualizar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>