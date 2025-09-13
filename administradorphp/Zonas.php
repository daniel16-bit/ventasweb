<?php
// Conexión a SQL Server
$serverName = "TU_SERVIDOR_SQL"; // Ej: localhost\SQLEXPRESS
$connectionOptions = [
    "Database" => "COLFAR",
    "Uid" => "tu_usuario",
    "PWD" => "tu_contraseña"
];

$conexion = sqlsrv_connect($serverName, $connectionOptions);

if (!$conexion) {
    die(print_r(sqlsrv_errors(), true));
}

// Consulta Zonas con SQL Server
$sql = "SELECT 
            Z.ID_Zona, 
            Z.NombreZona, 
            D.Nombre AS NombreDepartamento
        FROM ZONA Z
        JOIN DEPARTAMENTO D ON Z.ID_Departamento = D.ID_Departamento";

$result = sqlsrv_query($conexion, $sql);

$zonas = [];
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    // Convertir objetos datetime a string si es necesario
    $zonas[] = $row;
}

// Iniciar sesión
session_start();
if(!isset($_SESSION['Prime_Nombre'])){
    $_SESSION['Prime_Nombre'] = 'Invitado';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Zonas - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css" rel="stylesheet" />
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
    <ul class="navbar-nav ms-auto me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Ajustes</a></li>
                <li><a class="dropdown-item" href="#">Registro de actividades</a></li>
                <li><hr class="dropdown-divider"/></li>
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
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Panel</a>
                    <div class="sb-sidenav-menu-heading">Registros</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>Registros
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="Departamentos.php">Departamentos</a>
                            <a class="nav-link" href="Ciudades.php">Ciudades</a>
                            <a class="nav-link active" href="Zonas.php">Zonas</a>
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
            <h1>ZONAS</h1>
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#miModal">
                <i class="fas fa-plus"></i> Registrar Nueva Zona
            </button>
            <a href="Reportes/zonas_pdf.php" class="btn btn-success mb-3">Generar Reporte PDF</a>

            <!-- Modal Registrar Zona -->
            <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="controllers/registrar_zonas.php" method="POST" class="was-validated">
                            <div class="modal-header">
                                <h5 class="modal-title" id="miModalLabel">Registrar Zona</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nombreZona" class="form-label">Nombre de la Zona</label>
                                    <input type="text" class="form-control" id="nombreZona" name="nombreZona" required>
                                    <div class="invalid-feedback">Este campo es obligatorio</div>
                                </div>
                                <div class="mb-3">
                                    <label for="idDepartamento" class="form-label">Departamento</label>
                                    <select name="idDepartamento" id="idDepartamento" class="form-select" required>
                                        <option value="">Seleccione un Departamento</option>
                                        <?php
                                        $sqlDept = "SELECT ID_Departamento, Nombre FROM DEPARTAMENTO";
                                        $resultDept = sqlsrv_query($conexion, $sqlDept);
                                        while($dept = sqlsrv_fetch_array($resultDept, SQLSRV_FETCH_ASSOC)){
                                            echo "<option value='".$dept['ID_Departamento']."'>".htmlspecialchars($dept['Nombre'])."</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Seleccione un departamento</div>
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

            <!-- Tabla Zonas -->
            <div class="card shadow-sm rounded">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-table me-2"></i> Tabla Zonas
                </div>
                <div class="card-body p-0">
                    <table id="datatablesSimple" class="table table-striped table-hover table-bordered mb-0 text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Zona</th>
                                <th>Nombre Zona</th>
                                <th>Departamento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($zonas as $zona): ?>
                                <tr>
                                    <td><?php echo $zona['ID_Zona']; ?></td>
                                    <td><?php echo htmlspecialchars($zona['NombreZona']); ?></td>
                                    <td><?php echo htmlspecialchars($zona['NombreDepartamento']); ?></td>
                                    <td>
                                        <a href="./modificar/modificar_zona.php?id=<?php echo $zona['ID_Zona']; ?>" class="text-primary me-3" data-bs-toggle="tooltip" title="Editar">
                                            <i class="fas fa-edit fs-5"></i>
                                        </a>
                                        <a href="#" class="text-danger" data-href="controllers/eliminar_zona.php?id=<?php echo $zona['ID_Zona']; ?>" data-bs-toggle="modal" data-bs-target="#confirmar-delete" data-bs-toggle="tooltip" title="Eliminar">
                                            <i class="fas fa-trash-alt fs-5"></i>
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
                    <div class="text-muted">Copyright &copy; Your Website 2023</div>
                    <div>
                        <a href="#">Privacy Policy</a> &middot;
                        <a href="#">Terms &amp; Conditions</a>
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
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta zona?
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

<script>
    const dataTable = new simpleDatatables.DataTable("#datatablesSimple");

    var confirmarModal = document.getElementById('confirmar-delete');
    confirmarModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var href = button.getAttribute('data-href');
        var confirmBtn = confirmarModal.querySelector('#btn-eliminar');
        confirmBtn.setAttribute('href', href);
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

</body>
</html>

