<?php
// ========================================
// CONFIGURACIÓN DE CONEXIÓN A SQL SERVER
// ========================================

// ⚠️ ¡IMPORTANTE! Para producción, deberías mover tus credenciales a un archivo .env o a variables de entorno

// Configuración directa (puedes ajustar manualmente)
$serverName   = "colfar-db1.database.windows.net";
$databaseName = "colfar";
$uid          = "colfardb";
$pwd          = "Daniel2005";

// Opciones válidas para sqlsrv_connect
$connectionOptions = array(
    "Database"               => $databaseName,
    "Uid"                    => $uid,
    "PWD"                    => $pwd,
    "CharacterSet"           => "UTF-8",
    "LoginTimeout"           => 30,
    "Encrypt"                => true,
    "TrustServerCertificate" => false,
    "ReturnDatesAsStrings"   => true
);

// Intentar conectar a la base de datos
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Si la conexión falla, mostrar error básico (puedes personalizar este mensaje)
if ($conn === false) {
    $errors = sqlsrv_errors();
    error_log("❌ Error de conexión a la base de datos: " . print_r($errors, true));
    
    // Mostrar mensaje genérico al usuario
    die("❌ No se pudo conectar a la base de datos. Intente más tarde o contacte al administrador.");
}

// Configurar zona horaria
date_default_timezone_set('America/Bogota');

// Función para cerrar la conexión
function cerrarConexion($conn) {
    if ($conn) {
        sqlsrv_close($conn);
    }
}

// Cerrar conexión al finalizar
register_shutdown_function('cerrarConexion', $conn);
?>

