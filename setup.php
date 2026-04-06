<?php

/**
 * DomusFlow — Setup inicial
 * Execute UMA VEZ após clonar o repositório:
 * http://localhost/Domusflow-novo/setup.php
 * 
 * APAGUE este arquivo após executar!
 * só criamos isso para RAFAZER O HASH QUANDO CLONAR DOS 3 TIPOS DE USER !!!
 */

require_once __DIR__ . '/config/database.php';

$senhapadrao = '123456';
$hash = password_hash($senhapadrao, PASSWORD_BCRYPT);

try {
    $pdo = getConnection(); // aqui chama a função do database.php

    $emails = [
        'sindico@domusflow.com',
        'zefinha@domusflow.com',
        'admin@domusflow.com',
    ];

    foreach ($emails as $email) {
        $stmt = $pdo->prepare("UPDATE morador SET senha = ? WHERE email = ?");
        $stmt->execute([$hash, $email]);
        echo "Hash atualizado: <strong>$email</strong><br>";
    }

    echo "<br><p>Senha padrão: <strong>$senhapadrao</strong></p>";
    echo "<p>⚠️ <strong>APAGUE este arquivo agora!</strong></p>";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
