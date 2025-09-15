<?php
// Incluimos el archivo que define $conn
include "../models/conexion.php";

// Preparamos el filtro si se recibe
$where = "";
$params = [];

if (!empty($_POST['nom'])) {
    $valor = $_POST['nom'];
    $where = "WHERE Z.NombreZona LIKE ? OR D.Nombre LIKE ?";
    $valorParam = "%$valor%";
    $params = [$valorParam, $valorParam];
}

// Consulta SQL con filtro dinámico
$sql = "SELECT 
    Z.ID_Zona, 
    Z.NombreZona, 
    D.Nombre AS NombreDepartamento
FROM colfar.ZONA Z
JOIN colfar.DEPARTAMENTO D ON Z.ID_Departamento = D.ID_Departamento
$where
ORDER BY Z.ID_Zona";

// ✅ USAMOS $conn aquí (NO $conexion)
$stmt = sqlsrv_query($conn, $sql, $params);

// Verificamos si hubo error
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Enviar headers para Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=zonas.xls");
?>

<!-- Tabla de datos -->
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre Zona</th>
            <th>Nombre Departamento</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['ID_Zona']) . "</td>";
            echo "<td>" . htmlspecialchars($row['NombreZona']) . "</td>";
            echo "<td>" . htmlspecialchars($row['NombreDepartamento']) . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

