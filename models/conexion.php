<?php
    // Configuración de la base de datos de Azure SQL
    // IMPORTANTE: Para producción, usa variables de entorno en lugar de credenciales hardcodeadas

    // Verificar si las variables de entorno están configuradas
    $serverName = $_ENV['DB_SERVER'] ?? "colfar-db1.database.windows.net";
    $databaseName = $_ENV['DB_NAME'] ?? "colfar";
    $uid = $_ENV['DB_USER'] ?? "colfardb";
    $pwd = $_ENV['DB_PASSWORD'] ?? "Daniel2005";

    // Configuración de conexión mejorada con UTF-8
    $connectionOptions = array(
        "Database" => $databaseName,
        "Uid" => $uid,
        "PWD" => $pwd,
        "CharacterSet" => "UTF-8",
        "ConnectionTimeout" => 30,
        "LoginTimeout" => 30,
        "Encrypt" => true,
        "TrustServerCertificate" => false,
        "ReturnDatesAsStrings" => true
    );
    
    // Intentar conectar a la base de datos
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    
    // Verificar si la conexión falló
    if ($conn === false) {
        $errors = sqlsrv_errors();
        error_log("Error de conexión a la base de datos: " . print_r($errors, true));
        
        // En desarrollo, mostrar errores detallados
        if ($_ENV['APP_ENV'] === 'development' || !isset($_ENV['APP_ENV'])) {
            die("Error de conexión a la base de datos: " . print_r($errors, true));
        } else {
            // En producción, mostrar mensaje genérico
            die("Error de conexión. Por favor, contacte al administrador del sistema.");
        }
    }

    // Configurar zona horaria
    date_default_timezone_set('America/Bogota');

    // Función para cerrar la conexión
    function cerrarConexion($conn) {
        if ($conn) {
            sqlsrv_close($conn);
        }
    }

    // Registrar función para cerrar conexión al finalizar script
    register_shutdown_function('cerrarConexion', $conn);
?>