<?php
    include_once '../models/conexion.php'; // Aquí tu conexión con PDO

    session_start();

    if(isset($_POST['user']) && isset($_POST['password'])){

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

        // Consulta SQL para SQL Server
        $sql = "SELECT ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Contraseña, Correo, rol 
                FROM USUARIO 
                WHERE Correo = :usuario OR Telefono = :usuario";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar contraseña (si usas HASH en la BD)
            if(password_verify($password, $row['Contraseña'])){
                $_SESSION['ID_Usuario'] = $row['ID_Usuario'];
                $_SESSION['Prime_Nombre'] = $row['Prime_Nombre'];
                $_SESSION['Prime_Apellido'] = $row['Prime_Apellido'];
                $_SESSION['rol'] = $row['rol'];

                $rol_usuario = strtolower($row['rol']);

                if($rol_usuario == 'vendedor'){
                    header('Location: ../../vendedor/DashboardVendedor.php');
                    exit();
                } elseif($rol_usuario == 'administrador'){
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

    } else {
        header('Location:../../formularios/formulario.php?error=Acceso no autorizado');
        exit();
    }
?>
