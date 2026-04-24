<?php
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/app/services/EmailService.php';

$email = new EmailService();
$resultado = $email->boasVindas('vitor.leon465@gmail.com', 'Teste');

var_dump($resultado);