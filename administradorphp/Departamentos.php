<?php 
// Configuración global y sesión segura
include_once '../config/config.php';

// Incluir la conexión a la base de datos
include '../models/conexion.php'; // Este archivo debe contener tu conexión con la base de datos

// Verificación de sesión de usuario
if (!function_exists('validateUserSession') || !validateUserSession()) {
    header('Location: ../formularios/formulario.php');
    exit();
}

// Consulta para obtener los departamentos
$sql = "SELECT * FROM colfar.DEPARTAMENTO";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true)); // Si la consulta falla, muestra el error
} else {
    $departamentos = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $departamentos[] = $row; // Guardar los departamentos en un array
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Departamentos - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <div class="ms-auto text-light">Usted ingresó como: <?php echo $_SESSION['Prime_Nombre']; ?></div>
    </nav>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Navegación</div>
                        <a class="nav-link" href="Dashboard.php"><i class="fas fa-tachometer-alt me-2"></i>Panel</a>
                        <div class="sb-sidenav-menu-heading">Registros</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRegistros">
                            <i class="fas fa-columns me-2"></i>Registros
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseRegistros">
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

        <!-- Contenido -->
        <div id="layoutSidenav_content">
            <main class="container-fluid px-4 mt-4">
                <h1 class="mb-4">DEPARTAMENTOS</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">COLFAR DE COLOMBIA S.A.S.</li></ol>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#miModal">
                    <i class="fas fa-plus"></i> Registrar Departamento</button>
                <a href="Reportes/Departamentospdf.php" class="btn btn-primary mb-3">Generar Reporte</a>

                <!-- Modal Registrar -->
                <div class="modal fade" id="miModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="controllers/registrar_departamento.php" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title">Registrar Departamento</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nombre del Departamento</label>
                                        <input type="text" name="nombreDepartamento" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Registrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="card shadow-sm rounded mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-table me-2"></i>Tabla Departamentos
                    </div>
                    <div class="card-body p-0">
                        <table id="datatablesSimple" class="table table-striped table-hover table-bordered text-center align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre Departamento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($departamentos as $dep): ?>
                                    <tr>
                                        <td><?= $dep['ID_Departamento'] ?></td>
                                        <td><?= !empty(trim($dep['Nombre'])) ? htmlspecialchars($dep['Nombre']) : '<span class="text-danger">[Sin nombre]</span>' ?></td>

                                        <td>
                                            <a href="modificar/modificar_departamento.php?id=<?= $dep['ID_Departamento'] ?>" class="btn btn-primary btn-sm me-1" title="Editar"><i class="fas fa-edit"></i></a>
                                            <a href="#" data-href="controllers/eliminar_departamentos.php?id=<?= $dep['ID_Departamento'] ?>" data-bs-toggle="modal" data-bs-target="#confirmar-delete" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-between small">
                        <div class="text-muted">&copy; 2023 COLFAR</div>
                        <div>
                            <a href="#">Privacy Policy</a> &middot; <a href="#">Terms & Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div class="modal fade" id="confirmar-delete" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">¿Seguro que deseas eliminar este departamento?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
        // DataTable
        const dataTable = new simpleDatatables.DataTable("#datatablesSimple");

        // Modal eliminar dinámico
        const confirmarModal = document.getElementById('confirmar-delete');
        confirmarModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const href = button.getAttribute('data-href');
            confirmarModal.querySelector('#btn-eliminar').setAttribute('href', href);
        });
    </script>
</body>
</html>

