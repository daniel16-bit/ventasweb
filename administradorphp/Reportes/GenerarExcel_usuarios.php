<?php
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=Usuarios.xls");

include "../models/conexion.php";

$where = "";
if (!empty($_POST['nom'])) {
    $valor = $_POST['nom'];
    $where = "WHERE Prime_Nombre LIKE '%$valor%'";
}

$sql = "SELECT ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Telefono, Correo 
        FROM USUARIO $where";
$resultado = $conexion->query($sql);
?>

<table border="1">
    <thead>
        <tr>
            <th>ID_Usuario</th>
            <th>Primer Nombre</th>
            <th>Segundo Nombre</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
            <th>Teléfono</th>
            <th>Correo</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['ID_Usuario'] ?></td>
            <td><?= $row['Prime_Nombre'] ?></td>
            <td><?= $row['Segundo_Nombre'] ?></td>
            <td><?= $row['Prime_Apellido'] ?></td>
            <td><?= $row['Segundo_Apellido'] ?></td>
            <td><?= $row['Telefono'] ?></td>
            <td><?= $row['Correo'] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
