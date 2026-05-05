<?php
// ── Timezone ────────────────────────────────────────
date_default_timezone_set('America/Sao_Paulo');

// ── URLs ────────────────────────────────────────────
define('BASE_URL', '/Domusflow-Sistema-de-Gerenciamento-de-Condominio');
define('BRASIL_API_FERIADOS', 'https://brasilapi.com.br/api/feriados/v1/');

// ── Segurança / Hash ────────────────────────────────
define('HASH_SALT', 'DomusFlow@Salt#2025!Fixo$1234ab');

function hashSenha(string $senha): string
{
    return password_hash($senha, PASSWORD_BCRYPT, ['cost' => 10]);
}
