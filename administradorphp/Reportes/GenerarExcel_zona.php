<?php  
include "../models/conexion.php"; // Asegúrate de que la conexión sea SQL Server

$where = "";
if (!empty($_POST['nom'])) {
    $valor = $_POST['nom'];
    $where = "WHERE Z.NombreZona LIKE '%$valor%' OR D.Nombre LIKE '%$valor%'";
}

$sql = "SELECT 
    Z.ID_Zona, 
    Z.NombreZona, 
    D.Nombre AS NombreDepartamento
FROM 
    ZONA Z
JOIN 
    DEPARTAMENTO D ON Z.ID_Departamento = D.ID_Departamento
$where
ORDER BY Z.ID_Zona";

$resultado = sqlsrv_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Zonas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../css/styles.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
<style>
.botones-acciones { margin-bottom: 15px; }
</style>
</head>
<body>
<div class="container mt-4">

    <!-- Botones -->
    <div class="botones-acciones">
        <a href="../Zonas.php" class="btn btn-dark">Regresar</a>
        <a href="GenerarExcel_zonas.php" class="btn btn-success">Generar Excel</a>
        <a href="#" class="btn btn-warning" onclick="window.print()">Imprimir / PDF</a>
    </div>

    <!-- Tabla -->
    <div class="card mb-4">
        <div class="card-header"
