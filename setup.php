<?php

/**
 * domusflow — setup inicial
 * execute uma vez após clonar o repositório:
 * http://localhost/Domusflow_novo/setup.php
 *
 * apague este arquivo após executar!
 */

require_once __DIR__ . '/config/database.php';

$senha_padrao = '123456';
$hash         = password_hash($senha_padrao, PASSWORD_BCRYPT);

try {
    $pdo = getConnection();

    // todos os usuários padrão do sistema
    $emails = [
        'admin@domusflow.com',
        'sindico@domusflow.com',
        'porteiro@domusflow.com',
        'zefinha@domusflow.com',
        'alexandrebarbosa25@email.com',
    ];

    foreach ($emails as $email) {
        $stmt = $pdo->prepare("UPDATE morador SET senha = ? WHERE email = ?");
        $stmt->execute([$hash, $email]);
        $linhas = $stmt->rowCount();

        if ($linhas > 0) {
            echo "Hash atualizado: <strong>$email</strong><br>";
        } else {
            echo "Não encontrado: <strong>$email</strong><br>";
        }
    }

    echo "<br><p>Senha padrão: <strong>$senha_padrao</strong></p>";
    echo "<p style='color:red'><strong>Apague este arquivo agora!</strong></p>";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
