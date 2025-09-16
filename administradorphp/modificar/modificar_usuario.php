<?php
include_once '../models/conexion.php';

if (!isset($_GET['id'])) {
    die("Error: ID no especificado.");
}

$id_usuario = $_GET['id'];

// Consulta del usuario
$sql = "SELECT * FROM colfar.USUARIO WHERE ID_Usuario = ?";
$params = array($id_usuario);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die("Error en la consulta: " . print_r(sqlsrv_errors(), true));
}

$usuario = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if (!$usuario) {
    die("Usuario no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Modificar Usuario</h1>
        <form action="../controllers/modificar_usuario.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id_usuario); ?>" required>   

            <div class="mb-3">
                <label for="prime_nombre" class="form-label">Primer Nombre</label>
                <input type="text" class="form-control" id="prime_nombre" name="prime_nombre" value="<?php echo htmlspecialchars($usuario['Prime_Nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
                <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre" value="<?php echo htmlspecialchars($usuario['Segundo_Nombre']); ?>">
            </div>

            <div class="mb-3">
                <label for="prime_apellido" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" id="prime_apellido" name="prime_apellido" value="<?php echo htmlspecialchars($usuario['Prime_Apellido']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido" value="<?php echo htmlspecialchars($usuario['Segundo_Apellido']); ?>">
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['Telefono']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['Correo']); ?>" required>
            </div>

            <div class="mb-3">
    <label for="contraseña" class="form-label">Contraseña</label>
    <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="Ingrese nueva contraseña (opcional)">
</div>
    

            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select name="rol" class="form-control" required>
                    <option value="administrador" <?php echo ($usuario['Rol'] === 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                    <option value="vendedor" <?php echo ($usuario['Rol'] === 'vendedor') ? 'selected' : ''; ?>>Vendedor</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" name="modificar" value="ok">Actualizar</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

