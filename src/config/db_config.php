<?php

$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'];
$dbName = $_ENV['DB_NAME'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];

try {
    $connection = new Pdo(
        "mysql:host=$host;port=$port;dbname=$dbName",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    return $connection;
} catch (PDOException $e) {
    die('A conexão falhou: ' . $e->getMessage());
}