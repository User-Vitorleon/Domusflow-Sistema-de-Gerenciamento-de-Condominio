<?php
    require_once __DIR__ . '/../repositories/MoradorRepository.php';
class AuthGuard
{
    public static function requereUsuarioAtivo(): array
    {
        self::garantirSessao();

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int) $_SESSION['usuario_id']);

        if (!$usuario) {
            self::derrubarSessao();
            self::redirecionarParaLogin();
        }

        $status = $usuario['status'] ?? null;

        if ($status === 'P') {
            self::redirecionar('/pendente');
        }

        if ($status !== 'L') {
            self::derrubarSessao();
            $_SESSION['erro_login'] = 'Seu acesso foi encerrado. Entre em contato com a administracao.';
            self::redirecionarParaLogin();
        }

        return $usuario;
    }

    public static function requereSindicoOuAdmin(): array
    {
        return self::requerePrivilegios([2, 4]);
    }

    public static function requerePrivilegios(array $privilegiosPermitidos, string $urlRedirect = '/painel'): array
    {
        $usuario = self::requereUsuarioAtivo();
        if (!in_array((int) ($usuario['privilegio'] ?? 0), $privilegiosPermitidos, true)) {
            self::redirecionar($urlRedirect);
        }
        return $usuario;
    }

    public static function requereLogin(): void
    {
        self::garantirSessao();
    }

    public static function requerePost(string $urlRedirect): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            self::redirecionar($urlRedirect);
        }
    }

    private static function garantirSessao(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            self::redirecionarParaLogin();
        }
    }

    private static function derrubarSessao(): void
    {
        session_unset();
        session_destroy();
        session_start();
    }

    private static function redirecionarParaLogin(): void
    {
        self::redirecionar('/');
    }

    private static function redirecionar(string $caminho): void
    {
        header('Location: ' . BASE_URL . $caminho);
        exit();
    }
}
