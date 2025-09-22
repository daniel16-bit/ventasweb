<?php
include '../models/conexion.php'; // Conexión con SQL Server
session_start();

// Consulta zonas con su departamento
$sql = "SELECT Z.ID_Zona, Z.NombreZona, D.Nombre AS NombreDepartamento
        FROM colfar.ZONA Z
        JOIN colfar.DEPARTAMENTO D ON Z.ID_Departamento = D.ID_Departamento";

$stmt = sqlsrv_query($conn, $sql);

$zonas = [];
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $zonas[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Zonas - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
<!-- Navbar superior -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRADOR</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <div class="ms-auto me-3 my-2 my-md-0 text-light">
        <p class="text-light mb-0">Usted ingresó como: <?php echo htmlspecialchars($_SESSION['Prime_Nombre'] ?? 'Invitado'); ?></p>
    </div>
    <ul class="navbar-nav ms-auto me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Ajustes</a></li>
                <li><a class="dropdown-item" href="#">Historial de Actividades</a></li>
                <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar sesión</a></li>
            </ul>
        </li>
    </ul>
</nav>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav">    <!-- Barra lateral -->
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Panel</div><!-- Panel -->
                    <a class="nav-link" href="Dashboard.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Panel</a>

                    <!-- Registros -->
                    <div class="sb-sidenav-menu-heading">Registros</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRegistros" aria-expanded="false" aria-controls="collapseRegistros">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Registros<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseRegistros" data-bs-parent="#sidenavAccordion">
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

                     <!-- Facturas -->*
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

    <div id="layoutSidenav_content"><!-- Contenido principal -->
        <main>
            <div class="container-fluid px-4 mt-4">
                <h1 class="mt-4">Zonas</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">COLFAR DE COLOMBIA S.A.S.</li></ol>
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#miModal"><i class="fas fa-plus"></i>Registrar Nueva Zona </button>
                    <a href="Reportes/zonas_pdf.php" class="btn btn-primary mb-3">Generar Reporte</a>
                    <!-- Modal Registrar -->
                    <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="miModalLabel">Registrar Zona</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="controllers/registrar_zonas.php" method="POST">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nombreZona" class="form-label">Nombre de la Zona</label>
                                                <input type="text" class="form-control" id="nombreZona" name="nombreZona" required>
                                                <div class="invalid-feedback">Este campo es obligatorio</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nombreDepartamento" class="form-label">Nombre del Departamento</label>
                                                <input type="text" class="form-control" id="nombreDepartamento" name="nombre_departamento" required>
                                                <div class="invalid-feedback">Este campo es obligatorio</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Registrar</button>
                                            </div>
                                        </div> 
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tabla Ciudades -->
                <div class="card shadow-sm rounded mb-4">
                    <div class="card-header bg-primary text-white"><i class="fas fa-table me-2"></i>Lista de Zonas</div>
                     <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-dark text-center align-middle">

                                <tr>
                                    <th>ID Zona</th>
                                    <th>Nombre Zona</th>
                                    <th>Departamento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($zonas)): ?>
                                    <?php foreach ($zonas as $zona): ?>
                                        <tr>
                                            <td><?= $zona['ID_Zona'] ?></td>
                                            <td><?= htmlspecialchars($zona['NombreZona']) ?></td>
                                            <td><?= htmlspecialchars($zona['NombreDepartamento']) ?></td>
                                            <td>
                                                <a href="modificar/modificar_zona.php?id=<?= $zona['ID_Zona'] ?>" class="btn btn-primary btn-sm me-1" title="Editar"><i class="fas fa-edit"></i></a>
                                                <a href="#" data-href="controllers/eliminar_zona.php?id=<?= $zona['ID_Zona'] ?>"data-bs-toggle="modal"data-bs-target="#confirmar-delete"class="btn btn-danger btn-sm"title="Eliminar"><i class="fas fa-trash-alt"></i></a>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center">No hay zonas registradas.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4 d-flex justify-content-between">
                <div class="text-muted">&copy; 2023 COLFAR DE COLOMBIA S.A.S.</div>
                <div>
                    <a href="#">Política de Privacidad</a> &middot;
                    <a href="#">Términos y Condiciones</a>
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
               <div class="modal-body">¿Seguro que deseas eliminar esta zona?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
<script src="js/scripts.js"></script>
<script src="js/datatables-simple-demo.js"></script>

<script>
    const dataTable = new simpleDatatables.DataTable("#datatablesSimple");
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var confirmarModal = document.getElementById('confirmar-delete');
  if (!confirmarModal) return;

  confirmarModal.addEventListener('show.bs.modal', function (event) {
    // button que disparó el modal
    var trigger = event.relatedTarget;
    console.log('trigger:', trigger);
    if (!trigger) return;

    // obtener enlace desde data-href
    var url = trigger.getAttribute('data-href') || trigger.dataset.href;
    console.log('data-href encontrado:', url);

    // asignar al botón del modal
    var btnEliminar = confirmarModal.querySelector('#btn-eliminar');
    if (btnEliminar) {
      btnEliminar.setAttribute('href', url);
      console.log('btn-eliminar href seteado a:', btnEliminar.getAttribute('href'));
    }
  });
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dataTable = new simpleDatatables.DataTable("#datatablesSimple", {
            perPage: 10,
            perPageSelect: [5, 10, 25, 50, -1], // -1 = "Todos"
            labels: {
                placeholder: "Buscar...",
                perPage: "Mostrar {select} registros por página",
                noRows: "No hay zonas disponibles",
                info: "Mostrando {start} a {end} de {rows} registros"
            }
        });
    });
</script>


</body>
</html>
