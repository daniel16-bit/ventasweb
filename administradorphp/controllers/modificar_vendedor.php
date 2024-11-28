<?php
include_once '../models/conexion.php';

if (isset($_POST['modificar']) && $_POST['modificar'] == 'ok') {
    // Obtener los datos del formulario
    $id_vendedor = $_POST['id'];
    $nombre_completo = $_POST['nombre_completo'];
    $zona = $_POST['zona'];

    // Separar el nombre completo en sus partes
    $nombres = explode(' ', $nombre_completo);
    $primer_nombre = $nombres[0];
    $segundo_nombre = isset($nombres[1]) ? $nombres[1] : ''; // Maneja si no hay segundo nombre
    $apellido = isset($nombres[count($nombres) - 2]) ? $nombres[count($nombres) - 2] : ''; // El penúltimo es el apellido
    $segundo_apellido = isset($nombres[count($nombres) - 1]) ? $nombres[count($nombres) - 1] : ''; // El último es el segundo apellido

    // Consulta para actualizar los datos del vendedor
    $sql = "UPDATE USUARIO 
            JOIN VENDEDOR VE ON VE.ID_Usuario = USUARIO.ID_Usuario
            JOIN ZONA Z ON VE.ID_Zona = Z.ID_Zona
            SET USUARIO.Prime_Nombre = '$primer_nombre',
                USUARIO.Segundo_Nombre = '$segundo_nombre',
                USUARIO.Prime_Apellido = '$apellido',
                USUARIO.Segundo_Apellido = '$segundo_apellido',
                Z.NombreZona = '$zona'
            WHERE VE.ID_Vendedor = '$id_vendedor'";

    if ($conexion->query($sql)) {
        header("location:../Vendedores.php");
        echo "Vendedor actualizado correctamente";
    } else {
        echo "Error al actualizar el vendedor: " . $conexion->error;
    }
}
?>
