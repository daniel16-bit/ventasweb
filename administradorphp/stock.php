<?php
include '../models/conexion.php'; // debe contener $conn

$sql = "SELECT ID_Producto, Nombre, Existencia, ValorProducto FROM colfar.producto";
$resultado = sqlsrv_query($conn, $sql);

if ($resultado === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Existencia</th>
            <th>Precio</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($p = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)): ?>
        <tr>
            <td><?= $p['ID_Producto'] ?></td>
            <td><?= $p['Nombre'] ?></td>
            <td><?= $p['Existencia'] ?></td>
            <td><?= $p['ValorProducto'] ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

