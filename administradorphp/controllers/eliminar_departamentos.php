<?php
include "../models/conexion.php"; // Aquí $conn viene de sqlsrv_connect

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $sql = "DELETE FROM colfar.DEPARTAMENTO WHERE ID_Departamento = ?";
    $params = [$id];

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt) {
        header("Location: ../Departamentos.php");
        exit;
    } else {
        echo '<div class="alert alert-danger">❌ Error al eliminar el Departamento.</div>';
        die(print_r(sqlsrv_errors(), true)); // muestra el error exacto
    }
} else {
    echo '<div class="alert alert-warning">⚠️ No se ha especificado un Departamento válido para eliminar.</div>';
}
?>


