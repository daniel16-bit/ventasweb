<?php 
include '../models/conexion.php'; // conexión con Azure SQL
session_start();



$sql = "SELECT ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Telefono, Correo, rol, Contrasena FROM colfar.USUARIO";
    

$stmt = sqlsrv_query($conn, $sql);

$usuarios = [];
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $usuarios[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Usuarios - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <div class="ms-auto me-0 me-md-3 my-2 my-md-0 text-white">
            Usted ingresó como: <?php echo htmlspecialchars($_SESSION['Prime_Nombre'] ?? 'Invitado'); ?>
        </div>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Configuración</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="../index.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Navegación</div>
                        <a class="nav-link" href="Dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Panel
                        </a>
                        <div class="sb-sidenav-menu-heading">Registros</div>
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="true" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Registros
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse show" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="Departamentos.php">Departamentos</a>
                        <a class="nav-link" href="Ciudades.php">Ciudades</a>
                        <a class="nav-link" href="Zonas.php">Zonas</a>
                        <a class="nav-link" href="Clientes.php">Clientes</a>
                        <a class="nav-link" href="Vendedores.php">Vendedores</a>
                        <a class="nav-link" href="Compras.php">Compras</a>
                        <a class="nav-link" href="Ventas.php">Ventas</a>
                        <a class="nav-link" href="Usuarios.php">Usuarios</a>
                        <a class="nav-link" href="Productos.php">Productos</a>
                        <a class="nav-link" href="Proveedores.php">Proveedores</a>
                    </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Sesión iniciada como:</div>
                    Administrador
                </div>
            </nav>
        </div>
        
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">USUARIOS</h1>

                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#miModal">
                        <i class="fas fa-plus"></i> Registrar Usuario
                    </button>
                    <a href="Reportes/usuarios_pdf.php" class="btn btn-primary mb-3">Generar Reporte</a>

                    <div class="card shadow-sm rounded mb-4">
                        <div class="card-header bg-primary text-white">
                            <i class="fas fa-table me-1"></i>
                            Tabla de Usuarios
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Primer Nombre</th>
                                        <th>Segundo Nombre</th>
                                        <th>Primer Apellido</th>
                                        <th>Segundo Apellido</th>
                                        <th>Teléfono</th>
                                        <th>Correo</th>
                                        <th>Rol</th>
                                        <th>Contraseña</th>
                                        <th>Acciones</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($usuarios)): ?>
                                        <?php foreach ($usuarios as $usuario): ?>
<tr>
    <td><?php echo htmlspecialchars($usuario['ID_Usuario']); ?></td>
    <td><?php echo htmlspecialchars($usuario['Prime_Nombre']); ?></td>
    <td><?php echo htmlspecialchars($usuario['Segundo_Nombre']); ?></td>
    <td><?php echo htmlspecialchars($usuario['Prime_Apellido']); ?></td>
    <td><?php echo htmlspecialchars($usuario['Segundo_Apellido']); ?></td>
    <td><?php echo htmlspecialchars($usuario['Telefono']); ?></td>
    <td><?php echo htmlspecialchars($usuario['Correo']); ?></td>
    <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
    <td><?php echo htmlspecialchars($usuario['Contrasena']); ?></td>
 
    <td>
        <a href="./modificar/modificar_usuario.php?id=<?php echo $usuario['ID_Usuario']; ?>"  class="btn btn-primary btn-sm me-1" title="Editar"><i class="fas fa-edit"></i>
        </a>
        <a href="#" data-href="controllers/eliminar_usuario.php?id=<?php echo $usuario['ID_Usuario']; ?>" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmar-delete" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
        </a>
    </td>
</tr>

                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="text-center">No se encontraron usuarios.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; COLFAR 2025</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="miModalLabel">Registrar Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="controllers/registrar_usuario.php" method="POST">
                        <div class="mb-3"><label class="form-label">Primer Nombre</label><input type="text" class="form-control" name="prime_nombre" required></div>
                        <div class="mb-3"><label class="form-label">Segundo Nombre</label><input type="text" class="form-control" name="segundo_nombre"></div>
                        <div class="mb-3"><label class="form-label">Primer Apellido</label><input type="text" class="form-control" name="prime_apellido" required></div>
                        <div class="mb-3"><label class="form-label">Segundo Apellido</label><input type="text" class="form-control" name="segundo_apellido"></div>
                        <div class="mb-3"><label class="form-label">Teléfono</label><input type="text" class="form-control" name="telefono" required></div>
                        <div class="mb-3"><label class="form-label">Correo</label><input type="email" class="form-control" name="correo" required></div>
                        <div class="mb-3"><label class="form-label">Contraseña</label><input type="password" class="form-control" name="contraseña" required></div>
                        <div class="mb-3"><label class="form-label">Rol</label><select name="rol" class="form-select" required><option value="administrador">Administrador</option><option value="vendedor">Vendedor</option></select></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmar-delete" tabindex="-1" aria-labelledby="confirmar-delete-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmar-delete-label">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script>
    // SCRIPT AÑADIDO: para que el botón de eliminar de CADA fila funcione correctamente
    document.addEventListener('DOMContentLoaded', function () {
        const confirmarModal = document.getElementById('confirmar-delete');
        confirmarModal.addEventListener('show.bs.modal', function (event) {
            // Botón que activó el modal
            const button = event.relatedTarget;
            // Extraer la URL del atributo data-href
            const href = button.getAttribute('data-href');
            // Actualizar el href del botón "Eliminar" del modal
            const botonEliminar = confirmarModal.querySelector('#btn-eliminar');
            botonEliminar.setAttribute('href', href);
        });
    });
    </script>
</body>
</html>