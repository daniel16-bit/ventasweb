<?php
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=Departamentos.xls");

include "../models/conexion.php"; // Conexión a SQL Server

$where = "";
$params = array();

if (!empty($_POST['nom'])) {
    $where = "WHERE Nombre LIKE ?";
    $params[] = "%" . $_POST['nom'] . "%";
}

// Consulta SQL Server
$sql = "SELECT ID_Departamento, Nombre FROM colfar.DEPARTAMENTO $where";
$stmt = sqlsrv_query($conn, $sql, $params);
if(!$stmt){
    die(print_r(sqlsrv_errors(), true));
}
?>

<html>
<head>
<meta charset="UTF-8">
<title>Exportar Departamentos</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Departamento</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
            <tr>
                <td><?= $row['ID_Departamento'] ?></td>
                <td><?= $row['Nombre'] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
