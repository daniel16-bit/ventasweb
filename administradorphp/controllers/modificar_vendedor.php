<?php
include_once '../models/conexion.php'; // conexión con PDO

if (isset($_POST['modificar']) && $_POST['modificar'] == 'ok') {
    // Obtener datos
    $id_vendedor     = $_POST['id'] ?? null;
    $nombre_completo = $_POST['nombre_completo'] ?? null;
    $zona            = $_POST['zona'] ?? null;

    if ($id_vendedor && $nombre_completo && $zona) {
        try {
            // Separar el nombre completo
            $nombres           = explode(' ', $nombre_completo);
            $primer_nombre     = $nombres[0] ?? '';
            $segundo_nombre    = $nombres[1] ?? '';
            $apellido          = $nombres[count($nombres) - 2] ?? '';
            $segundo_apellido  = $nombres[count($nombres) - 1] ?? '';

            // Consulta con parámetros
            $sql = "UPDATE USUARIO 
                    SET Prime_Nombre = ?, 
                        Segundo_Nombre = ?, 
                        Prime_Apellido = ?, 
                        Segundo_Apellido = ?
                    WHERE ID_Usuario = (
                        SELECT ID_Usuario FROM VENDEDOR WHERE ID_Vendedor = ?
                    ); 
                    
                    UPDATE ZONA 
                    SET NombreZona = ?
                    WHERE ID_Zona = (
                        SELECT ID_Zona FROM VENDEDOR WHERE ID_Vendedor = ?
                    );";

            // Preparar y ejecutar (PDO ejecuta solo una sentencia a la vez)
            $stmt1 = $conexion->prepare("UPDATE USUARIO 
                                         SET Prime_Nombre = ?, Segundo_Nombre = ?, Prime_Apellido = ?, Segundo_Apellido = ?
                                         WHERE ID_Usuario = (SELECT ID_Usuario FROM VENDEDOR WHERE ID_Vendedor = ?)");
            $stmt1->execute([$primer_nombre, $segundo_nombre, $apellido, $segundo_apellido, $id_vendedor]);

            $stmt2 = $conexion->prepare("UPDATE ZONA 
                                         SET NombreZona = ?
                                         WHERE ID_Zona = (SELECT ID_Zona FROM VENDEDOR WHERE ID_Vendedor = ?)");
            $stmt2->execute([$zona, $id_vendedor]);

            // Redirigir si todo va bien
            header("Location: ../Vendedores.php");
            exit();

        } catch (PDOException $e) {
            echo "Error al actualizar el vendedor: " . $e->getMessage();
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>

