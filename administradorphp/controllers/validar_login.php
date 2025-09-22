<?php
include_once '../models/conexion.php'; // Conexión a SQL Server
session_start();

if (isset($_POST['user']) && isset($_POST['password'])) {

    function validar($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $usuario = validar($_POST['user']);
    $password = validar($_POST['password']);

    if (empty($usuario)) {
        header('location: ../../formularios/formulario.php?error=Usuario Requerido');
        exit();
    } elseif (empty($password)) {
        header('location: ../../formularios/formulario.php?error=Contraseña Requerida');
        exit();
    }

    // Consulta preparada
    $sql = "SELECT ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Contraseña, Correo, rol 
            FROM USUARIO 
            WHERE Correo = ? OR Telefono = ?";

    $params = array($usuario, $usuario);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt && sqlsrv_execute($stmt)) {
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

            // ✅ Comparar con password_verify
            if (password_verify($password, $row['Contraseña'])) {
                // Iniciar sesión
                $_SESSION['ID_Usuario'] = $row['ID_Usuario'];
                $_SESSION['Prime_Nombre'] = $row['Prime_Nombre'];
                $_SESSION['Prime_Apellido'] = $row['Prime_Apellido'];
                $_SESSION['rol'] = $row['rol'];

                // Redirección según rol
                if (strtolower($row['rol']) == 'vendedor') {
                    header('Location: ../../vendedor/DashboardVendedor.php');
                } elseif (strtolower($row['rol']) == 'administrador') {
                    header('Location: ../Dashboard.php');
                } else {
                    header('Location: ../../formularios/formulario.php?error=Rol de usuario no válido');
                }
                exit();

            } else {
                // Contraseña incorrecta
                header('Location: ../../formularios/formulario.php?error=Usuario o contraseña incorrectos');
                exit();
            }

        } else {
            // Usuario no encontrado
            header('Location: ../../formularios/formulario.php?error=Usuario no registrado');
            exit();
        }

    } else {
        // Error en la ejecución
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
}
?>
