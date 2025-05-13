<?php

$dsn = "mysql:host=127.0.0.1;port=3306;dbname=db";
$dbusername = "root";
$dbpassword = "Ilyassee1432..";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection Failed: " . $e->getMessage();
}
