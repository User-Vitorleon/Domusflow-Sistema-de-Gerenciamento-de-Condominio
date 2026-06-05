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
        $this->requereAdmin();

        $resultado = $this->service->salvar($_POST);
        if ($resultado['sucesso']) {
            $_SESSION['sucesso_parametros'] = 'Parametros salvos com sucesso.';
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
}
