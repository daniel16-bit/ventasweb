<?php
session_start();
include '../models/conexion.php'; // Asegúrate de tener la conexión PDO correcta



$sql = "SELECT * FROM colfar.CIUDAD";
$stmt = sqlsrv_query($conn, $sql);

// Verificar si la consulta fue exitosa
$ciudades = [];
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true)); // Si la consulta falla, muestra el error
} else {
    // Si la consulta fue exitosa, guardar los resultados en el array $ciudades
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $ciudades[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Ciudades - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css" rel="stylesheet" />
</head>
<body>
<!-- Barra superior -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRACIÓN</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <div class="ms-auto me-3">
        <p class="text-light mb-0">Usted ingresó como: <?php echo htmlspecialchars($_SESSION['Prime_Nombre'] ?? 'Invitado'); ?></p>
    </div>
    <ul class="navbar-nav ms-auto me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                </div>
            </div>
        </nav>
    </div>

    <!-- Contenido principal -->
    <div id="layoutSidenav_content">
        <main class="container-fluid px-4 mt-4">
            <h1>CIUDADES</h1>
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#miModal">
                <i class="fas fa-plus"></i> Registrar Ciudad nueva
            </button>
            <a href="Reportes/Ciudades_pdf.php" class="btn btn-success mb-3">Generar Reporte PDF</a>

            <!-- Modal Registrar Ciudad -->
            <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="controllers/registrar_ciudad.php" method="post" class="was-validated">
                            <div class="modal-header">
                                <h5 class="modal-title" id="miModalLabel">Registrar Ciudad</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Ciudad" required>
                                    <div class="invalid-feedback">Este campo es obligatorio</div>
                                </div>
                                <div class="mb-3">
                                    <label for="pais" class="form-label">País</label>
                                    <input type="text" class="form-control" id="pais" name="pais" placeholder="País" required>
                                    <div class="invalid-feedback">Este campo es obligatorio</div>
                                </div>
                                <div class="mb-3">
                                    <label for="codigo_postal" class="form-label">Código Postal</label>
                                    <input type="number" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="Código Postal" required>
                                    <div class="invalid-feedback">Este campo es obligatorio</div>
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

            <!-- Tabla Ciudades -->
            <div class="card shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-table me-2"></i> Tabla Ciudades
                </div>
                <div class="card-body p-0">
                    <table id="datatablesSimple" class="table table-striped table-hover table-bordered mb-0 text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Ciudad</th>
                                <th>Nombre Ciudad</th>
                                <th>País</th>
                                <th>Código Postal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ciudades as $ciudad): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ciudad['ID_Ciudad']); ?></td>
                                    <td><?php echo htmlspecialchars($ciudad['Nombre_ciudad']); ?></td>
                                    <td><?php echo htmlspecialchars($ciudad['Pais']); ?></td>
                                    <td><?php echo htmlspecialchars($ciudad['Codigo_postal']); ?></td>
                                    <td>
                                        <a href="modificar/modificar_ciudad.php?id=<?php echo $ciudad['ID_Ciudad']; ?>" class="btn btn-primary btn-sm me-1" title="Editar"><i class="fas fa-edit"></i>
                                                </a>
                                        <a href="controllers/eliminar_ciudad.php?id=<?php echo $ciudad['ID_Ciudad']; ?>"  class="btn btn-danger btn-sm"
                                                   onclick="return confirm('¿Estás seguro de eliminar esta ciudad?')"
                                                   title="Eliminar">
                                                   <i class="fas fa-trash-alt"></i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/simple-datatables.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>
