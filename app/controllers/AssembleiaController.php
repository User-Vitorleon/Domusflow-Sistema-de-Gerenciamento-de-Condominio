<?php
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../repositories/AssembleiaRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class AssembleiaController
{
    private AssembleiaRepository $repo;

    public function __construct()
    {
        $this->repo = new AssembleiaRepository();
    }

    public function index(): void
    {
        AuthGuard::requereUsuarioAtivo();

        $moradorRepo    = new MoradorRepository();
        $usuario        = $moradorRepo->findById((int) $_SESSION['usuario_id']);
        $avisos         = $this->repo->listar();
        $assembleiaRepo = $this->repo;

        require_once __DIR__ . '/../../resources/views/assembleia/index.php';
    }

    public function salvar(): void
    {
        $this->requireSindico();
        AuthGuard::requerePost('/assembleia');

        if (($_POST['data'] ?? '') < date('Y-m-d')) {
            $_SESSION['erro_assembleia'] = 'A data da assembleia não pode ser no passado.';
            $this->redirecionar('/assembleia');
        }

        $resultado = $this->repo->salvarAssembleia([
            'titulo'      => $_POST['titulo']            ?? '',
            'data'        => $_POST['data']              ?? '',
            'hora'        => $_POST['hora']              ?? '',
            'local'       => $_POST['local']             ?? '',
            'pauta'       => $_POST['pauta']             ?? '',
            'id_user_cad' => (int) $_SESSION['usuario_id'],
        ]);

        if (!$resultado) {
            $_SESSION['erro_aviso'] = 'Erro ao publicar aviso.';
            $this->redirecionar('/assembleia');
        }

        $idAssembleia = $this->repo->ultimoId();
        $moradorRepo  = new MoradorRepository();
        $moradores    = $moradorRepo->findAtivos();
        $this->repo->registrarPresencasPendentes($idAssembleia, $moradores);

        $this->redirecionar('/assembleia?sucesso=1');
    }

    public function excluir(): void
    {
        $this->requireSindico();
        AuthGuard::requerePost('/assembleia');

        $this->repo->excluir((int) $_POST['id_assembleia']);
        $this->redirecionar('/assembleia?excluido=1');
    }

    public function confirmarPresenca(): void
    {
        AuthGuard::requereUsuarioAtivo();
        AuthGuard::requerePost('/assembleia');

        $presenca = $_POST['presenca'] ?? '';
        $this->repo->confirmarPresenca(
            (int) $_POST['id_assembleia'],
            (int) $_SESSION['usuario_id'],
            $presenca
        );

        $this->redirecionar('/assembleia?presenca=' . urlencode($presenca));
    }

    public function listarPresencas(): void{
        if (!in_array($_SESSION['usuario_privilegio'] ?? 0, [2, 4])) {
            header('Location: ' . BASE_URL . '/assembleia');
            exit();
        }

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int)$_SESSION['usuario_id']);

        $assembleias = $this->repo->listar();
        $presencasAgrupadas = $this->repo->listarPresencasAgrupadas();

        require_once __DIR__ . '/../../resources/views/assembleia/presencas.php';
    }

    public function detalhePresencas(): void{
        if (!in_array($_SESSION['usuario_privilegio'] ?? 0, [2, 4])) {
            header('Location: ' . BASE_URL . '/assembleia');
            exit();
        }

        $idAssembleia = (int)($_GET['id'] ?? 0);
        $repo         = new MoradorRepository();
        $usuario      = $repo->findById((int)$_SESSION['usuario_id']);
        $presencas    = $this->repo->listarPresencas($idAssembleia);
        $assembleia   = $this->repo->findById($idAssembleia);

        require_once __DIR__ . '/../../resources/views/assembleia/detalhe_presencas.php';
    }

    private function requireSindico(): void
    {
        if (!isset($_SESSION['usuario_id'])
            || !in_array($_SESSION['usuario_privilegio'] ?? 0, [2, 4], true)
        ) {
            $this->redirecionar('/');
        }
    }

    private function redirecionar(string $caminho): void
    {
        header('Location: ' . BASE_URL . $caminho);
        exit();
    }
}
