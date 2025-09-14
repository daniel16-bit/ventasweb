<?php
    // Datos de la base de datos de Azure SQL
    $serverName = "colfar-db1.database.windows.net";
    $databaseName = "colfar";
    $uid = "colfardb";
    $pwd = "Daniel2005"; // <-- IMPORTANTE: Reemplaza esto con tu contraseña real

    // Define las opciones de conexión para sqlsrv
    $connectionOptions = array(
        "Database" => $databaseName,
        "Uid" => $uid,
        "PWD" => $pwd
    );
    
    // Conectar a la base de datos de Azure SQL
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    
    // Verificar si la conexión falló
    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }
?>