<?php
include '../models/conexion.php'; // conexión centralizada ($conn)
session_start();

// REGISTRAR PEDIDO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCliente   = $_POST['id_cliente'];
    $telefono    = $_POST['telefono'];
    $direccion   = $_POST['direccion'];
    $descripcion = $_POST['descripcion'];
    $total       = $_POST['total_pedido'];
    $metodo      = $_POST['metodo_pago'];
    $cantidad    = $_POST['cantidad'];
    $idProducto  = $_POST['id_producto'];
    $valorTotal  = $_POST['valor_total'];

    $sqlInsert = "INSERT INTO colfar.pedido 
                  (Fecha, ID_Cliente, Telefono, Direccion, Descripcion_pedido, total_pedido, Metodo_pago, Cantidad, ID_Producto, Valor_Total) 
                  VALUES (GETDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $params = [$idCliente, $telefono, $direccion, $descripcion, $total, $metodo, $cantidad, $idProducto, $valorTotal];

    $stmt = sqlsrv_query($conn, $sqlInsert, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "<div class='alert alert-success'>✅ Pedido registrado correctamente.</div>";
    }
}

// CONSULTAR PEDIDOS
$sqlPedidos = "SELECT 
                p.ID_Pedido,
                c.Nombre AS Cliente,
                p.Fecha,
                pr.Nombre AS Producto,
                p.Valor_Total
               FROM colfar.pedido p
               JOIN colfar.cliente c ON p.ID_Cliente = c.ID_Cliente
               JOIN colfar.producto pr ON p.ID_Producto = pr.ID_Producto";

$resultado = sqlsrv_query($conn, $sqlPedidos);
if ($resultado === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
</head>
<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="Dashboard.html">ADMINISTRACIÓN</a>
        <div class="ms-auto me-3 my-2 my-md-0">
            <p class="text-light">Usted ingresó como: <?php echo $_SESSION['Prime_Nombre']; ?></p>
        </div>
    </nav>

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
                            <th>Valor total del pedido</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) { ?>
                            <tr>
                                <td><?= $row['ID_Pedido'] ?></td>
                                <td><?= $row['Cliente'] ?></td>
                                <td><?= $row['Fecha']->format('Y-m-d') ?></td>
                                <td><?= $row['Producto'] ?></td>
                                <td><?= $row['Valor_Total'] ?></td>
                                <td>
                                    <a href="modificarcliente.php?id=<?= $row['ID_Pedido'] ?>">
                                        <i class='fas fa-edit' style='font-size:24px; color:orange'></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" data-href="../administradorphp/controllers/eliminarPed.php?id=<?= $row['ID_Pedido'] ?>" data-bs-toggle="modal" data-bs-target="#confirmar-delete">
                                        <i class='fas fa-trash-alt' style='font-size:24px; color:red'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal registrar pedido -->
    <form action="" method="POST">
        <div class="modal fade" id="miModal" tabindex="-1" aria-labelledby="miModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="miModalLabel">REGISTRAR PEDIDO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="number" class="form-control mb-2" placeholder="ID Cliente" name="id_cliente" required>
                        <input type="text" class="form-control mb-2" placeholder="Teléfono" name="telefono" required>
                        <input type="text" class="form-control mb-2" placeholder="Dirección" name="direccion" required>
                        <input type="text" class="form-control mb-2" placeholder="Descripción del Pedido" name="descripcion" required>
                        <input type="number" class="form-control mb-2" placeholder="Total del Pedido" name="total_pedido" required>
                        <input type="text" class="form-control mb-2" placeholder="Método de Pago" name="metodo_pago" required>
                        <input type="number" class="form-control mb-2" placeholder="Cantidad" name="cantidad" required>
                        <input type="number" class="form-control mb-2" placeholder="ID Producto" name="id_producto" required>
                        <input type="number" class="form-control mb-2" placeholder="Valor Total" name="valor_total" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal eliminar -->
    <div class="modal fade" id="confirmar-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">¿Estás seguro de que deseas eliminar este pedido?</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="btn-eliminar" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#confirmar-delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var href = button.data('href');
            $('#btn-eliminar').attr('href', href);
        });
    </script>
</body>
</html>

