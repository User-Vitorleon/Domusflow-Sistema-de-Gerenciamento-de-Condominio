<?php 
$host      = 'localhost';
$name_db   = 'domusflow_bd'; 
$user      = 'root';
$password  = ''; 
$charset   = 'utf8mb4';


$dsn = "mysql:host=$host;dbname=$name_db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (\PDOException $e) {
}
?>