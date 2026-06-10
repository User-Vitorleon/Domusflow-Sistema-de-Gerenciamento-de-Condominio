<?php

function carregarEnv(string $path): void
{
    if (!file_exists($path)) return;

    $linhas = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($linhas as $linha) {
        if (str_starts_with(trim($linha), '#')) continue;
        [$chave, $valor] = explode('=', $linha, 2);
        $_ENV[trim($chave)] = trim($valor);
    }
}

carregarEnv(__DIR__ . '/../.env');

date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'America/Sao_Paulo');

define('BASE_URL',            $_ENV['APP_BASE_URL']          ?? '');
define('BRASIL_API_FERIADOS', 'https://brasilapi.com.br/api/feriados/v1/');
define('HASH_SALT',           $_ENV['APP_HASH_SALT']         ?? '');

define('SMTP_HOST',           $_ENV['SMTP_HOST']             ?? '');
define('SMTP_PORT',           (int) ($_ENV['SMTP_PORT']      ?? 587));
define('SMTP_USUARIO',        $_ENV['SMTP_USUARIO']          ?? '');
define('SMTP_SENHA',          $_ENV['SMTP_SENHA']            ?? '');
define('SMTP_NOME_REMETENTE', $_ENV['SMTP_NOME_REMETENTE']   ?? 'DomusFlow');

function hashSenha(string $senha): string
{
    return password_hash($senha, PASSWORD_BCRYPT, ['cost' => 10]);
}