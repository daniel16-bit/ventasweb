<?php
    // Incluimos el archivo de conexión (que debe tener el código que te di antes)
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

        $usuario = validar($_POST['user']);
        $password = validar($_POST['password']);

        if(empty($usuario)){
            header('location: ../../formularios/formulario.php?error=Usuario Requerido');
            exit();
        } elseif(empty($password)){
            header('location: ../../formularios/formulario.php?error=Contraseña Requerida');
            exit();
        }

        $connectionOptions = array(
            "Database" => $databaseName,
            "Uid" => $uid,
            "PWD" => $pwd
        );
        
        $conexion = sqlsrv_connect($serverName, $connectionOptions);
        
        if ($conexion === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        
        // --- Consultas y lógica de validación ---
        $sql = "SELECT ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Contraseña, Correo, rol FROM USUARIO WHERE Correo = ? OR Telefono = ?";
        
        $stmt = sqlsrv_prepare($conexion, $sql, array(&$usuario, &$usuario));
        sqlsrv_execute($stmt);

        if(sqlsrv_has_rows($stmt)){
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            if($row['Contraseña'] === $password){ 
                $_SESSION['ID_Usuario'] = $row['ID_Usuario'];
                $_SESSION['Prime_Nombre'] = $row['Prime_Nombre'];
                $_SESSION['Prime_Apellido'] = $row['Prime_Apellido'];
                $_SESSION['rol'] = $row['rol'];

                // --- ¡La corrección va aquí! ---
                // Convertimos el rol a minúsculas para compararlo
                $rol_usuario = strtolower($row['rol']);

                if($rol_usuario == 'vendedor'){
                    header('Location: ../../vendedor/DashboardVendedor.php');
                } elseif($rol_usuario == 'administrador'){
                    header('Location: ../Dashboard.php');
                }
            } else { 
                header('Location: ../../formularios/formulario.php?error=Usuario o contraseña incorrectos');
                exit();
            }
        } else {
            header('Location:../../formularios/formulario.php?error=Usuario no registrado');
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conexion);
    }
?>