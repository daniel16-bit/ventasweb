<?php 
session_start();
include '../models/conexion.php';

$sql = "SELECT * FROM colfar.USUARIO ";
$result = $conexion->query($sql);

$usuarios = [];
if ($result->num_rows > 0) {    
    while ($row = $result->fetch_assoc()) { 
        $usuarios[] = $row;
    }
} else {
    echo "No se encontraron usuarios.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title> Usuario - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Navbar y sidebar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <p class="text-light">Usted ingresó como: <?php echo $_SESSION['Prime_Nombre'] ?? 'Invitado'; ?></p>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
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
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Registros
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
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
                                <a class="nav-link" href="layout-static.html">Static Navigation</a>
                                <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Usted ingresó como:</div>
                    Administrador
                </div>
            </nav>
        </div>
        
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">USUARIOS</h1>

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                        Registrar Usuario Nuevo
                    </button>
                    <a href="Reportes/usuarios_pdf.php" class="btn btn-primary">Generar Reporte</a>

                    <!-- Botón para enviar correos masivos -->
                    <a href="enviar_correos_masivos.php" class="btn btn-success">Enviar correos a todos</a>

                    <!-- Formulario para enviar correos a usuarios seleccionados -->
                    <form action="enviar_correos_seleccionados.php" method="POST" id="formEnviarCorreos">
                        <button type="submit" class="btn btn-success mb-3">Enviar correos seleccionados</button>

                        <div class="card mb-4 mt-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Tabla Usuarios
                            </div>
                            <div class="table-responsive">
                                <table id="datatablesSimple" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectTodos"></th> <!-- Checkbox para seleccionar todos -->
                                            <th>ID</th>
                                            <th>Primer Nombre</th>
                                            <th>Segundo Nombre</th>
                                            <th>Primer Apellido</th>
                                            <th>Segundo Apellido</th>
                                            <th>Teléfono</th>
                                            <th>Contraseña</th>
                                            <th>Correo</th>
                                            <th>Rol</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($usuarios as $usuario): ?>
                                        <tr>
                                            <td><input type="checkbox" name="usuarios_seleccionados[]" value="<?php echo $usuario['ID_Usuario']; ?>"></td>
                                            <td><?php echo $usuario['ID_Usuario']; ?></td>
                                            <td><?php echo $usuario['Prime_Nombre']; ?></td>
                                            <td><?php echo $usuario['Segundo_Nombre']; ?></td>
                                            <td><?php echo $usuario['Prime_Apellido']; ?></td>
                                            <td><?php echo $usuario['Segundo_Apellido']; ?></td>
                                            <td><?php echo $usuario['Telefono']; ?></td>
                                            <td><?php echo $usuario['Contraseña']; ?></td>
                                            <td><?php echo $usuario['Correo']; ?></td>
                                            <td><?php echo $usuario['rol']; ?></td>
                                            <td>
                                                <a href="./modificar/modificar_usuario.php?id=<?php echo $usuario['ID_Usuario']; ?>">
                                                    <i class='fas fa-edit' style='font-size:25px; color: #d63384;'></i>
                                                </a>
                                                <a href="Usuarios.php?id=<?php echo $usuario['ID_Usuario']; ?>" data-bs-toggle="modal" data-bs-target="#confirmar-delete">
                                                    <i class="fas fa-trash-alt" style="font-size:30px; color:rgb(255, 70, 70)"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>

                    <!-- Modal Registrar Usuario -->
                    <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="miModalLabel">DATOS DEL USUARIO</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="controllers/registrar_usuario.php" method="POST">
                                        <label for="prime_nombre" class="form-label">Primer Nombre</label>
                                        <input type="text" class="form-control" name="prime_nombre" placeholder="Primer Nombre" required>

                                        <label for="segundo_nombre" class="form-label">Segundo Nombre</label>
                                        <input type="text" class="form-control" name="segundo_nombre" placeholder="Segundo Nombre">

                                        <label for="prime_apellido" class="form-label">Primer Apellido</label>
                                        <input type="text" class="form-control" name="prime_apellido" placeholder="Primer Apellido" required>

                                        <label for="segundo_apellido" class="form-label">Segundo Apellido</label>
                                        <input type="text" class="form-control" name="segundo_apellido" placeholder="Segundo Apellido">

                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" name="telefono" placeholder="Teléfono Cliente" required>

                                        <label for="correo" class="form-label">Correo</label>
                                        <input type="email" class="form-control" name="correo" placeholder="Correo Cliente" required>

                                        <label for="contraseña" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" name="contraseña" placeholder="Contraseña" required>

                                        <label for="rol" class="form-label">Rol</label>
                                        <select name="rol" class="form-control" required>
                                            <option value="administrador">Administrador</option>
                                            <option value="vendedor">Vendedor</option>
                                        </select>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Registrar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>

            <!-- Footer -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Confirmar eliminación -->
    <div class="modal fade" id="confirmar-delete" tabindex="-1" role="dialog" aria-labelledby="confirmar-delete-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmar-delete-label">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>  
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este usuario?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="controllers/eliminar_usuario.php?id=<?php echo $usuario['ID_Usuario']; ?>" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script>
        // Script para seleccionar/deseleccionar todos los checkboxes
        document.getElementById('selectTodos').addEventListener('change', function(){
            const checkboxes = document.querySelectorAll('input[name="usuarios_seleccionados[]"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>

</body>
</html>