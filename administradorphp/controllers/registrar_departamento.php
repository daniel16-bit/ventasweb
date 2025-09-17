<?php
include "../models/conexion.php"; // Aquí $conn con sqlsrv_connect()

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreDepartamento = $_POST['nombreDepartamento'] ?? '';

    if (!empty($nombreDepartamento)) {
        $sql = "INSERT INTO colfar.DEPARTAMENTO (Nombre) VALUES (?)";
        $params = array($nombreDepartamento);

        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die("Error al registrar el departamento: " . print_r(sqlsrv_errors(), true));
        } else {
            // Redirigir al listado
            header("Location: ../Departamentos.php");
            exit();
        }

        sqlsrv_free_stmt($stmt);
    } else {
        echo "El nombre del departamento es obligatorio.";
    }

    sqlsrv_close($conn);
} else {
    echo "Método de solicitud no válido.";
}
?>

