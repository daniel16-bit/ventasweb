<?php
session_start();

// Validar sesión
if(!isset($_SESSION['Prime_Nombre'])){
    header("Location: ../index.php"); // Redirige si no hay sesión
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Panel Administrador</title>
    <!-- Estilos -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">

<!-- Navbar superior -->
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="Dashboard.php">ADMINISTRADOR</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <div class="ms-auto me-3 my-2 my-md-0 text-light">
        Bienvenido, <?php echo htmlspecialchars($_SESSION['Prime_Nombre']); ?>
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
                <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar sesión</a></li>
            </ul>
        </li>
    </ul>
</nav>

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
                        <a class="nav-link" href="factura.php">Recibidas</a>
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
    </nav>
</div>


    <!-- Contenido principal -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-4">
                <h1 class="mt-4">Panel de Administración</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">COLFAR DE COLOMBIA S.A.S.</li>
                </ol>

                <!-- Tarjetas rápidas -->
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-light text-dark mb-4">
                            <div class="card-body">Inventario</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-dark stretched-link" href="Productos.php">Ver Detalles</a>
                                <div><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-light text-dark mb-4">
                            <div class="card-body">Ventas</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-dark stretched-link" href="Ventas.php">Ver Detalles</a>
                                <div><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-light text-dark mb-4">
                            <div class="card-body">Proveedores</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-dark stretched-link" href="Proveedores.php">Ver Detalles</a>
                                <div><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-light text-dark mb-4">
                            <div class="card-body">Usuarios</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-dark stretched-link" href="Usuarios.php">Ver Detalles</a>
                                <div><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Gráfico Área
                            </div>
                            <div class="card-body">
                                <canvas id="myAreaChart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Gráfico Barras
                            </div>
                            <div class="card-body">
                                <canvas id="myBarChart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de ejemplo -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabla de ejemplo
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Posición</th>
                                    <th>Oficina</th>
                                    <th>Edad</th>
                                    <th>Fecha inicio</th>
                                    <th>Salario</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>
                                    <td>2011/04/25</td>
                                    <td>$320,800</td>
                                </tr>
                                <tr>
                                    <td>Garrett Winters</td>
                                    <td>Accountant</td>
                                    <td>Tokyo</td>
                                    <td>63</td>
                                    <td>2011/07/25</td>
                                    <td>$170,750</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>

        <!-- Footer -->
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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
<script>
    // Inicializar DataTables
    const dataTable = new simpleDatatables.DataTable("#datatablesSimple");

    // Datos ejemplo gráficos
    const ctxArea = document.getElementById("myAreaChart").getContext("2d");
    const myAreaChart = new Chart(ctxArea, {
        type: 'line',
        data: {
            labels: ["Enero","Febrero","Marzo","Abril","Mayo","Junio"],
            datasets: [{
                label: "Ventas",
                data: [100, 200, 150, 300, 250, 400],
                backgroundColor: "rgba(78, 115, 223, 0.2)",
                borderColor: "rgba(78, 115, 223, 1)",
                borderWidth: 2
            }]
        }
    });

    const ctxBar = document.getElementById("myBarChart").getContext("2d");
    const myBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ["Productos A","Productos B","Productos C","Productos D"],
            datasets: [{
                label: "Inventario",
                data: [50, 75, 150, 100],
                backgroundColor: "rgba(28, 200, 138, 0.7)",
                borderColor: "rgba(28, 200, 138, 1)",
                borderWidth: 1
            }]
        }
    });
</script>

</body>
</html>

