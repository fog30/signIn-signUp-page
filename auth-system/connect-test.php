<?php
$serverName = "FERGAL\\SQLEXPRESS01"; // Replace with your instance name
$connectionOptions = [
    "Database" => "user_auth", // Replace with your DB name
    "Uid" => "",                // Leave blank for Windows Auth
    "PWD" => "",
    "Authentication" => SQLSRV_AUTH_WINDOWS
];

// Try to connect
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn) {
    echo "✅ Connection to SQL Server successful!";
} else {
    echo "❌ Connection failed.<br>";
    die(print_r(sqlsrv_errors(), true));
}
?>
