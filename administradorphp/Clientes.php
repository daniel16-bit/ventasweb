<?php
session_start();
include 'models/conexion.php'; // conexión PDO para SQL Server

// Obtener clientes desde SQL Server
try {
    $sql = "SELECT * FROM CLIENTE";
    $stmt = $conexion->query($sql);
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener clientes: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Clientes - Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <div class="ms-auto me-3">
        <p class="text-light mb-0">Usted ingresó como: <?php echo htmlspecialchars($_SESSION['Prime_Nombre'] ?? 'Invitado'); ?></p>
    </div>
    <ul class="navbar-nav ms-auto me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Ajustes</a></li>
                <li><a class="dropdown-item" href="#">Historial de Actividades</a></li>
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
                    <a class="nav-link" href="Dashboard.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Panel</a>
                    <div class="sb-sidenav-menu-heading">Registros</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>Registros
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="Departamentos.php">Departamentos</a>
                            <a class="nav-link" href="Ciudades.php">Ciudades</a>
                            <a class="nav-link" href="Zonas.php">Zonas</a>
                            <a class="nav-link active" href="Clientes.php">Clientes</a>
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
            <h1>Clientes</h1>
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#miModal">Registrar Nuevo Cliente</button>
            <a href="Reportes/Clientes_pdf.php" class="btn btn-success mb-3">Generar Reporte</a>

            <!-- Modal Registrar Cliente -->
            <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="controllers/registrar_cliente.php" method="POST" class="was-validated">
                            <div class="modal-header">
                                <h5 class="modal-title" id="miModalLabel">Registrar Cliente</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Tipo</label>
                                    <input type="text" class="form-control" name="tipo" required>
                                    <div class="invalid-feedback">El campo tipo es obligatorio.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                    <div class="invalid-feedback">El campo nombre es obligatorio.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" name="telefono" required>
                                    <div class="invalid-feedback">El campo teléfono es obligatorio.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" class="form-control" name="direccion" required>
                                    <div class="invalid-feedback">El campo dirección es obligatorio.</div>
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

            <!-- Tabla Clientes -->
            <div class="card shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-table me-2"></i> Tabla de Clientes
                </div>
                <div class="card-body p-0">
                    <table id="datatablesSimple" class="table table-striped table-hover table-bordered mb-0 text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Nombre</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (count($clientes) > 0): ?>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?= $cliente['ID_Cliente']; ?></td>
                                    <td><?= htmlspecialchars($cliente['Tipo']); ?></td>
                                    <td><?= htmlspecialchars($cliente['Nombre']); ?></td>
                                    <td><?= htmlspecialchars($cliente['Telefono']); ?></td>
                                    <td><?= htmlspecialchars($cliente['Direccion']); ?></td>
                                    <td>
                                        <a href="./modificar/modificar_cliente.php?id=<?= $cliente['ID_Cliente']; ?>" class="text-primary me-3" data-bs-toggle="tooltip" title="Editar"><i class="fas fa-edit fs-5"></i></a>
                                        <a href="#" class="text-danger" data-href="controllers/eliminar_cliente.php?id=<?= $cliente['ID_Cliente']; ?>" data-bs-toggle="modal" data-bs-target="#confirmar-delete" title="Eliminar"><i class="fas fa-trash-alt fs-5"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">No hay clientes registrados.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">&copy; 2025 Administración</div>
                    <div>
                        <a href="#">Política de Privacidad</a> &middot;
                        <a href="#">Términos y Condiciones</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Modal Confirmar Eliminación -->
<div class="modal fade" id="confirmar-delete" tabindex="-1" aria-labelledby="confirmar-delete-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmar-delete-label">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">¿Estás seguro de que deseas eliminar este cliente?</div>
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
    const dataTable = new simpleDatatables.DataTable("#datatablesSimple");

    const confirmarModal = document.getElementById('confirmar-delete');
    confirmarModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const href = button.getAttribute('data-href');
        confirmarModal.querySelector('#btn-eliminar').setAttribute('href', href);
    });

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
</script>
</body>
</html>

