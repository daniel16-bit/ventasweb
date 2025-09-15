<?php 
include '../models/conexion.php'; // conexión con Azure SQL
session_start();

// Verificar sesión
if (!isset($_SESSION['Prime_Nombre'])) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT 
            c.ID_Compra,
            c.Fecha,
            c.Cantidad,
            p.Nombre AS Nombre_Producto,
            u.Prime_Nombre AS Nombre_Vendedor,
            u.Prime_Apellido AS Apellido_Vendedor
        FROM colfar.COMPRA c
        JOIN colfar.PRODUCTO p ON c.ID_Producto = p.ID_Producto
        JOIN colfar.VENTA v ON c.ID_Compra = v.ID_Venta
        JOIN colfar.VENDEDOR vd ON v.ID_Vendedor = vd.ID_Vendedor
        JOIN colfar.USUARIO u ON vd.ID_Usuario = u.ID_Usuario";

$stmt = sqlsrv_query($conn, $sql);

$compras = [];
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $compras[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Compras - Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css" rel="stylesheet" />
</head>
<body>
    <!-- Barra de navegación superior -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <div class="ms-auto me-3 my-2 my-md-0 text-light">
            Usted ingresó como: <?php echo htmlspecialchars($_SESSION['Prime_Nombre'] ?? 'Invitado'); ?>
        </div>
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Ajustes</a></li>
                    <li><a class="dropdown-item" href="#">Historial de Actividades</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../index.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Barra lateral -->
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

                    <!-- Otros -->
                    <div class="sb-sidenav-menu-heading">Reportes</div>
                    <a class="nav-link" href="Reportes.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-line"></i></div>
                        Reportes
                    </a>
                </div>
            </div>

            <div class="sb-sidenav-footer">
                <div class="small">Conectado como:</div>
                <?php echo htmlspecialchars($_SESSION['Prime_Nombre']); ?>
            </div>
        </nav>
    </div>

    <!-- Contenido Principal -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-4">
                <h1>Compras</h1>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#miModal">Registrar Nueva Compra</button>
                <a href="Reportes/compras_pdf.php" class="btn btn-success mb-3">Generar Reporte</a>

                <!-- Modal Registrar Compra -->
                <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="controllers/registrar_compras.php" method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="miModalLabel">Registrar Compra</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="fecha" class="form-label">Fecha</label>
                                        <input type="date" class="form-control" name="fecha" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cantidad" class="form-label">Cantidad</label>
                                        <input type="number" class="form-control" name="cantidad" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_producto" class="form-label">ID Producto</label>
                                        <input type="number" class="form-control" name="id_producto" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="id_proveedor" class="form-label">ID Proveedor</label>
                                        <input type="number" class="form-control" name="id_proveedor" required>
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

                <!-- Tabla de Compras -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Listado de Compras</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID Compra</th>
                                    <th>Fecha</th>
                                    <th>Cantidad</th>
                                    <th>Producto</th>
                                    <th>Vendedor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($compras as $compra): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($compra['ID_Compra']); ?></td>
                                        <td><?php echo htmlspecialchars($compra['Fecha']); ?></td>
                                        <td><?php echo htmlspecialchars($compra['Cantidad']); ?></td>
                                        <td><?php echo htmlspecialchars($compra['Nombre_Producto']); ?></td>
                                        <td><?php echo htmlspecialchars($compra['Nombre_Vendedor'] . ' ' . $compra['Apellido_Vendedor']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>


