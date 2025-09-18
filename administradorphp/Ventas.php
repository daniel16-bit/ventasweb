<?php 
include '../models/conexion.php'; // conexión con Azure SQL
session_start();

// =========================
// CONSULTA VENTAS
// =========================
$sql = "SELECT 
            V.ID_Venta,
            V.Fecha,
            V.Descuentos,
            V.Total,
            C.Nombre AS Nombre_Cliente,
            U.Prime_Nombre AS Nombre_Vendedor,
            U.Prime_Apellido AS Apellido_Vendedor,
            Z.NombreZona AS Nombre_Zona,
            D.Nombre AS Nombre_Departamento,
            P.Nombre AS Nombre_Producto
        FROM colfar.VENTA V
        INNER JOIN colfar.CLIENTE C ON V.ID_Cliente = C.ID_Cliente
        INNER JOIN colfar.VENDEDOR VE ON V.ID_Vendedor = VE.ID_Vendedor
        INNER JOIN colfar.USUARIO U ON VE.ID_Usuario = U.ID_Usuario
        INNER JOIN colfar.ZONA Z ON V.ID_Zona = Z.ID_Zona
        INNER JOIN colfar.DEPARTAMENTO D ON V.ID_Departamento = D.ID_Departamento
        INNER JOIN colfar.PRODUCTO P ON V.ID_Producto = P.ID_Producto";

$stmt = sqlsrv_query($conn, $sql);
$ventas = [];
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $ventas[] = $row;
    }
}

// =========================
// CONSULTAS PARA EL MODAL
// =========================
function getOptions($conn, $tabla, $id, $nombre) {
    $options = "";
    $sql = "SELECT $id, $nombre FROM colfar.$tabla";
    $stmt = sqlsrv_query($conn, $sql);
    if ($stmt !== false) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $options .= "<option value='" . $row[$id] . "'>" . htmlspecialchars($row[$nombre]) . "</option>";
        }
    }
    return $options;
}

$clientes = getOptions($conn, "CLIENTE", "ID_Cliente", "Nombre");
$vendedores = getOptions($conn, "VENDEDOR", "ID_Vendedor", "ID_Vendedor"); // Cambia si necesitas mostrar nombre de usuario
$zonas = getOptions($conn, "ZONA", "ID_Zona", "NombreZona");
$departamentos = getOptions($conn, "DEPARTAMENTO", "ID_Departamento", "Nombre");
$productos = getOptions($conn, "PRODUCTO", "ID_Producto", "Nombre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas - Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Barra de navegación superior -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="ms-auto text-light">
            Usted ingresó como: <?= htmlspecialchars($_SESSION['Prime_Nombre']) ?>
        </div>
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

                        <!-- Facturas -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseFacturas" aria-expanded="false" aria-controls="collapseFacturas">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                            Facturas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseFacturas" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="FacturasEmitidas.php">Emitidas</a>
                                <a class="nav-link" href="FacturasRecibidas.php">Recibidas</a>
                            </nav>
                        </div>

                        <!-- Reportes -->
                        <div class="sb-sidenav-menu-heading">Reportes</div>
                        <a class="nav-link" href="Reportes.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                            Reportes
                        </a>
                    </div>
                </div>

                <div class="sb-sidenav-footer">
                    <div class="small">Conectado como:</div>
                    <?= htmlspecialchars($_SESSION['Prime_Nombre']) ?>
                </div>
            </nav>
        </div>

        <!-- Contenido principal -->
        <div id="layoutSidenav_content">
            <main class="container-fluid px-4 mt-4">
                <h1>Ventas</h1>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#miModal">
                    Registrar Nueva Venta
                </button>
                <a href="Reportes/ventas_pdf.php" class="btn btn-primary mb-3">Generar Reporte</a>

                <!-- =========================
                     MODAL REGISTRAR VENTA
                ========================== -->
                <div class="modal fade" id="miModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="controllers/registrar_venta.php" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title">Registrar Nueva Venta</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Cliente</label>
                                        <select class="form-control" name="id_cliente" required>
                                            <option value="">Seleccione...</option>
                                            <?= $clientes ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Vendedor</label>
                                        <select class="form-control" name="id_vendedor" required>
                                            <option value="">Seleccione...</option>
                                            <?= $vendedores ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Zona</label>
                                        <select class="form-control" name="id_zona" required>
                                            <option value="">Seleccione...</option>
                                            <?= $zonas ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Departamento</label>
                                        <select class="form-control" name="id_departamento" required>
                                            <option value="">Seleccione...</option>
                                            <?= $departamentos ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Producto</label>
                                        <select class="form-control" name="id_producto" required>
                                            <option value="">Seleccione...</option>
                                            <?= $productos ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Fecha</label>
                                        <input type="date" class="form-control" name="fecha" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Descuento</label>
                                        <input type="number" class="form-control" name="descuento" value="0">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Total</label>
                                        <input type="number" class="form-control" name="total" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Registrar</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Tabla Ventas -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-table me-2"></i> Tabla Ventas
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha</th>
                                    <th>Descuentos</th>
                                    <th>Total</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Zona</th>
                                    <th>Departamento</th>
                                    <th>Producto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($ventas as $venta): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($venta['ID_Venta']) ?></td>
                                        <td><?= htmlspecialchars($venta['Fecha']->format('Y-m-d H:i:s')) ?></td>
                                        <td><?= htmlspecialchars($venta['Descuentos']) ?></td>
                                        <td><?= htmlspecialchars($venta['Total']) ?></td>
                                        <td><?= htmlspecialchars($venta['Nombre_Cliente']) ?></td>
                                        <td><?= htmlspecialchars($venta['Nombre_Vendedor'] . ' ' . $venta['Apellido_Vendedor']) ?></td>
                                        <td><?= htmlspecialchars($venta['Nombre_Zona']) ?></td>
                                        <td><?= htmlspecialchars($venta['Nombre_Departamento']) ?></td>
                                        <td><?= htmlspecialchars($venta['Nombre_Producto']) ?></td>
                                        <td>
                                            <!-- Editar -->
                                            <a href="modificar/modificar_venta.php?id=<?= $venta['ID_Venta'] ?>" title="Editar">
                                                <i class="fas fa-edit" style="font-size:22px; color:#d63384;"></i>
                                            </a>
                                            <!-- Eliminar -->
                                            <a href="#" data-id="<?= $venta['ID_Venta'] ?>" data-bs-toggle="modal" data-bs-target="#confirmar-delete" title="Eliminar">
                                                <i class="fas fa-trash-alt" style="font-size:25px; color:rgb(255,70,70)"></i>
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
                            <a href="#">Política de Privacidad</a> &middot; <a href="#">Términos y Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Confirmar Eliminación -->
    <div class="modal fade" id="confirmar-delete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">¿Estás seguro de que deseas eliminar esta venta?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script>
        new simpleDatatables.DataTable("#datatablesSimple");

        // Modal de eliminación
        var eliminarModal = document.getElementById('confirmar-delete');
        eliminarModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var idVenta = button.getAttribute('data-id');
            document.getElementById('btn-eliminar').setAttribute('href', 'controllers/eliminar_venta.php?id=' + idVenta);
        });
    </script>
</body>
</html>

