<?php
include_once '../models/conexion.php';
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

    $sql = "SELECT ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Contrasena, Correo, rol FROM colfar.USUARIO WHERE Correo = ? OR Telefono = ?";
    
    $params = array($usuario, $usuario);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt && sqlsrv_execute($stmt)) {
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            if ($row['Contraseña'] === $password) {
                $_SESSION['ID_Usuario'] = $row['ID_Usuario'];
                $_SESSION['Prime_Nombre'] = $row['Prime_Nombre'];
                $_SESSION['Prime_Apellido'] = $row['Prime_Apellido'];
                $_SESSION['rol'] = $row['rol'];

                if ($row['rol'] == 'vendedor') {
                    header('Location: ../../vendedor/DashboardVendedor.php');
                } elseif ($row['rol'] == 'administrador') {
                    header('Location: ../Dashboard.php');
                }
                exit();
            } else {
                header('Location: ../../formularios/formulario.php?error=Usuario o contraseña incorrectos');
                exit();
            }
        } else {
            header('Location: ../../formularios/formulario.php?error=Usuario no registrado');
            exit();
        }
    } else {
        die(print_r(sqlsrv_errors(), true));
    }

    sqlsrv_free_stmt($stmt);
}
?>



