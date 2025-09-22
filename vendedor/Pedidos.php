<?php
include '../models/conexion.php'; // conexión centralizada ($conn)
session_start();

// Obtener lista de clientes
$sqlClientes = "SELECT ID_Cliente, Nombre FROM colfar.cliente";
$resultClientes = sqlsrv_query($conn, $sqlClientes);
if ($resultClientes === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Obtener lista de productos
$sqlProductos = "SELECT ID_Producto, Nombre FROM colfar.producto";
$resultProductos = sqlsrv_query($conn, $sqlProductos);
if ($resultProductos === false) {
    die(print_r(sqlsrv_errors(), true));
}

// REGISTRAR PEDIDO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCliente = $_POST['id_cliente'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];
    $total = $_POST['total_pedido'];
    $metodo = $_POST['metodo_pago'];
    $cantidad = $_POST['cantidad'];
    $idProducto = $_POST['id_producto'];
    $valorTotal = $_POST['valor_total'];

    $sqlInsert = "INSERT INTO colfar.pedido
                   (Fecha, ID_Cliente, Telefono, Direccion, Descripcion_pedido, total_pedido, Metodo_pago, Cantidad, ID_Producto, Valor_Total)
                   VALUES (GETDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $params = [$idCliente, $telefono, $direccion, $descripcion, $total, $metodo, $cantidad, $idProducto, $valorTotal];

    $stmt = sqlsrv_query($conn, $sqlInsert, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        header("Location: Pedidos.php"); // redirige a la misma página para evitar resubmits
        exit();
    }
}

// CONSULTAR PEDIDOS
// CONSULTAR PEDIDOS actualizado con Apellido y todos los campos extra
$sqlPedidos = "SELECT
                 p.ID_Pedido,
                 c.Nombre AS Cliente_Nombre,
                 p.Fecha,
                 pr.Nombre AS Producto,
                 p.Telefono,
                 p.Direccion,
                 p.Descripcion_pedido,
                 p.total_pedido,
                 p.Metodo_pago,
                 p.Cantidad,
                 p.Valor_Total
               FROM colfar.pedido p
               JOIN colfar.cliente c ON p.ID_Cliente = c.ID_Cliente
               JOIN colfar.producto pr ON p.ID_Producto = pr.ID_Producto";

$resultado = sqlsrv_query($conn, $sqlPedidos);
if ($resultado === false) {
    die(print_r(sqlsrv_errors(), true));
}


$resultado = sqlsrv_query($conn, $sqlPedidos);
if ($resultado === false) {
    die(print_r(sqlsrv_errors(), true));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (código para insertar el pedido)

    $stmt = sqlsrv_query($conn, $sqlInsert, $params);
    
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        // Obtener el ID del último pedido insertado
        $lastPedidoIdQuery = "SELECT SCOPE_IDENTITY() AS ID_Pedido";
        $result = sqlsrv_query($conn, $lastPedidoIdQuery);
        $lastPedidoId = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)['ID_Pedido'];

        // Insertar la factura
        $sqlFactura = "INSERT INTO colfar.factura (Fecha_Factura, ID_Venta) VALUES (GETDATE(), ?)";
        $stmtFactura = sqlsrv_query($conn, $sqlFactura, [$lastPedidoId]);

        if ($stmtFactura === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        // Redirigir
        header("Location: Pedidos.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/styles.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.css" rel="stylesheet" />
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="DashboardVendedor.php">VENDEDOR</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <p class="text-light">Usted ingresó como: <?php echo htmlspecialchars($_SESSION['Prime_Nombre']); ?></p>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                    <li><a class="dropdown-item" href="#!">Historial de Actividades</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
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
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="DashboardVendedor.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Pedidos
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="Pedidos.php">Pedidos</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                            aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Facturas
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Pedidos</h1>
                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModal">
                            Registrar Nuevo Pedido
                        </button>
                        <a href="../administradorphp/Reportes/DetallePed.php" class="btn btn-success">Generar Reporte</a>
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
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Descripción</th>
            <th>Total pedido</th>
            <th>Método pago</th>
            <th>Cantidad</th>
            <th>Valor total</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) { ?>
            <tr>
                <td><?= $row['ID_Pedido'] ?></td>
                <td><?= htmlspecialchars($row['Cliente_Nombre']) ?></td>
                <td><?= $row['Fecha']->format('Y-m-d') ?></td>
                <td><?= htmlspecialchars($row['Producto']) ?></td>
                <td><?= htmlspecialchars($row['Telefono']) ?></td>
                <td><?= htmlspecialchars($row['Direccion']) ?></td>
                <td><?= htmlspecialchars($row['Descripcion_pedido']) ?></td>
                <td><?= htmlspecialchars($row['total_pedido']) ?></td>
                <td><?= htmlspecialchars($row['Metodo_pago']) ?></td>
                <td><?= htmlspecialchars($row['Cantidad']) ?></td>
                <td><?= htmlspecialchars($row['Valor_Total']) ?></td>
                <td>
                    <a href="modificarcliente.php?id=<?= $row['ID_Pedido'] ?>">
                        <i class='fas fa-edit' style='font-size:24px; color:orange'></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <form action="" method="POST">
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="miModalLabel">REGISTRAR PEDIDO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
    <!-- Select Cliente -->
    <select class="form-control mb-2" name="id_cliente" required>
        <option value="" disabled selected>Seleccione Cliente</option>
        <?php
        sqlsrv_fetch($resultClientes, SQLSRV_SCROLL_ABSOLUTE, 0);
        while ($cliente = sqlsrv_fetch_array($resultClientes, SQLSRV_FETCH_ASSOC)) { ?>
            <option value="<?= $cliente['ID_Cliente'] ?>"><?= htmlspecialchars($cliente['Nombre']) ?></option>
        <?php } ?>
    </select>

    <input type="text" class="form-control mb-2" placeholder="Teléfono" name="telefono" required />
    <input type="text" class="form-control mb-2" placeholder="Dirección" name="direccion" required />
    <input type="text" class="form-control mb-2" placeholder="Descripción del Pedido" name="descripcion" required />
    <input type="number" class="form-control mb-2" placeholder="Total del Pedido" name="total_pedido" required />

    <!-- Select Método de Pago -->
    <select class="form-control mb-3" name="metodo_pago" required>
        <option value="" disabled selected>Seleccione Método de Pago</option>
        <option value="Efectivo">Efectivo</option>
        <option value="Nequi">Nequi</option>
        <option value="Daviplata">Daviplata</option>
    </select>

    <!-- Productos dinámicos -->
    <div id="productos-container">
        <div class="producto-item border rounded p-2 mb-2">
            <div class="row">
                <div class="col-md-5">
                    <label>Producto:</label>
                    <select class="form-control" name="id_producto[]" required>
                        <option value="" disabled selected>Seleccione Producto</option>
                        <?php
                        sqlsrv_fetch($resultProductos, SQLSRV_SCROLL_ABSOLUTE, 0);
                        while ($producto = sqlsrv_fetch_array($resultProductos, SQLSRV_FETCH_ASSOC)) { ?>
                            <option value="<?= $producto['ID_Producto'] ?>"><?= htmlspecialchars($producto['Nombre']) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Cantidad:</label>
                    <input type="number" name="cantidad[]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label>Valor Total:</label>
                    <input type="number" name="valor_total[]" class="form-control" required>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-producto">X</button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" id="add-producto" class="btn btn-secondary btn-sm">+ Agregar otro producto</button>
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Registrar</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>
                </div>
            </div>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#confirmar-delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var href = button.data('href');
            $('#btn-eliminar').attr('href', href);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="js/scripts.js"></script>


    <script>
    $(document).ready(function () {
        $('#add-producto').click(function () {
            let productoOriginal = $('.producto-item').first().clone();

            // Limpiar valores del clon
            productoOriginal.find('select, input').val('');

            $('#productos-container').append(productoOriginal);
        });

        $(document).on('click', '.remove-producto', function () {
            if ($('.producto-item').length > 1) {
                $(this).closest('.producto-item').remove();
            }
        });
    });
</script>

</body>

</html>
