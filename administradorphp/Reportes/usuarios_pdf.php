<?php  
include "../models/conexion.php";   

$where = "";
if (!empty($_POST['nom'])) {
    $valor = $_POST['nom'];
    $where = "WHERE Prime_Nombre LIKE '%$valor%' 
              OR Segundo_Nombre LIKE '%$valor%'
              OR Prime_Apellido LIKE '%$valor%'
              OR Segundo_Apellido LIKE '%$valor%'";
}

$sql = "SELECT * FROM colfar.USUARIO $where";
$resultado = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .imagen-imprimir {
            text-align: center;
            margin-bottom: 20px;
        }
        .botones-acciones {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Imagen de impresión -->
        <div class="imagen-imprimir">
            <img src="image.png" alt="Logo" class="img-fluid" style="max-height:100px;">
        </div>

        <!-- Botones de acción -->
        <div class="botones-acciones">
            <a href="../Usuarios.php" class="btn btn-dark">Regresar</a>
            <a href="GenerarExcel_usuarios.php" class="btn btn-success">Generar Excel</a>
            <a href="#" class="btn btn-warning" onclick="window.print()">Imprimir / PDF</a>
        </div>

        <!-- Tabla de usuarios -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla de Usuarios
            </div>  
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID_Usuario</th>
                            <th>Primer Nombre</th>
                            <th>Segundo Nombre</th>
                            <th>Primer Apellido</th>
                            <th>Segundo Apellido</th>
                            <th>Teléfono</th>
                            <th>Contraseña</th>
                            <th>Correo</th>                   
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultado->num_rows > 0): ?>
                            <?php while ($row = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['ID_Usuario']; ?></td>
                                    <td><?php echo $row['Prime_Nombre']; ?></td>
                                    <td><?php echo $row['Segundo_Nombre']; ?></td>
                                    <td><?php echo $row['Prime_Apellido']; ?></td>
                                    <td><?php echo $row['Segundo_Apellido']; ?></td>
                                    <td><?php echo $row['Telefono']; ?></td>
                                    <td><?php echo $row['Contraseña']; ?></td>
                                    <td><?php echo $row['Correo']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No se encontraron usuarios</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>  
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4 text-center">
            <small>&copy; <?php echo date("Y"); ?> Mi Sistema</small>
        </div>
    </footer>
</body>
</html>
