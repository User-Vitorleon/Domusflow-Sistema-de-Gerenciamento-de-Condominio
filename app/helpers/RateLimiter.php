<?php

class RateLimiter
{
    private const MAX_TENTATIVAS = 5;
    private const JANELA_SEGUNDOS = 10 * 60; 

    public static function verificar(string $chave): bool
    {
        self::iniciarSessao();

        $ip      = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key     = "rl_{$chave}_{$ip}";
        $agora   = time();

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = ['tentativas' => 0, 'primeiro_em' => $agora];
        }

        $dados = &$_SESSION[$key];

        if (($agora - $dados['primeiro_em']) > self::JANELA_SEGUNDOS) {
            $dados = ['tentativas' => 0, 'primeiro_em' => $agora];
        }

        return $dados['tentativas'] < self::MAX_TENTATIVAS;
    }

    public static function registrarFalha(string $chave): void
    {
        self::iniciarSessao();

        $ip  = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = "rl_{$chave}_{$ip}";

        $_SESSION[$key]['tentativas'] = ($_SESSION[$key]['tentativas'] ?? 0) + 1;
    }

    public static function resetar(string $chave): void
    {
        self::iniciarSessao();

        $ip  = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key = "rl_{$chave}_{$ip}";

        unset($_SESSION[$key]);
    }

    public static function minutosRestantes(string $chave): int
    {
        self::iniciarSessao();

        $ip    = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $key   = "rl_{$chave}_{$ip}";
        $agora = time();

        if (!isset($_SESSION[$key])) {
            return 0;
        }

        $restante = self::JANELA_SEGUNDOS - ($agora - $_SESSION[$key]['primeiro_em']);
        return max(1, (int) ceil($restante / 60));
    }

    private static function iniciarSessao(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}