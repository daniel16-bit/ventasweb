<?php
include '../models/conexion.php'; // Debe definir $conn (usando sqlsrv_connect)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Recoger los datos del formulario
        $nombreZona = $_POST['nombreZona'];
        $nombre_departamento = $_POST['nombre_departamento'];

        // Verificar si el departamento ya existe
        $sql = "SELECT ID_Departamento FROM colfar.DEPARTAMENTO WHERE Nombre = ?";
        $params = [$nombre_departamento];
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $id_departamento = $row['ID_Departamento'] ?? null;

        // Si el departamento no existe, crearlo
        if (!$id_departamento) {
            $sql_insert_departamento = "INSERT INTO colfar.DEPARTAMENTO (Nombre) VALUES (?);";
            $params = [$nombre_departamento];
            $stmt_insert_departamento = sqlsrv_query($conn, $sql_insert_departamento, $params);

            if ($stmt_insert_departamento === false) {
                throw new Exception(print_r(sqlsrv_errors(), true));
            }

            // Obtener el nuevo ID insertado
            $stmt_identity = sqlsrv_query($conn, "SELECT SCOPE_IDENTITY() AS ID");
            if ($stmt_identity === false) {
                throw new Exception(print_r(sqlsrv_errors(), true));
            }

            $row_identity = sqlsrv_fetch_array($stmt_identity, SQLSRV_FETCH_ASSOC);
            $id_departamento = $row_identity['ID'];
        }

        // Insertar la zona
        $sql_insert_zona = "INSERT INTO colfar.ZONA (NombreZona, ID_Departamento) VALUES (?, ?)";
        $params = [$nombreZona, $id_departamento];
        $stmt_insert_zona = sqlsrv_query($conn, $sql_insert_zona, $params);

        if ($stmt_insert_zona === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        // Redirigir
        header("Location: ../Zonas.php");
        exit();

    } catch (Exception $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
}
?>






