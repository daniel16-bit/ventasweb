<?php
try {
    $serverName = "tcp:colfar-db1.database.windows.net,1433"; // Asegúrate de usar el puerto correcto
    $databaseName = "colfar";
    $uid = "colfardb";
    $pwd = "Daniel2005"; // ⚠️ Asegúrate de manejar esta credencial con seguridad

    // Crear conexión PDO con el driver sqlsrv
    $conexion = new PDO("sqlsrv:Server=$serverName;Database=$databaseName", $uid, $pwd);

    // Configurar PDO para lanzar excepciones en errores
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión con SQL Server (PDO): " . $e->getMessage());
}
?>
