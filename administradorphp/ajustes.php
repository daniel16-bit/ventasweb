<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<?php if (!isset($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); } ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ajustes de Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<!-- Modal Ajustes de Perfil -->
<div class="modal fade" id="modalAjustes" tabindex="-1" aria-labelledby="modalAjustesLabel" aria-hidden="true">
    <div class="modal-dialog">
<div class="modal-content">
            <form action="controllers/actualizar_perfil.php" method="POST" autocomplete="off" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAjustesLabel">Ajustes de Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- ID del usuario en sesión -->
                    <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($_SESSION['ID_Usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

                    <!-- Primer Nombre -->
                    <div class="mb-3">
                        <label class="form-label">Primer Nombre</label>
                        <input type="text" class="form-control" name="prime_nombre" value="<?= htmlspecialchars($_SESSION['Prime_Nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required maxlength="50" pattern="^[\p{L} .'-]+$" title="Solo letras y espacios">
                    </div>

                    <!-- Segundo Nombre -->
                    <div class="mb-3">
                        <label class="form-label">Segundo Nombre</label>
                        <input type="text" class="form-control" name="segundo_nombre" value="<?= htmlspecialchars($_SESSION['Segundo_Nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>" maxlength="50" pattern="^[\p{L} .'-]+$" title="Solo letras y espacios">
                    </div>

                    <!-- Primer Apellido -->
                    <div class="mb-3">
                        <label class="form-label">Primer Apellido</label>
                        <input type="text" class="form-control" name="prime_apellido" value="<?= htmlspecialchars($_SESSION['Prime_Apellido'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required maxlength="50" pattern="^[\p{L} .'-]+$" title="Solo letras y espacios">
                    </div>

                    <!-- Segundo Apellido -->
                    <div class="mb-3">
                        <label class="form-label">Segundo Apellido</label>
                        <input type="text" class="form-control" name="segundo_apellido" value="<?= htmlspecialchars($_SESSION['Segundo_Apellido'] ?? '', ENT_QUOTES, 'UTF-8') ?>" maxlength="50" pattern="^[\p{L} .'-]+$" title="Solo letras y espacios">
                    </div>

                    <!-- Correo -->
                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" class="form-control" name="correo" value="<?= htmlspecialchars($_SESSION['Correo'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required maxlength="120">
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label class="form-label">Contraseña (opcional)</label>
                        <input type="password" class="form-control" name="contrasena" minlength="8" maxlength="72" autocomplete="new-password">
                        <small class="text-muted">Déjalo vacío si no deseas cambiar la contraseña.</small>
                    </div>

                    <!-- Rol (solo lectura) -->
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <input type="text" class="form-control" name="rol" value="<?= htmlspecialchars($_SESSION['rol'] ?? '', ENT_QUOTES, 'UTF-8') ?>" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>