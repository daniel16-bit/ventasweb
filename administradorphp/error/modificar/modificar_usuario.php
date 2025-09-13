<?php
include_once '../models/conexion.php';
$id_cliente = $_GET['id'];
$sql = "SELECT * FROM USUARIO WHERE ID_Usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_array(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Modificar Usuario</h1>
        <form action="../controllers/modificar_usuario.php" method="post">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required>   

            <div class="mb-3">
                <label for="prime_nombre" class="form-label">Primer Nombre</label>
                <input type="text" class="form-control" id="prime_nombre" name="prime_nombre" value="<?php echo $usuario['Prime_Nombre']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
                <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" value="<?php echo $usuario['Segundo_Nombre']; ?>">
            </div>

            <div class="mb-3">
                <label for="prime_apellido" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" id="prime_apellido" name="prime_apellido" value="<?php echo $usuario['Prime_Apellido']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" value="<?php echo $usuario['Segundo_Apellido']; ?>">
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $usuario['Telefono']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $usuario['Correo']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" value="<?php echo $usuario['Contraseña']; ?>" required>
            </div>

            <label for="rol" class="form-label">Rol</label>
                    <select name="rol" class="form-control" required>
                        <option value="administrador">Administrador</option>
                        <option value="vendedor">Vendedor</option>
                    </select>

            <button type="submit" class="btn btn-primary" name="modificar" value="ok">Actualizar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
