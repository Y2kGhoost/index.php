<?php

$dsn = "mysql:unix_socket=/run/mysqld/mysqld.sock;dbname=db";
$dbusername = "root";
$dbpassword = "root";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection Failed: " . $e->getMessage();
}