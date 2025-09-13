<?php 
include 'models/conexion.php'; // aquí ya debe estar $conn con sqlsrv_connect()

// Consulta para traer proveedores
$sql = "SELECT * FROM colfar.PROVEEDOR";
$stmt = sqlsrv_query($conn, $sql);

$provedores = [];
if ($stmt !== false) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $provedores[] = $row;
    }
} else {
    echo "Error al consultar proveedores: ";
    die(print_r(sqlsrv_errors(), true));
}

sqlsrv_free_stmt($stmt);
?>
<?php
session_start();
if(isset($_SESSION['Prime_Nombre']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Proveedores - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <p class="text-light">Usted ingresó como: <?php echo $_SESSION['Prime_Nombre']; ?></p>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                    <li><a class="dropdown-item" href="#!">Historial de Actividades</a></li>
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
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Registros
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
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">PROVEEDORES</h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                        Registrar Proveedor
                    </button>

                    <!-- Modal para registrar proveedor -->
                    <div class="modal fade" id="miModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Registrar Proveedor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="controllers/registrar_proveedor.php" method="post" class="was-validated">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre Proveedor</label>
                                            <input type="text" class="form-control" name="nombre" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" name="telefono" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <input type="text" class="form-control" name="direccion" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Registrar</button>
                                        </div>
                                    </form>  
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="card mb-4 mt-3">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Tabla Proveedores
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre Proveedor</th>
                                        <th>Teléfono</th>
                                        <th>Dirección</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    <?php foreach ($provedores as $provedor): ?>
                                        <tr>
                                            <td><?php echo $provedor['ID_Proveedor']; ?></td>
                                            <td><?php echo $provedor['Nombre']; ?></td>
                                            <td><?php echo $provedor['Telefono']; ?></td>
                                            <td><?php echo isset($provedor['Direccion']) ? $provedor['Direccion'] : ''; ?></td>
                                            <td>
                                                <a href="./modificar/modificar_proveedor.php?id=<?php echo $provedor['ID_Proveedor']; ?>">
                                                    <i class="fas fa-edit" style="font-size:20px; color: #0d6efd;"></i>
                                                </a>
                                                <a href="controllers/eliminar_proveedor.php?id=<?php echo $provedor['ID_Proveedor']; ?>" 
                                                   data-bs-toggle="modal" data-bs-target="#confirmar-delete">
                                                    <i class="fas fa-trash-alt" style="font-size:20px; color:red"></i>
                                                </a>
                                            </td>  
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>   
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Confirmar Eliminar -->
    <div class="modal fade" id="confirmar-delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>  
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este proveedor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
        // pasar id al modal de eliminar
        const deleteModal = document.getElementById('confirmar-delete');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget;
            let href = button.getAttribute('href');
            let confirmBtn = deleteModal.querySelector('#btn-eliminar');
            confirmBtn.setAttribute('href', href);
        });
    </script>
</body>
</html>
