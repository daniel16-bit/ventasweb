<?php
/**
 * Archivo de configuración principal para el sistema Colfar
 * Contiene todas las configuraciones necesarias para el funcionamiento óptimo
 */

// Configuraciones de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuraciones de sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Cambiar a 1 en HTTPS
ini_set('session.gc_maxlifetime', 3600); // 1 hora

// Configuraciones de memoria y tiempo de ejecución
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 300);
ini_set('max_input_time', 300);

// Configuraciones de uploads
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_file_uploads', 20);

// Configuraciones de charset
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

// Zona horaria
date_default_timezone_set('America/Bogota');

// Configuraciones de la aplicación
define('APP_NAME', 'Colfar - Sistema de Ventas');
define('APP_VERSION', '1.0.0');
define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');

// Configuraciones de base de datos
define('DB_SERVER', $_ENV['DB_SERVER'] ?? 'colfar-db1.database.windows.net');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'colfar');
define('DB_USER', $_ENV['DB_USER'] ?? 'colfardb');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? 'Daniel2005');

// Configuraciones de seguridad
define('SESSION_TIMEOUT', 3600); // 1 hora en segundos
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minutos

// Configuraciones de archivos
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB

// Configuraciones de correo (si se implementa)
define('SMTP_HOST', $_ENV['SMTP_HOST'] ?? '');
define('SMTP_PORT', $_ENV['SMTP_PORT'] ?? 587);
define('SMTP_USERNAME', $_ENV['SMTP_USERNAME'] ?? '');
define('SMTP_PASSWORD', $_ENV['SMTP_PASSWORD'] ?? '');
define('SMTP_ENCRYPTION', $_ENV['SMTP_ENCRYPTION'] ?? 'tls');

// Configuraciones de logging
define('LOG_PATH', __DIR__ . '/../logs/');
define('LOG_LEVEL', APP_ENV === 'production' ? 'error' : 'debug');

// Función para logging
function logMessage($level, $message, $context = []) {
    $logFile = LOG_PATH . date('Y-m-d') . '.log';
    $timestamp = date('Y-m-d H:i:s');
    $contextStr = !empty($context) ? ' ' . json_encode($context) : '';
    $logEntry = "[{$timestamp}] {$level}: {$message}{$contextStr}" . PHP_EOL;
    
    // Crear directorio de logs si no existe
    if (!is_dir(LOG_PATH)) {
        mkdir(LOG_PATH, 0755, true);
    }
    
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

// Función para manejo de errores personalizado
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $errorTypes = [
        E_ERROR => 'ERROR',
        E_WARNING => 'WARNING',
        E_PARSE => 'PARSE',
        E_NOTICE => 'NOTICE',
        E_CORE_ERROR => 'CORE_ERROR',
        E_CORE_WARNING => 'CORE_WARNING',
        E_COMPILE_ERROR => 'COMPILE_ERROR',
        E_COMPILE_WARNING => 'COMPILE_WARNING',
        E_USER_ERROR => 'USER_ERROR',
        E_USER_WARNING => 'USER_WARNING',
        E_USER_NOTICE => 'USER_NOTICE',
        E_STRICT => 'STRICT',
        E_RECOVERABLE_ERROR => 'RECOVERABLE_ERROR',
        E_DEPRECATED => 'DEPRECATED',
        E_USER_DEPRECATED => 'USER_DEPRECATED'
    ];
    
    $errorType = $errorTypes[$errno] ?? 'UNKNOWN';
    $message = "{$errorType}: {$errstr} in {$errfile} on line {$errline}";
    
    logMessage('error', $message);
    
    if (APP_ENV === 'development') {
        echo "<div style='color: red; background: #ffe6e6; padding: 10px; margin: 5px; border: 1px solid red;'>{$message}</div>";
    }
    
    return true; // No ejecutar el manejador de errores interno de PHP
}

// Configurar manejador de errores personalizado
set_error_handler('customErrorHandler');

// Función para manejo de excepciones no capturadas
function customExceptionHandler($exception) {
    $message = "Uncaught exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine();
    logMessage('error', $message);
    
    if (APP_ENV === 'development') {
        echo "<div style='color: red; background: #ffe6e6; padding: 10px; margin: 5px; border: 1px solid red;'>{$message}</div>";
        echo "<pre>{$exception->getTraceAsString()}</pre>";
    } else {
        echo "Ha ocurrido un error. Por favor, contacte al administrador del sistema.";
    }
}

// Configurar manejador de excepciones
set_exception_handler('customExceptionHandler');

// Función para iniciar sesión segura
function startSecureSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
        
        // Regenerar ID de sesión periódicamente
        if (!isset($_SESSION['last_regeneration'])) {
            $_SESSION['last_regeneration'] = time();
        } elseif (time() - $_SESSION['last_regeneration'] > 300) { // 5 minutos
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
        
        // Verificar timeout de sesión
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
            session_unset();
            session_destroy();
            return false;
        }
        
        $_SESSION['last_activity'] = time();
    }
    return true;
}

// Función para validar sesión de usuario
function validateUserSession() {
    if (!startSecureSession()) {
        return false;
    }
    
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

// Función para sanitizar datos de entrada
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Función para generar token CSRF
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Función para validar token CSRF
function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Inicializar sesión segura
startSecureSession();

// Log de inicio de aplicación
logMessage('info', 'Aplicación iniciada', ['version' => APP_VERSION, 'environment' => APP_ENV]);

?>
