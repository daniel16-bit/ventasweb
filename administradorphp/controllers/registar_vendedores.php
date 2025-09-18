<?php
// Incluir el archivo de conexión que usa sqlsrv
include '../models/conexion.php'; 

// Verificar si la solicitud es un POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir datos del formulario. Usamos isset() para evitar warnings.
    $id_zona  = isset($_POST['zona']) ? $_POST['zona'] : null;
    $id_usuario = isset($_POST['usuario']) ? $_POST['usuario'] : null;

    // Validar que los datos no estén vacíos
    if (!empty($id_zona) && !empty($id_usuario)) {
        // Consulta SQL para insertar en la tabla VENDEDOR
        // Asegúrate de que los nombres de las columnas coincidan con tu base de datos
        $sql = "INSERT INTO colfar.VENDEDOR (ID_Zona, ID_Usuario) VALUES (?, ?)";

        // Preparamos los parámetros para la consulta
        $params = array($id_zona, $id_usuario);

        // Ejecutar la consulta. sqlsrv_query() no tiene un método prepare,
        // maneja la seguridad con los parámetros.
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            // Manejo de errores si la consulta falla
            die(print_r(sqlsrv_errors(), true));
        } else {
            // Redireccionar a la página de vendedores si el registro fue exitoso
            header("Location: ../Vendedores.php");
            exit();
        }
    } else {
        // Mensaje de error si faltan datos
        echo "Por favor, complete todos los campos.";
    }
}
?>

