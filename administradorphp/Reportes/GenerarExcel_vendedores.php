<?php
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=Vendedores.xls");

include "../models/conexion.php";

$where = "";
if (!empty($_POST['nom'])) {
    $valor = $_POST['nom'];
    $where = "WHERE U.Prime_Nombre LIKE '%$valor%' OR U.Prime_Apellido LIKE '%$valor%'";
}

$sql = "SELECT 
    VE.ID_Vendedor, 
    U.Prime_Nombre AS Nombre_Vendedor, 
    U.Segundo_Nombre AS Segundo_Nombre_Vendedor, 
    U.Prime_Apellido AS Apellido_Vendedor, 
    U.Segundo_Apellido AS Segundo_Apellido_Vendedor,
    Z.NombreZona AS Zona
FROM colfar.VENDEDOR VE
JOIN colfar.USUARIO U ON VE.ID_Usuario = U.ID_Usuario
JOIN colfar.ZONA Z ON VE.ID_Zona = Z.ID_Zona
$where";

$resultado = $conn->query($sql);
?>

<table border="1">
    <thead>
        <tr>
            <th>ID_Vendedor</th>
            <th>Primer Nombre</th>
            <th>Segundo Nombre</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
            <th>Zona</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['ID_Vendedor'] ?></td>
            <td><?= $row['Nombre_Vendedor'] ?></td>
            <td><?= $row['Segundo_Nombre_Vendedor'] ?></td>
            <td><?= $row['Apellido_Vendedor'] ?></td>
            <td><?= $row['Segundo_Apellido_Vendedor'] ?></td>
            <td><?= $row['Zona'] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
