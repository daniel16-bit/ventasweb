<?php
    include_once '../models/conexion.php';
    session_start();

    // Verificamos si los campos de usuario y contraseña fueron enviados por POST
    if(isset($_POST['user']) && isset($_POST['password'])){

        // Función para limpiar los datos de entrada
        function validar($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Asignamos y limpiamos las variables de entrada
        $usuario = validar($_POST['user']); // Este $usuario se usará para Correo o Telefono
        $password = validar($_POST['password']);

        if(empty($usuario)){
            header('location: ../../formularios/formulario.php?error=Usuario Requerido');
            exit();
        } elseif(empty($password)){
            header('location: ../../formularios/formulario.php?error=Contraseña Requerida');
            exit();
        }

        // La consulta SQL
        // Asumiendo que 'user' puede ser Correo O Telefono
        $sql = "SELECT ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Contraseña, Correo, rol FROM USUARIO WHERE Correo = ? OR Telefono = ?";

        // --- COMIENZO DEL CÓDIGO FALTANTE ---

        // Asumiendo que $conexion es tu objeto mysqli desde conexion.php
        if ($stmt = $conexion->prepare($sql)) {
            // Unir el parámetro dos veces porque se usa para Correo Y Telefono
            $stmt->bind_param("ss", $usuario, $usuario);
            $stmt->execute();
            $resultado = $stmt->get_result();

            // Verificamos si encontramos exactamente un usuario
            if ($resultado->num_rows === 1) {
                $row = $resultado->fetch_assoc();

                // Aquí, el código de verificación de contraseña, sesiones y redirección
                // Lo que tenías después del comentario "--- La corrección va aquí: validación con strtolower() ---"

                // Verificamos si la contraseña ingresada coincide con la de la base de datos
                // OJO: Si la contraseña en la BD es HASH, NO la compares directamente así.
                // Usar password_verify() si las contraseñas están hasheadas.
                if(password_verify($password, $row['Contraseña'])){ // CAMBIO AQUÍ: USAR password_verify si usas hash
                    $_SESSION['ID_Usuario'] = $row['ID_Usuario'];
                    $_SESSION['Prime_Nombre'] = $row['Prime_Nombre'];
                    $_SESSION['Prime_Apellido'] = $row['Prime_Apellido'];
                    $_SESSION['rol'] = $row['rol'];

                    $rol_usuario = strtolower($row['rol']);

                    if($rol_usuario == 'vendedor'){
                        header('Location: ../../vendedor/DashboardVendedor.php');
                        exit(); // Siempre usa exit() después de un header Location
                    } elseif($rol_usuario == 'administrador'){
                        header('Location: ../Dashboard.php');
                        exit(); // Siempre usa exit() después de un header Location
                    } else {
                         // Rol no reconocido o algo inesperado
                         header('Location: ../../formularios/formulario.php?error=Rol de usuario no válido');
                         exit();
                    }
                } else {
                    // Contraseña incorrecta
                    header('Location: ../../formularios/formulario.php?error=Usuario o contraseña incorrectos');
                    exit();
                }
            } else {
                // Usuario no encontrado o múltiples usuarios (lo cual sería un problema)
                header('Location: ../../formularios/formulario.php?error=Usuario no registrado');
                exit();
            }
            $stmt->close(); // Cerrar la declaración preparada
        } else {
            // Error en la preparación de la consulta SQL
            error_log("Error al preparar la consulta SQL: " . $conexion->error);
            header('Location: ../../formularios/formulario.php?error=Error interno del servidor');
            exit();
        }

        // --- FIN DEL CÓDIGO FALTANTE ---

    } else {
        // Si no se enviaron usuario y contraseña por POST
        header('Location:../../formularios/formulario.php?error=Acceso no autorizado');
        exit();
    }
?>