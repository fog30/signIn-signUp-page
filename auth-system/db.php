<?php
$serverName = "FERGAL\\SQLEXPRESS01"; // Your SQL Server instance name

$connectionOptions = [
    "Database" => "user_auth",
    "UID" => "",  // Leave blank for Windows Auth
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}
?>
