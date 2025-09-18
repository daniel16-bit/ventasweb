<!-- Modal Ajustes de Perfil -->
<div class="modal fade" id="modalAjustes" tabindex="-1" aria-labelledby="modalAjustesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="controllers/actualizar_perfil.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAjustesLabel">Ajustes de Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- ID del usuario en sesión -->
                    <input type="hidden" name="id_usuario" value="<?= $_SESSION['ID_Usuario'] ?? '' ?>">

                    <!-- Primer Nombre -->
                    <div class="mb-3">
                        <label class="form-label">Primer Nombre</label>
                        <input type="text" class="form-control" name="prime_nombre" value="<?= htmlspecialchars($_SESSION['Prime_Nombre'] ?? '') ?>" required>
                    </div>

                    <!-- Segundo Nombre -->
                    <div class="mb-3">
                        <label class="form-label">Segundo Nombre</label>
                        <input type="text" class="form-control" name="segundo_nombre" value="<?= htmlspecialchars($_SESSION['Segundo_Nombre'] ?? '') ?>">
                    </div>

                    <!-- Primer Apellido -->
                    <div class="mb-3">
                        <label class="form-label">Primer Apellido</label>
                        <input type="text" class="form-control" name="prime_apellido" value="<?= htmlspecialchars($_SESSION['Prime_Apellido'] ?? '') ?>" required>
                    </div>

                    <!-- Segundo Apellido -->
                    <div class="mb-3">
                        <label class="form-label">Segundo Apellido</label>
                        <input type="text" class="form-control" name="segundo_apellido" value="<?= htmlspecialchars($_SESSION['Segundo_Apellido'] ?? '') ?>">
                    </div>

                    <!-- Correo -->
                    <div class="mb-3">
                        <label class="form-label">Correo</label>
                        <input type="email" class="form-control" name="correo" value="<?= htmlspecialchars($_SESSION['Correo'] ?? '') ?>" required>
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-3">
                        <label class="form-label">Contraseña (opcional)</label>
                        <input type="password" class="form-control" name="contrasena">
                        <small class="text-muted">Déjalo vacío si no deseas cambiar la contraseña.</small>
                    </div>

                    <!-- Rol (solo lectura) -->
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <input type="text" class="form-control" name="rol" value="<?= htmlspecialchars($_SESSION['rol'] ?? '') ?>" readonly>
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
