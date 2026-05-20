<?php
require_once __DIR__ . '/../services/AuthService.php';
<<<<<<< HEAD
=======
require_once __DIR__ . '/../middleware/AuthGuard.php';
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(): void
    {
<<<<<<< HEAD
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
=======
        AuthGuard::requerePost('/');
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        $resultado = $this->authService->login(
            $_POST['user_cpf']   ?? '',
            $_POST['user_senha'] ?? ''
        );

<<<<<<< HEAD
        if ($resultado['sucesso'] || isset($resultado['redirecionar'])) {
            header('Location: ' . $resultado['redirecionar']);
        } else {
            $_SESSION['erro_login'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/');
        }
=======
        if (isset($resultado['redirecionar'])) {
            header('Location: ' . $resultado['redirecionar']);
            exit();
        }

        $_SESSION['erro_login'] = $resultado['mensagem'];
        header('Location: ' . BASE_URL . '/');
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        exit();
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
<<<<<<< HEAD

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
=======
        $this->limparCookieSessao();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        header('Location: ' . BASE_URL . '/');
        exit();
    }

    public function pendente(): void
    {
<<<<<<< HEAD
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
=======
        AuthGuard::requereLogin();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        require_once __DIR__ . '/../../resources/views/pendente/index.php';
    }

    public function checar(): void
    {
<<<<<<< HEAD
=======
        header('Content-Type: application/json');

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['aprovado' => false]);
            exit();
        }
<<<<<<< HEAD
        $aprovado = $this->authService->checarAprovacao((int)$_SESSION['usuario_id']);
        header('Content-Type: application/json');
        echo json_encode(['aprovado' => $aprovado]);
        exit();
    }
=======

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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
}
