<?php
require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/../services/MoradorService.php';


class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(): void
    {
        AuthGuard::requerePost('/');

        $resultado = $this->authService->login(
            $_POST['user_cpf']   ?? '',
            $_POST['user_senha'] ?? ''
        );

        if (isset($resultado['redirecionar'])) {
            header('Location: ' . $resultado['redirecionar']);
            exit();
        }

        $_SESSION['erro_login'] = $resultado['mensagem'];
        header('Location: ' . BASE_URL . '/');
        exit();
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->limparCookieSessao();

        header('Location: ' . BASE_URL . '/');
        exit();
    }

    public function pendente(): void
    {
        AuthGuard::requereLogin();
        require_once __DIR__ . '/../../resources/views/pendente/index.php';
    }

    public function checar(): void
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['aprovado' => false]);
            exit();
        }

        $aprovado = $this->authService->checarAprovacao((int) $_SESSION['usuario_id']);
        echo json_encode(['aprovado' => $aprovado]);
        exit();
    }

    private function limparCookieSessao(): void
    {
        if (!ini_get('session.use_cookies')) {
            return;
        }
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    public function recuperarSenha(): void{
        if (session_status() === PHP_SESSION_NONE) session_start();
        require_once __DIR__ . '/../../resources/views/home/recuperar-senha.php';
    }

    public function enviarRecuperacao(): void{
        AuthGuard::requerePost('/recuperar-senha');
        require_once __DIR__ . '/../helpers/RateLimiter.php';

        $chave = 'recuperar_senha';

        if (!RateLimiter::verificar($chave)) {
            $minutos = RateLimiter::minutosRestantes($chave);
            $_SESSION['erro_recuperacao'] = "Muitas tentativas. Tente novamente em {$minutos} minuto(s).";
            header('Location: ' . BASE_URL . '/recuperar-senha');
            exit();
        }

        $cpf     = preg_replace('/[^0-9]/', '', $_POST['user_cpf'] ?? '');
        $repo    = new MoradorRepository();
        $morador = $repo->findByCpf($cpf);

        $mensagemGenerica = 'Se o CPF informado estiver cadastrado e ativo, você receberá um e-mail com a nova senha.';

        if (!$morador || $morador['status'] !== 'L') {
            RateLimiter::registrarFalha($chave);
            $_SESSION['sucesso_recuperacao'] = $mensagemGenerica;
            header('Location: ' . BASE_URL . '/recuperar-senha');
            exit();
        }

        $service = new MoradorService();
        $service->resetarSenha((int) $morador['id_user']);

        RateLimiter::resetar($chave);
        $_SESSION['sucesso_recuperacao'] = $mensagemGenerica;
        header('Location: ' . BASE_URL . '/recuperar-senha');
        exit();
    }
}
