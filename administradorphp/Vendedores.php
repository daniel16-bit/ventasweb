<?php
include 'models/conexion.php';

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
    ZONA Z ON VE.ID_Zona = Z.ID_Zona";

$result = $conexion->query($sql);

$vendedores = [];
if ($result->num_rows > 0) {    
    while ($row = $result->fetch_assoc()) { 
        $vendedores[] = $row;
    }
} else {
    echo "No se encontraron vendedores.";
}

session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Vendedores - Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <p class="text-light">Usted ingresó como: <?php echo htmlspecialchars($_SESSION['Prime_Nombre'] ?? 'Invitado'); ?></p>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                    <li><a class="dropdown-item" href="#!">Registro de actividades</a></li>
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
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Panel
                        </a>
                        <div class="sb-sidenav-menu-heading">Registros</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>Registros
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
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
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main class="container-fluid px-4 mt-4">
                <h1>VENDEDORES</h1>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#miModal">
                    Registrar Vendedor Nuevo
                </button>
                <a href="Reportes/Vendedores_pdf.php" class="btn btn-primary mb-3">Generar Reporte</a>

                <!-- Modal para Registrar Zona y Vendedor -->
                <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="miModalLabel">Registrar Zona y Vendedor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <form action="controllers/registrar_vendedores.php" method="POST">
                                    <div class="mb-3">
                                        <label for="nombreZona" class="form-label">Nombre de la Zona</label>
                                        <input type="text" class="form-control" id="nombreZona" name="nombreZona" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombreUsuario" class="form-label">Nombre del Vendedor</label>
                                        <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidoUsuario" class="form-label">Apellido del Vendedor</label>
                                        <input type="text" class="form-control" id="apellidoUsuario" name="apellidoUsuario" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Registrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla Vendedores -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-table me-2"></i> Tabla Vendedores
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID_Vendedor</th>
                                    <th>Nombre Completo</th>
                                    <th>Zona</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($vendedores as $vendedor): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($vendedor['ID_Vendedor']); ?></td>
                                        <td><?php echo htmlspecialchars($vendedor['Nombre_Vendedor'] . ' ' . $vendedor['Segundo_Nombre_Vendedor'] . ' ' . $vendedor['Apellido_Vendedor'] . ' ' . $vendedor['Segundo_Apellido_Vendedor']); ?></td>
                                        <td><?php echo htmlspecialchars($vendedor['Zona']); ?></td>
                                        <td>
                                            <a href="./modificar/modificar_vendedores.php?id=<?php echo $vendedor['ID_Vendedor']; ?>" title="Editar">
                                                <i class="fas fa-edit" style="font-size:30px; color: #d63384;"></i>
                                            </a>
                                            <a href="#" 
                                               data-href="controllers/eliminar_vendedor.php?id=<?php echo $vendedor['ID_Vendedor']; ?>" 
                                               data-bs-toggle="modal" 
                                               data-bs-target="#confirmar-delete" 
                                               title="Eliminar">
                                                <i class="fas fa-trash-alt" style="font-size:30px; color:rgb(255, 70, 70)"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; 2023 Administración</div>
                        <div>
                            <a href="#">Política de Privacidad</a>
                            &middot;
                            <a href="#">Términos y Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="confirmar-delete" tabindex="-1" aria-labelledby="confirmar-delete-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmar-delete-label">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>  
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este vendedor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <script>
        // Inicializar Simple-DataTables
        const dataTable = new simpleDatatables.DataTable("#datatablesSimple");

        // Actualizar enlace del botón eliminar en el modal dinámicamente
        const confirmarDeleteModal = document.getElementById('confirmar-delete');
        confirmarDeleteModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget; // Botón que activó el modal
            const href = button.getAttribute('data-href'); // Obtener URL para eliminar
            const btnEliminar = confirmarDeleteModal.querySelector('#btn-eliminar');
            btnEliminar.setAttribute('href', href);
        });
    </script>
</body>

</html>
