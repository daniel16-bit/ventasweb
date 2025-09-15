<?php 
include '../models/conexion.php'; // conexión con Azure SQL
session_start();

// Verificar sesión
if (!isset($_SESSION['Prime_Nombre'])) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT 
            VE.ID_Vendedor, 
            U.Prime_Nombre, U.Segundo_Nombre, 
            U.Prime_Apellido, U.Segundo_Apellido,
            Z.NombreZona
        FROM colfar.VENDEDOR VE
        JOIN colfar.USUARIO U ON VE.ID_Usuario = U.ID_Usuario
        JOIN colfar.ZONA Z ON VE.ID_Zona = Z.ID_Zona";

$stmt = sqlsrv_query($conn, $sql);

$vendedores = [];
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $vendedores[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vendedores - Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css" rel="stylesheet">
</head>
<body>
    <!-- Barra superior -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <p class="text-light">Usted ingresó como: <?= htmlspecialchars($_SESSION['Prime_Nombre'] ?? 'Invitado') ?></p>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                    <li><a class="dropdown-item" href="#!">Registro de actividades</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../index.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Barra lateral -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <!-- Panel -->
                        <div class="sb-sidenav-menu-heading">Panel</div>
                        <a class="nav-link" href="Dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Panel
                        </a>

                        <!-- Registros -->
                        <div class="sb-sidenav-menu-heading">Registros</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRegistros" aria-expanded="false" aria-controls="collapseRegistros">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Registros
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseRegistros" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
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

                        <!-- Facturas -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseFacturas" aria-expanded="false" aria-controls="collapseFacturas">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                            Facturas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseFacturas" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="FacturasEmitidas.php">Emitidas</a>
                                <a class="nav-link" href="FacturasRecibidas.php">Recibidas</a>
                            </nav>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Contenido principal -->
        <div id="layoutSidenav_content">
            <main class="container-fluid px-4 mt-4">
                <h1>VENDEDORES</h1>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#miModal">
                    Registrar Vendedor Nuevo
                </button>
                <a href="Reportes/Vendedores_pdf.php" class="btn btn-primary mb-3">Generar Reporte</a>

                <!-- Modal para Registrar Vendedor -->
                <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="controllers/registrar_vendedores.php" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="miModalLabel">Registrar Vendedor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="usuario" class="form-label">Seleccionar Usuario</label>
                                        <select class="form-select" id="usuario" name="usuario" required>
                                            <option value="">-- Seleccionar --</option>
                                            <?php foreach($usuarios as $u): ?>
                                                <option value="<?= $u['ID_Usuario'] ?>"><?= htmlspecialchars($u['Prime_Nombre'] . ' ' . $u['Segundo_Nombre'] . ' ' . $u['Prime_Apellido'] . ' ' . $u['Segundo_Apellido']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="zona" class="form-label">Seleccionar Zona</label>
                                        <select class="form-select" id="zona" name="zona" required>
                                            <option value="">-- Seleccionar --</option>
                                            <?php foreach($zonas as $z): ?>
                                                <option value="<?= $z['ID_Zona'] ?>"><?= htmlspecialchars($z['NombreZona']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
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

                <!-- Tabla Vendedores -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white"><i class="fas fa-table me-2"></i> Tabla Vendedores</div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-striped table-bordered text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID_Vendedor</th>
                                    <th>Nombre Completo</th>
                                    <th>Zona</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($vendedores as $v): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($v['ID_Vendedor']) ?></td>
                                        <td><?= htmlspecialchars($v['Prime_Nombre'] . ' ' . $v['Segundo_Nombre'] . ' ' . $v['Prime_Apellido'] . ' ' . $v['Segundo_Apellido']) ?></td>
                                        <td><?= htmlspecialchars($v['NombreZona']) ?></td>
                                        <td>
                                            <a href="./modificar/modificar_vendedores.php?id=<?= $v['ID_Vendedor'] ?>" title="Editar">
                                                <i class="fas fa-edit" style="font-size:25px; color:#d63384;"></i>
                                            </a>
                                            <a href="#" data-href="controllers/eliminar_vendedor.php?id=<?= $v['ID_Vendedor'] ?>" data-bs-toggle="modal" data-bs-target="#confirmar-delete" title="Eliminar">
                                                <i class="fas fa-trash-alt" style="font-size:25px; color:rgb(255,70,70)"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="6">No hay compras registradas.</td></tr>
                                <?php endif; ?>
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
                            <a href="#">Política de Privacidad</a> &middot; <a href="#">Términos y Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Confirmación Eliminar -->
    <div class="modal fade" id="confirmar-delete" tabindex="-1" aria-labelledby="confirmar-delete-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">¿Estás seguro de que deseas eliminar este vendedor?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script>
        // Inicializar DataTables
        const dataTable = new simpleDatatables.DataTable("#datatablesSimple");

        // Configurar modal eliminar
        const confirmarDeleteModal = document.getElementById('confirmar-delete');
        confirmarDeleteModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const href = button.getAttribute('data-href');
            const btnEliminar = confirmarDeleteModal.querySelector('#btn-eliminar');
            btnEliminar.setAttribute('href', href);
        });
    </script>
</body>
</html>

