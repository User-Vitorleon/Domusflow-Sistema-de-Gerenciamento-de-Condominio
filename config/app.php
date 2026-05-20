<?php
<<<<<<< HEAD
// ── Timezone ────────────────────────────────────────
date_default_timezone_set('America/Sao_Paulo');

// ── URLs ────────────────────────────────────────────
define('BASE_URL', '/Domusflow-Sistema-de-Gerenciamento-de-Condominio');
define('BRASIL_API_FERIADOS', 'https://brasilapi.com.br/api/feriados/v1/');

// ── Segurança / Hash ────────────────────────────────
define('HASH_SALT', 'DomusFlow@Salt#2025!Fixo$1234ab');

=======

date_default_timezone_set('America/Sao_Paulo');

define('BASE_URL', '/Domusflow-Sistema-de-Gerenciamento-de-Condominio');
define('BRASIL_API_FERIADOS', 'https://brasilapi.com.br/api/feriados/v1/');

define('HASH_SALT', 'DomusFlow@Salt#2025!Fixo$1234ab');

define('SMTP_HOST',       'smtp.gmail.com');
define('SMTP_PORT',       587);
define('SMTP_USUARIO',    'Suport.domusflow@gmail.com');
define('SMTP_SENHA',      'jikd fcnz qebx qbzo');
define('SMTP_NOME_REMETENTE', 'DomusFlow');

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
function hashSenha(string $senha): string
{
    return password_hash($senha, PASSWORD_BCRYPT, ['cost' => 10]);
}
