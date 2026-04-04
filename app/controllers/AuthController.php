<?php
require_once __DIR__ . '/../services/AuthService.php';

class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        $resultado = $this->authService->login(
            $_POST['user_cpf']   ?? '',
            $_POST['user_senha'] ?? ''
        );

        if ($resultado['sucesso'] || isset($resultado['redirecionar'])) {
            header('Location: ' . $resultado['redirecionar']);
        } else {
            $_SESSION['erro_login'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/');
        }
        exit();
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();

        // Garante que cookie de sessão seja apagado
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        header('Location: ' . BASE_URL . '/');
        exit();
    }

    public function pendente(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
        require_once __DIR__ . '/../../resources/views/pendente/index.php';
    }

    public function checar(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['aprovado' => false]);
            exit();
        }
        $aprovado = $this->authService->checarAprovacao((int)$_SESSION['usuario_id']);
        header('Content-Type: application/json');
        echo json_encode(['aprovado' => $aprovado]);
        exit();
    }
}
