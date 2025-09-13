<?php
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=Ventas.xls");

include "../models/conexion.php";

$where = "";
if (!empty($_POST['nom'])) {
    $valor = $_POST['nom'];
    $where = "WHERE C.Nombre LIKE '%$valor%' OR U.Prime_Nombre LIKE '%$valor%'";
}

$sql = "SELECT 
    V.ID_Venta,
    V.Fecha,
    V.Descuentos,
    V.Total,
    CONCAT(U.Prime_Nombre, ' ', U.Prime_Apellido) AS Nombre_Vendedor,
    Z.NombreZona AS Nombre_Zona,
    D.Nombre AS Nombre_Departamento,
    P.Nombre AS Nombre_Producto
FROM VENTA V
INNER JOIN CLIENTE C ON V.ID_Cliente = C.ID_Cliente
INNER JOIN VENDEDOR VE ON V.ID_Vendedor = VE.ID_Vendedor
INNER JOIN USUARIO U ON VE.ID_Usuario = U.ID_Usuario
INNER JOIN ZONA Z ON V.ID_Zona = Z.ID_Zona
INNER JOIN DEPARTAMENTO D ON V.ID_Departamento = D.ID_Departamento
INNER JOIN PRODUCTO P ON V.ID_Producto = P.ID_Producto
$where";

$resultado = $conexion->query($sql);
?>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Descuentos</th>
            <th>Total</th>
            <th>Vendedor</th>
            <th>Zona</th>
            <th>Departamento</th>
            <th>Producto</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['ID_Venta'] ?></td>
            <td><?= $row['Fecha'] ?></td>
            <td><?= $row['Descuentos'] ?></td>
            <td><?= $row['Total'] ?></td>
            <td><?= $row['Nombre_Vendedor'] ?></td>
            <td><?= $row['Nombre_Zona'] ?></td>
            <td><?= $row['Nombre_Departamento'] ?></td>
            <td><?= $row['Nombre_Producto'] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
