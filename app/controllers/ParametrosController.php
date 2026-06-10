<?php
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../services/ParametrosService.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class ParametrosController
{
    private ParametrosService $service;

    public function __construct()
    {
        $this->service = new ParametrosService();
    }

    public function index(): void
    {
        $usuario = $this->requereAdmin();
        $parametros = $this->service->listar();
        $totalMoradoresAtivos = (new MoradorRepository())->countMoradoresAtivos();

        require_once __DIR__ . '/../../resources/views/parametros/index.php';
    }

    public function salvar(): void
    {
        AuthGuard::requerePost('/parametros');
        $usuario = $this->requereAdmin();

        if (!$this->confirmarSenhaAdmin($usuario, $_POST['admin_senha'] ?? '')) {
            $_SESSION['erro_parametros'] = 'Senha do admin incorreta. O parametro nao foi salvo.';
            header('Location: ' . BASE_URL . '/parametros');
            exit();
        }

        $resultado = $this->service->salvarParametro(
            (string)($_POST['parametro'] ?? ''),
            $_POST['valor'] ?? null
        );
        if ($resultado['sucesso']) {
            $_SESSION['sucesso_parametros'] = 'Parametro salvo com sucesso.';
        } else {
            $_SESSION['erro_parametros'] = $resultado['mensagem'];
        }

        header('Location: ' . BASE_URL . '/parametros');
        exit();
    }

    private function requereAdmin(): array
    {
        $usuario = AuthGuard::requereUsuarioAtivo();
        if ((int)($usuario['privilegio'] ?? 0) !== 4) {
            header('Location: ' . BASE_URL . '/painel');
            exit();
        }
        return $usuario;
    }

    private function confirmarSenhaAdmin(array $usuario, string $senha): bool
    {
        if ($senha === '') {
            return false;
        }

        $admin = (new MoradorRepository())->findById((int)($usuario['id_user'] ?? $_SESSION['usuario_id'] ?? 0));
        return $admin && password_verify($senha, $admin['senha'] ?? '');
    }
}
