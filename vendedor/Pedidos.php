<?php
include "../models/conexion.php";

// Filtrado de pedidos por nombre (si se envió el formulario de búsqueda)
$where = "";
if (!empty($_POST)) {
    $valor = $_POST['nom'];
    if (!empty($valor)) {
        $where = "WHERE nom LIKE '%$valor%'";
    }
}

// Consulta para obtener los pedidos
$sql = "SELECT * FROM PEDIDO $where";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="Dashboard.html">ADMINISTRACIÓN</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Buscar..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="pagina de inicio/index_1.html">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="DashboardVendedor.php"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Dashboard</a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"><div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>Pedidos<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="Pedidos.php">Pedidos</a></nav>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Pedidos</h1>
                    <div>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                            Registrar Nuevo Pedido
                        </button>
                        <a href="Reportes/DetallePed.php" class="btn btn-success">Generar Reporte</a>
                        
                    </div>
                    <div class="sb-sidenav-footer">
                        <div>Vendedor</div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-table me-1"></i>Tabla de Pedidos</div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Numero de pedido</th>
                                        <th>Cliente</th>
                                        <th>Fecha del pedido</th>
                                        <th>Producto</th>
                                        <th>Valor total del pedido</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($resultado->num_rows > 0) {
                                        while ($row = $resultado->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['ID_Pedido']; ?></td>
                                        <td><?php echo $row['ID_Cliente']; ?></td>
                                        <td><?php echo $row['Fecha']; ?></td>
                                        <td><?php echo $row['ID_Producto']; ?></td>
                                        <td><?php echo $row['Valor_Total']; ?></td>
                                        <td>
                                            <a href="modificarcliente.php?id=<?php echo $row['ID_Pedido']; ?>">
                                                <i class='fas fa-edit' style='font-size:36px; color:orange'></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="controllers/eliminarPed.php" data-href="controllers/eliminarPed.php?id=<?php echo $row['ID_Pedido']; ?>"
                                                data-bs-toggle="modal" data-bs-target="#confirmar-delete">
                                                <i class='fas fa-trash-alt' style='font-size:36px; color:red'></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal de Registro de Pedido -->
    <form action="controllers/ContPed.php" method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="miModalLabel">
                            <h2 class="text-center mb-4">REGISTRAR PEDIDO</h2>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="number" class="form-control" placeholder="Número de Pedido" name="id" required>
                        <br>
                        <input type="text" class="form-control" placeholder="Cliente" name="cli" required>
                        <br>
                        <input type="date" class="form-control" placeholder="Fecha" name="fecha" required>
                        <br>
                        <input type="text" class="form-control" placeholder="Producto" name="pro" required>
                        <br>
                        <input type="text" class="form-control" placeholder="Valor Total del Pedido" name="val" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="registrar">Registrar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal de confirmación de eliminación -->
    <div class="modal fade" id="confirmar-delete" tabindex="-1" role="dialog" aria-labelledby="confirmar-delete-label"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmar-delete-label">Confirmar eliminación</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este pedido?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        $('#confirmar-delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var href = button.data('href');
            $('#btn-eliminar').attr('href', href);
        });
    </script>
</body>
</html>
