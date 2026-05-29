<?php
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../services/VeiculoService.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class VeiculoController
{
    private const ITENS_POR_PAGINA   = 10;
    private const PRIVILEGIO_PORTEIRO = 3;

    private VeiculoService $veiculoService;

    public function __construct()
    {
        $this->veiculoService = new VeiculoService();
    }

    public function index(): void{
        AuthGuard::requereLogin();

        $privilegio = (int) ($_SESSION['usuario_privilegio'] ?? 1);

        $repo      = new MoradorRepository();
        $usuario   = $repo->findById((int) $_SESSION['usuario_id']);
        $moradores = [];

        if ($this->ehSindicoOuAdminOuPorteiro($privilegio)) {
            $todos     = $this->veiculoService->listarTodos();
            $moradores = $repo->findAll();
        } else {
            $todos = $this->veiculoService->listarPorUsuario((int) $_SESSION['usuario_id']);
        }

        [$veiculos, $totalPaginas, $pagina] = $this->paginar($todos);

        require_once __DIR__ . '/../../resources/views/veiculo/index.php';
    }

    private function ehSindicoOuAdminOuPorteiro(int $privilegio): bool{
        return in_array($privilegio, [2, 3, 4], true);
    }

    public function consultar(): void
    {
        AuthGuard::requereLogin();

        $repo      = new MoradorRepository();
        $usuario   = $repo->findById((int) $_SESSION['usuario_id']);
        $resultado = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['placa'])) {
            $resultado = $this->veiculoService->consultarPorPlaca($_POST['placa']);
        }

        require_once __DIR__ . '/../../resources/views/veiculo/consulta.php';
    }

    public function salvar(): void
    {
        AuthGuard::requereLogin();
        AuthGuard::requerePost('/veiculo');

        $resultado = $this->veiculoService->cadastrar(
            $_POST,
            (int) $_SESSION['usuario_id'],
            (int) ($_SESSION['usuario_privilegio'] ?? 1)
        );

        $this->respondercomResultado($resultado);
    }

    public function editar(): void
    {
        AuthGuard::requereLogin();
        AuthGuard::requerePost('/veiculo');

        $resultado = $this->veiculoService->editar(
            (int) ($_POST['id_veiculo'] ?? 0),
            $_POST,
            (int) ($_SESSION['usuario_privilegio'] ?? 1)
        );

        $this->respondercomResultado($resultado);
    }

    public function excluir(): void
    {
        AuthGuard::requereLogin();
        AuthGuard::requerePost('/veiculo');

        $resultado = $this->veiculoService->excluir(
            (int) ($_POST['id_veiculo'] ?? 0),
            (int) ($_SESSION['usuario_privilegio'] ?? 1),
            (int) $_SESSION['usuario_id']
        );

        $this->respondercomResultado($resultado);
    }

    private function paginar(array $todos): array
    {
        $pagina       = max(1, (int) ($_GET['pagina'] ?? 1));
        $porPagina    = self::ITENS_POR_PAGINA;
        $totalPaginas = (int) ceil(count($todos) / $porPagina);
        $offset       = ($pagina - 1) * $porPagina;

        return [array_slice($todos, $offset, $porPagina), $totalPaginas, $pagina];
    }

    private function respondercomResultado(array $resultado): void
    {
        if ($resultado['sucesso']) {
            $this->redirecionar('/veiculo?sucesso=1');
        }
        $_SESSION['erro_veiculo'] = $resultado['mensagem'];
        $this->redirecionar('/veiculo');
    }

    private function ehSindicoOuAdmin(int $privilegio): bool
    {
        return in_array($privilegio, [2, 4], true);
    }

    private function redirecionar(string $caminho): void
    {
        header('Location: ' . BASE_URL . $caminho);
        exit();
    }
}
