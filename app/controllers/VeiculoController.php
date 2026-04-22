<?php
require_once __DIR__ . '/../services/VeiculoService.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class VeiculoController
{
    private VeiculoService $veiculoService;

    public function __construct()
    {
        $this->veiculoService = new VeiculoService();
    }

    // lista geral — síndico/porteiro veem todos, morador vê só os seus
   public function index(): void
    {
        $this->requireAuth();

        $repo     = new MoradorRepository();
        $usuario  = $repo->findById((int)$_SESSION['usuario_id']);
        $prev     = (int)($_SESSION['usuario_previlegio'] ?? 1);
        $moradores = [];

        $pagina    = (int)($_GET['pagina'] ?? 1);
        $porPagina = 10;

        if (in_array($prev, [2, 3, 4])) {
            $todos     = $this->veiculoService->listarTodos();
            $moradores = $repo->findAll();
        } else {
            $todos = $this->veiculoService->listarPorUsuario((int)$_SESSION['usuario_id']);
        }

        $total        = count($todos);
        $totalPaginas = (int)ceil($total / $porPagina);
        $offset       = ($pagina - 1) * $porPagina;
        $veiculos     = array_slice($todos, $offset, $porPagina);

        require_once __DIR__ . '/../../resources/views/veiculo/index.php';
    }

    // Consulta rápida por placa — exclusiva do porteiro
    public function consultar(): void
    {
        $this->requireAuth();

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int)$_SESSION['usuario_id']);
        $resultado = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['placa'])) {
            $resultado = $this->veiculoService->consultarPorPlaca($_POST['placa']);
        }

        require_once __DIR__ . '/../../resources/views/veiculo/consulta.php';
    }

    // Salva um novo veículo
    public function salvar(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/veiculo');
            exit();
        }

        $resultado = $this->veiculoService->cadastrar(
            $_POST,
            (int)$_SESSION['usuario_id']
        );

        if ($resultado['sucesso']) {
            header('Location: ' . BASE_URL . '/veiculo?sucesso=1');
        } else {
            $_SESSION['erro_veiculo'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/veiculo');
        }
        exit();
    }

    // Edita um veículo existente
    public function editar(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/veiculo');
            exit();
        }

        $prev      = (int)($_SESSION['usuario_previlegio'] ?? 1);
        $resultado = $this->veiculoService->editar(
            (int)$_POST['id_veiculo'],
            $_POST,
            $prev
        );

        if ($resultado['sucesso']) {
            header('Location: ' . BASE_URL . '/veiculo?sucesso=1');
        } else {
            $_SESSION['erro_veiculo'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/veiculo');
        }
        exit();
    }

    // Exclui um veículo
    public function excluir(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/veiculo');
            exit();
        }

        $prev      = (int)($_SESSION['usuario_previlegio'] ?? 1);
        $resultado = $this->veiculoService->excluir(
            (int)$_POST['id_veiculo'],
            $prev
        );

        header('Location: ' . BASE_URL . '/veiculo?sucesso=1');
        exit();
    }

    // Bloqueia acesso sem sessão ativa
    private function requireAuth(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
    }
}
