<?php

// Create a PDO database connection
$host = 'localhost';
$db   = 'project_parking_php';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

// Create PDO instance with error mode enabled
$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

return $pdo;
