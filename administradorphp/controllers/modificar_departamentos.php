<?php
// Incluir la conexión con SQLSRV
include_once '../models/conexion.php';

if (isset($_POST['modificar'])) {
    $idDepartamento = $_POST['id'] ?? null;
    $nombreDepartamento = $_POST['nombre'] ?? null;

    if (!empty($idDepartamento) && !empty($nombreDepartamento)) {
        // Sentencia con parámetros
        $sql = "UPDATE colfar.DEPARTAMENTO SET Nombre = ? WHERE ID_Departamento = ?";
        $params = array($nombreDepartamento, $idDepartamento);

        // Ejecutar consulta
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            // Mostrar errores de SQL Server
            echo '<div class="alert alert-danger">Error al actualizar el departamento: ';
            print_r(sqlsrv_errors(), true);
            echo '</div>';
        } else {
            // Redirigir después de la actualización
            header("Location: ../Departamentos.php");
            exit;
        }
    } else {
        echo '<div class="alert alert-warning">El nombre del departamento es obligatorio.</div>';
    }
}
?>


