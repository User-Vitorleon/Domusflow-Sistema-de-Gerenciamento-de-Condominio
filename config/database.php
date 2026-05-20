<?php
function getConnection(): PDO
{
    $host    = 'localhost';
    $dbname  = 'domusflow_bd';
    $user    = 'root';
    $pass    = '';
    $charset = 'utf8mb4';

<<<<<<< HEAD
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
=======
    $dsn = "mysql:host={$host};dbname={$dbname};charset={$charset}";
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
<<<<<<< HEAD
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'", // ← NOVO
=======
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'",
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    ];

    return new PDO($dsn, $user, $pass, $options);
}
