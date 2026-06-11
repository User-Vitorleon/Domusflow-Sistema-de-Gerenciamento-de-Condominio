<?php
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../services/VeiculoService.php';
require_once __DIR__ . '/../services/ParametrosService.php';
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
       $usuario = AuthGuard::requerePrivilegios([1, 2, 3, 4]);

        $privilegio = (int) ($usuario['privilegio'] ?? 1);

        $repo      = new MoradorRepository();
        $moradores = [];
        $limiteVeiculosMorador = (new ParametrosService())->limiteVeiculosPorMorador();
        $totalVeiculosMorador  = 0;
        $catalogoVeiculos      = VeiculoService::catalogoMarcaModelo();

        $filtrosVeiculos = [];
        $queryVeiculos   = '';

        if ($this->ehSindicoOuAdminOuPorteiro($privilegio)) {
            $filtrosVeiculos = $this->extrairFiltrosVeiculos();
            [$veiculos, $totalPaginas, $pagina] = $this->paginarTodosVeiculos($filtrosVeiculos);
            $queryVeiculos = http_build_query(array_filter($filtrosVeiculos, static fn($valor) => $valor !== ''));
            $queryVeiculos = $queryVeiculos ? $queryVeiculos . '&' : '';
            $moradores = $repo->findAll();
        } else {
            $totalVeiculosMorador = $this->veiculoService->contarPorUsuario((int) $_SESSION['usuario_id']);
            $todos = $this->veiculoService->listarPorUsuario((int) $_SESSION['usuario_id']);
            [$veiculos, $totalPaginas, $pagina] = $this->paginar($todos);
        }

        require_once __DIR__ . '/../../resources/views/veiculo/index.php';
    }

    private function ehSindicoOuAdminOuPorteiro(int $privilegio): bool{
        return in_array($privilegio, [2, 3, 4], true);
    }

    public function consultar(): void
    {
        $usuario = AuthGuard::requerePrivilegios([3, 4]);

        $repo      = new MoradorRepository();
        $resultado = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['placa'])) {
            $resultado = $this->veiculoService->consultarPorPlaca($_POST['placa']);
        }

        require_once __DIR__ . '/../../resources/views/veiculo/consulta.php';
    }

    public function salvar(): void
    {
        $usuario = AuthGuard::requerePrivilegios([1, 2, 3, 4]);
        AuthGuard::requerePost('/veiculo');

        $resultado = $this->veiculoService->cadastrar(
            $_POST,
            (int) $_SESSION['usuario_id'],
            (int) ($usuario['privilegio'] ?? 1)
        );

        $this->respondercomResultado($resultado);
    }

    public function editar(): void
    {
        $usuario = AuthGuard::requerePrivilegios([1, 2, 3, 4]);
        AuthGuard::requerePost('/veiculo');

        $resultado = $this->veiculoService->editar(
            (int) ($_POST['id_veiculo'] ?? 0),
            $_POST,
            (int) ($usuario['privilegio'] ?? 1)
        );

        $this->respondercomResultado($resultado);
    }

    public function excluir(): void
    {
        $usuario = AuthGuard::requerePrivilegios([1, 2, 3, 4]);
        AuthGuard::requerePost('/veiculo');

        $resultado = $this->veiculoService->excluir(
            (int) ($_POST['id_veiculo'] ?? 0),
            (int) ($usuario['privilegio'] ?? 1),
            (int) $_SESSION['usuario_id']
        );

        $this->respondercomResultado($resultado);
    }

    public function principal(): void
    {
        $usuario = AuthGuard::requerePrivilegios([1, 2, 3, 4]);
        AuthGuard::requerePost('/veiculo');

        $resultado = $this->veiculoService->definirPrincipal(
            (int) ($_POST['id_veiculo'] ?? 0),
            (int) ($usuario['privilegio'] ?? 1),
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

    private function paginarTodosVeiculos(array $filtros): array
    {
        $pagina       = max(1, (int) ($_GET['pagina'] ?? 1));
        $porPagina    = self::ITENS_POR_PAGINA;
        $total        = $this->veiculoService->contarTodosComFiltros($filtros);
        $totalPaginas = max(1, (int) ceil($total / $porPagina));
        $pagina       = min($pagina, $totalPaginas);
        $offset       = ($pagina - 1) * $porPagina;

        return [
            $this->veiculoService->listarTodosComFiltros($filtros, $porPagina, $offset),
            $totalPaginas,
            $pagina,
        ];
    }

    private function extrairFiltrosVeiculos(): array
    {
        return [
            'nome'  => trim((string) ($_GET['nome'] ?? '')),
            'placa' => trim((string) ($_GET['placa'] ?? '')),
            'bloco' => trim((string) ($_GET['bloco'] ?? '')),
            'apto'  => trim((string) ($_GET['apto'] ?? '')),
            'data_cadastro' => trim((string) ($_GET['data_cadastro'] ?? '')),
        ];
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
