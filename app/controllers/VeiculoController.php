<<<<<<< HEAD
]<?php
    require_once __DIR__ . '/../services/VeiculoService.php';
    require_once __DIR__ . '/../repositories/MoradorRepository.php';

    class VeiculoController
    {
        private VeiculoService $veiculoService;

        public function __construct()
        {
            $this->veiculoService = new VeiculoService();
        }

        public function index(): void
        {
            $this->requireAuth();

            $prev = (int)($_SESSION['usuario_privilegio'] ?? 1);

            // Porteiro não tem acesso ao cadastro
            if ($prev == 3) {
                header('Location: ' . BASE_URL . '/painel');
                exit();
            }

            $repo      = new MoradorRepository();
            $usuario   = $repo->findById((int)$_SESSION['usuario_id']);
            $moradores = [];

            $pagina    = (int)($_GET['pagina'] ?? 1);
            $porPagina = 10;

            if (in_array($prev, [2, 4])) {
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
                (int)$_SESSION['usuario_id'],
                (int)($_SESSION['usuario_privilegio'] ?? 1)
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

            $prev      = (int)($_SESSION['usuario_privilegio'] ?? 1);
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

            $prev       = (int)($_SESSION['usuario_privilegio'] ?? 1);
            $id_veiculo = (int)$_POST['id_veiculo'];
            $id_user    = (int)$_SESSION['usuario_id'];

            $resultado = $this->veiculoService->excluir($id_veiculo, $prev, $id_user);

            if ($resultado['sucesso']) {
                header('Location: ' . BASE_URL . '/veiculo?sucesso=1');
            } else {
                $_SESSION['erro_veiculo'] = $resultado['mensagem'];
                header('Location: ' . BASE_URL . '/veiculo');
            }
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
=======
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

    public function index(): void
    {
        AuthGuard::requereLogin();

        $privilegio = (int) ($_SESSION['usuario_privilegio'] ?? 1);

        if ($privilegio === self::PRIVILEGIO_PORTEIRO) {
            $this->redirecionar('/painel');
        }

        $repo      = new MoradorRepository();
        $usuario   = $repo->findById((int) $_SESSION['usuario_id']);
        $moradores = [];

        if ($this->ehSindicoOuAdmin($privilegio)) {
            $todos     = $this->veiculoService->listarTodos();
            $moradores = $repo->findAll();
        } else {
            $todos = $this->veiculoService->listarPorUsuario((int) $_SESSION['usuario_id']);
        }

        [$veiculos, $totalPaginas, $pagina] = $this->paginar($todos);

        require_once __DIR__ . '/../../resources/views/veiculo/index.php';
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
