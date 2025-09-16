<?php
include_once '../models/conexion.php'; // conexión con sqlsrv

if (isset($_POST['modificar']) && $_POST['modificar'] == 'ok') {
    // Obtener datos
    $id_vendedor     = $_POST['id'] ?? null;
    $nombre_completo = $_POST['nombre_completo'] ?? null;
    $zona            = $_POST['zona'] ?? null;

    if ($id_vendedor && $nombre_completo && $zona) {
        try {
            // Separar el nombre completo
            $nombres          = explode(' ', trim($nombre_completo));
            $primer_nombre    = $nombres[0] ?? '';
            $segundo_nombre   = $nombres[1] ?? '';
            $apellido         = $nombres[count($nombres) - 2] ?? '';
            $segundo_apellido = $nombres[count($nombres) - 1] ?? '';

            // 1. Actualizar datos en USUARIO
            $sql1 = "UPDATE colfar.USUARIO
                     SET Prime_Nombre = ?, 
                         Segundo_Nombre = ?, 
                         Prime_Apellido = ?, 
                         Segundo_Apellido = ?
                     WHERE ID_Usuario = (
                         SELECT ID_Usuario FROM colfar.VENDEDOR WHERE ID_Vendedor = ?
                     )";

            $params1 = [$primer_nombre, $segundo_nombre, $apellido, $segundo_apellido, $id_vendedor];
            $stmt1 = sqlsrv_query($conn, $sql1, $params1);

            if ($stmt1 === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            // 2. Actualizar datos en ZONA
            $sql2 = "UPDATE colfar.ZONA
                     SET NombreZona = ?
                     WHERE ID_Zona = (
                         SELECT ID_Zona FROM COLFAR.VENDEDOR WHERE ID_Vendedor = ?
                     )";

            $params2 = [$zona, $id_vendedor];
            $stmt2 = sqlsrv_query($conn, $sql2, $params2);

            if ($stmt2 === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            // Redirigir si todo va bien
            header("Location: ../Vendedores.php");
            exit();

        } catch (Exception $e) {
            echo "Error al actualizar el vendedor: " . $e->getMessage();
        }
    } else {
        echo "⚠️ Todos los campos son obligatorios.";
    }
}
?>


