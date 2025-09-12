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
        $usuario = validar($_POST['user']);
        $password = validar($_POST['password']);

        if(empty($usuario)){
            header('location: ../../formularios/formulario.php?error=Usuario Requerido');
            exit();
        } elseif(empty($password)){
            header('location: ../../formularios/formulario.php?error=Contraseña Requerida');
            exit();
        }

        // La consulta SQL sigue igual
        $sql = "SELECT ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Contraseña, Correo, rol FROM USUARIO WHERE Correo = ? OR Telefono = ?";


            // Verificamos si la contraseña ingresada coincide con la de la base de datos
            if($row['Contraseña'] === $password){ 
                $_SESSION['ID_Usuario'] = $row['ID_Usuario'];
                $_SESSION['Prime_Nombre'] = $row['Prime_Nombre'];
                $_SESSION['Prime_Apellido'] = $row['Prime_Apellido'];
                $_SESSION['rol'] = $row['rol'];
                
                // --- La corrección va aquí: validación con strtolower() ---
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
 

?>