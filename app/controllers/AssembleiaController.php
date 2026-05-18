<?php

require_once __DIR__ . '/../repositories/AssembleiaRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class AssembleiaController{
    private AssembleiaRepository $repo;

    public function __construct(){
        $this->repo = new AssembleiaRepository();
    }

    private function requireAuth():void{
        if(!isset($_SESSION['usuario_id'])){
            header('Location: ' . BASE_URL . '/');
            exit();
        }
    }

    private function RequireSindico(): void{
        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_privilegio'] ?? 0, [2, 4])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
    }

    public function index():void{
        $this->requireAuth();

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int)$_SESSION['usuario_id']);
        $avisos  = $this->repo->listar();
        $assembleiaRepo  = $this->repo;

        require_once __DIR__ . '/../../resources/views/assembleia/index.php';
    }

    public function salvar(): void{
        $this->RequireSindico();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: ' . BASE_URL . '/assembleia');
            exit();
        }

        if ($_POST['data'] < date('Y-m-d')) {
            $_SESSION['erro_assembleia'] = 'A data da assembleia não pode ser no passado.';
            header('Location: ' . BASE_URL . '/assembleia');
            exit();
        }

        $resultado = $this->repo->salvarAssembleia([
            'titulo'       => $_POST['titulo']            ?? '',
            'data'         => $_POST['data']              ?? '',
            'hora'         => $_POST['hora']              ?? '',
            'local'        => $_POST['local']             ?? '',
            'pauta'        => $_POST['pauta']             ?? '',
            'id_user_cad'  => (int)$_SESSION['usuario_id'],
        ]);

        if ($resultado) {
            $id_assembleia = $this->repo->ultimoId(); 
            $moradorRepo   = new MoradorRepository();
            $moradores     = $moradorRepo->findAtivos();
            $this->repo->registrarPresencasPendentes($id_assembleia, $moradores);

            header('Location: ' . BASE_URL . '/assembleia?sucesso=1');
        } else {
            $_SESSION['erro_aviso'] = 'Erro ao publicar aviso.';
            header('Location: ' . BASE_URL . '/assembleia');
        }
        exit();
    }

    public function excluir():void{
        $this->RequireSindico();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/assembleia');
            exit();
        }

        $this->repo->excluir((int)$_POST['id_assembleia']);
        header('Location: ' . BASE_URL . '/assembleia?excluido=1');
        exit();
    }

    public function confirmarPresenca(): void{
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/assembleia');
            exit();
        }

        $this->repo->confirmarPresenca(
            (int)$_POST['id_assembleia'],
            (int)$_SESSION['usuario_id'],
            $_POST['presenca']
        );

        header('Location: ' . BASE_URL . '/assembleia?presenca=' . $_POST['presenca']); // ← passa o valor real
        exit();
    }

    public function listarPresencas():void{
        if (!in_array($_SESSION['usuario_privilegio'] ?? 0, [2, 4])) {
            header('Location: ' . BASE_URL . '/assembleia');
            exit();
        }

        $repo = new MoradorRepository();
        $usuario = $repo->findById((int)$_SESSION['usuario_id']);
        $presencas = $this->repo->listarPresencas();
        $assembleias = $this->repo->listar();

        require_once __DIR__ . '/../../resources/views/assembleia/presencas.php';
    }



}