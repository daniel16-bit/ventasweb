<?php
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=Ciudades.xls");

include "../models/conexion.php"; // Conexión a SQL Server

$where = "";
$params = array();

if (!empty($_POST['nom'])) {
    $where = "WHERE Nombre_ciudad LIKE ?";
    $params[] = "%" . $_POST['nom'] . "%";
}

// Consulta SQL Server
$sql = "SELECT * FROM CIUDAD $where";
$stmt = sqlsrv_query($conexion, $sql, $params);

if(!$stmt){
    die(print_r(sqlsrv_errors(), true));
}
?>

<html>
<head>
<meta charset="UTF-8">
<title>Exportar Ciudades</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre Ciudad</th>
                <th>Pais</th>
                <th>Codigo postal</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
            <tr>
                <td><?= $row['ID_Ciudad'] ?></td>
                <td><?= $row['Nombre_ciudad'] ?></td>
                <td><?= $row['Pais'] ?></td>
                <td><?= $row['Codigo_postal'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
