<?php
include_once '../models/conexion.php'; // aquí tienes tu $conn
session_start();

if (isset($_POST['user']) && isset($_POST['password'])) {
    include_once '../models/conexion.php';
    session_start();
    
    // Verificamos si los campos de usuario y contraseña fueron enviados por POST
    if(isset($_POST['user']) && isset($_POST['password'])){
        
        // Función para limpiar los datos de entrada
        function validar($data){
            $data = trim($data);         // Elimina espacios al inicio y al final
            $data = stripslashes($data); // Elimina las barras invertidas
            $data = htmlspecialchars($data); // Convierte caracteres especiales en HTML
            return $data;
        }

    function validar($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
        // Asignamos y limpiamos las variables de entrada
        $usuario = validar($_POST['user']);
        $password = validar($_POST['password']);

    $usuario = validar($_POST['user']);
    $password = validar($_POST['password']);
        // Comprobamos si el usuario o la contraseña están vacíos
        if(empty($usuario)){
            header('location: ../../formularios/formulario.php?error=Usuario Requerido');
            exit();
        } elseif(empty($password)){
            header('location: ../../formularios/formulario.php?error=Contraseña Requerida');
            exit();
        }

    if (empty($usuario)) {
        header('location: ../../formularios/formulario.php?error=Usuario Requerido');
        exit();
    } elseif (empty($password)) {
        header('location: ../../formularios/formulario.php?error=Contraseña Requerida');
        exit();
    }
        // Corregimos la consulta SQL (faltaba cerrar paréntesis en la consulta)
        $sql = "SELECT ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, Contraseña, Correo, rol FROM USUARIO WHERE Correo = ? OR Telefono = ?";
        
        // Preparamos la consulta
        $stmt = mysqli_prepare($conexion, $sql);

    // Consulta preparada para SQL Server
$sql = "SELECT ID_Usuario, Prime_Nombre, Segundo_Nombre, Prime_Apellido, Segundo_Apellido, [Contraseña], Correo, rol
        FROM colfar.usuario
        WHERE Correo = ? OR Telefono = ?";
        // Vinculamos los parámetros para prevenir inyección SQL
        mysqli_stmt_bind_param($stmt, 'ss', $usuario, $usuario); // 'ss' es para dos cadenas (strings)

        // Ejecutamos la consulta
        mysqli_stmt_execute($stmt);

    $params = array($usuario, $usuario);
    $stmt = sqlsrv_query($conn, $sql, $params);
        // Obtenemos el resultado
        $resultado = mysqli_stmt_get_result($stmt);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
        // Verificamos si encontramos un solo usuario
        if(mysqli_num_rows($resultado) === 1){
            $row = mysqli_fetch_assoc($resultado);

    // Si encuentra un usuario
    if (sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            // Verificamos si la contraseña ingresada coincide con la de la base de datos
            if($row['Contraseña'] === $password){ // En caso de usar hash para contraseñas, se usa password_verify()
                // Almacenamos los datos del usuario en la sesión
                $_SESSION['ID_Usuario'] = $row['ID_Usuario'];
                $_SESSION['Prime_Nombre'] = $row['Prime_Nombre'];
                $_SESSION['Prime_Apellido'] = $row['Prime_Apellido'];
                $_SESSION['rol'] = $row['rol'];

        // ⚠️ Si tus contraseñas están hasheadas, usa password_verify
        // Ejemplo: if (password_verify($password, $row['Contraseña']))
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
                // Redirigimos según el rol del usuario
                if($row['rol'] == 'vendedor'){ // Ten en cuenta que debes coincidir los roles correctamente
                    header('Location: ../../vendedor/DashboardVendedor.php');
                } elseif($row['rol'] == 'administrador'){
                    header('Location: ../Dashboard.php');
                }
            } else { 
                // Contraseña incorrecta
                header('Location: ../../formularios/formulario.php?error=Usuario o contraseña incorrectos');
                exit();
            }
        } else {
            header('Location: ../../formularios/formulario.php?error=Usuario o contraseña incorrectos');
            exit();
            // Usuario no registrado
            header('Location:../../formularios/formulario.php?error=Usuario no registrado');
        }
    } else {
        header('Location: ../../formularios/formulario.php?error=Usuario no registrado');
        exit();
    }

    sqlsrv_free_stmt($stmt);
}
        // Cerramos la consulta preparada
        mysqli_stmt_close($stmt);
    }
?>
