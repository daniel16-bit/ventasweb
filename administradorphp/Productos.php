<?php 
include '../models/conexion.php'; // conexión con Azure SQL
session_start();

// Verificar sesión
if (!isset($_SESSION['Prime_Nombre'])) {
    header("Location: ../index.php");
    exit();
}

// Consulta productos con su proveedor
$sql = "SELECT 
            P.ID_Producto, 
            P.Nombre AS Nombre_Producto, 
            P.ValorProducto, 
            P.ValorVenta, 
            PR.Nombe  AS Nombre_Proveedor, 
            P.Stock, 
            P.Existencia
        FROM colfar.PRODUCTO P
        JOIN colfar.PROVEEDOR PR ON P.ID_Proveedor = PR.ID_Proveedor";

$stmt = sqlsrv_query($conn, $sql);

$productos = [];
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $productos[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Productos - Admin</title>
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
        Bienvenido, <?= htmlspecialchars($_SESSION['Prime_Nombre']); ?>
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
                    <div class="sb-sidenav-menu-heading">Panel</div>
                    <a class="nav-link" href="Dashboard.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Panel
                    </a>

                    <div class="sb-sidenav-menu-heading">Registros</div>
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRegistros" aria-expanded="false" aria-controls="collapseRegistros">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Registros
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
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
                            <a class="nav-link active" href="Productos.php">Productos</a>
                            <a class="nav-link" href="Usuarios.php">Usuarios</a>
                            <a class="nav-link" href="Proveedores.php">Proveedores</a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Conectado como:</div>
                <?= htmlspecialchars($_SESSION['Prime_Nombre']); ?>
            </div>
        </nav>
    </div>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 mt-4">
                <h1 class="mt-4">Productos</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">COLFAR DE COLOMBIA S.A.S.</li>
                </ol>

                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-table me-1"></i>
                        Lista de Productos
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table table-bordered table-striped text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Valor Producto</th>
                                    <th>Valor Venta</th>
                                    <th>Proveedor</th>
                                    <th>Stock</th>
                                    <th>Existencia</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($productos)): ?>
                                    <?php foreach ($productos as $prod): ?>
                                        <tr>
                                            <td><?= $prod['ID_Producto'] ?></td>
                                            <td><?= htmlspecialchars($prod['Nombre_Producto']) ?></td>
                                            <td><?= $prod['ValorProducto'] ?></td>
                                            <td><?= $prod['ValorVenta'] ?></td>
                                            <td><?= htmlspecialchars($prod['Nombre_Proveedor']) ?></td>
                                            <td><?= $prod['Stock'] ?></td>
                                            <td><?= $prod['Existencia'] ?></td>
                                            <td>
    <a href="modificar/modificar_producto.php?id=<?= $prod['ID_Producto'] ?>" 
       class="btn btn-primary btn-sm me-1"
       title="Editar">
       <i class="fas fa-edit"></i>
    </a>
    <a href="controllers/eliminar_producto.php?id=<?= $prod['ID_Producto'] ?>" 
       class="btn btn-danger btn-sm"
       onclick="return confirm('¿Estás seguro de eliminar este producto?')"
       title="Eliminar">
       <i class="fas fa-trash-alt"></i>
    </a>
</td>

                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="8" class="text-center">No hay productos registrados.</td></tr>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>

<script>
    const dataTable = new simpleDatatables.DataTable("#datatablesSimple");
</script>

</body>
</html>