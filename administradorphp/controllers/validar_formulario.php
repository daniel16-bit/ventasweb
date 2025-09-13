<?php
    include_once '../models/conexion.php';
    session_start();

    if (isset($_POST['user']) && isset($_POST['password'])) {
        // Función para limpiar datos
        function validar($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Obtener los valores del formulario y validarlos
        $usuario = validar($_POST['user']);
        $password = validar($_POST['password']);

        if (empty($usuario)) {
            header('Location: ../formulario.php?error=Usuario Requerido');
            exit();
        } elseif (empty($password)) {
            header('Location: ../formulario.php?error=Contraseña Requerida');
            exit();
        }

        // Consulta SQL usando parámetros preparados para evitar inyección SQL
        $sql = "SELECT (ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Contraseña, Correo, rol FROM USUARIO WHERE Correo = ? OR Contraseña = ?";
        $stmt = mysqli_prepare($conexion, $sql);
        
        // Vincular los parámetros
        mysqli_stmt_bind_param($stmt, 'ss', $usuario,$password);

        // Ejecutar la consulta
        mysqli_stmt_execute($stmt);

        // Obtener el resultado
        $resultado = mysqli_stmt_get_result($stmt);

        // Verificar si se encuentra un solo usuario
        if (mysqli_num_rows($resultado) === 1) {
            $row = mysqli_fetch_assoc($resultado);

            // Comparar la contraseña con la almacenada (recomendación usar password_verify)
            if (password_verify($password, $row['Contraseña'])) { 
                $_SESSION['ID_Usuario'] = $row['ID_Usuario'];
                $_SESSION['Prime_Nombre'] = $row['Prime_Nombre'];
                $_SESSION['rol'] = $row['rol'];

                // Redirigir dependiendo del rol
                if ($row['rol'] == 'USUARIO') {
                    header('Location: ../interfazCliente.php');
                } elseif ($row['rol'] == 'administrador') {
                    header('Location: ../Dashboard.php');
                }
            } else {
                // Contraseña incorrecta
                header('Location: ../formulario.php?error=Usuario o contraseña incorrectos');
                exit();
            }
        } else {
            // Usuario no encontrado
            header('Location: ../formulario.php?error=Usuario no registrado');
        }
    }
?>