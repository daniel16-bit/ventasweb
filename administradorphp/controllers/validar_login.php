<?php
include_once '../models/conexion.php'; // aquí se obtiene $conn
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

    // ⚡ Consulta SQL para SQL Server
    $sql = "SELECT ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, [Contraseña], Correo, rol
            FROM colfar.usuario
            WHERE Correo = ? OR Telefono = ?";

    $params = array($usuario, $usuario);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

        // ⚠️ Si la contraseña está hasheada, usa password_verify
        if ($row['Contraseña'] === $password) {
            $_SESSION['ID_Usuario'] = $row['ID_Usuario'];
            $_SESSION['Prime_Nombre'] = $row['Prime_Nombre'];
            $_SESSION['Prime_Apellido'] = $row['Prime_Apellido'];
            $_SESSION['rol'] = $row['rol'];

            $rol_usuario = strtolower($row['rol']);

            if ($rol_usuario == 'vendedor') {
                header('Location: ../../vendedor/DashboardVendedor.php');
                exit();
            } elseif ($rol_usuario == 'administrador') {
                header('Location: ../Dashboard.php');
                exit();
            } else {
                header('Location: ../../formularios/formulario.php?error=Rol de usuario no válido');
                exit();
            }
        } else {
            header('Location: ../../formularios/formulario.php?error=Usuario o contraseña incorrectos');
            exit();
        }
    } else {
        header('Location: ../../formularios/formulario.php?error=Usuario no registrado');
        exit();
    }

    sqlsrv_free_stmt($stmt);
}
?>

