<?php
$serverName = "colfar-db1.database.windows.net";
$databaseName = "colfar";
$uid = "colfardb";
$pwd = "Daniel2005"; // Cambiar en producción

$connectionOptions = array(
    "Database" => $databaseName,
    "Uid" => $uid,
    "PWD" => $pwd,
    "CharacterSet" => "UTF-8"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die("Error de conexión: " . print_r(sqlsrv_errors(), true));
}
?>

