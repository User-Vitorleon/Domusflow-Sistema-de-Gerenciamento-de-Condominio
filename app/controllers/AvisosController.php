<?php

require_once __DIR__ . '/../repositories/AvisosRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class AvisosController{
    private AvisosRepository $repo;

    public function __construct(){
        $this->repo = new AvisosRepository();
    }

    private function requireAuth():void{
        if(!isset($_SESSION['usuario_id'])){
            header('Location: ' . BASE_URL . '/');
            exit();
        }
    }

    private function RequireSindico(): void{
        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_previlegio'] ?? 0, [2, 4])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
    }

    public function index():void{
        $this->requireAuth();

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int)$_SESSION['usuario_id']);
        $avisos  = $this->repo->listar();
        $_SESSION['avisos_visto_em'] = date('Y-m-d H:i:s');

        require_once __DIR__ . '/../../resources/views/avisos/index.php';
    }

    public function salvar(): void{
        $this->RequireSindico();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: ' . BASE_URL . '/avisos');
            exit();
        }

        $resultado = $this->repo->salvarAvisos([
            'titulo'      => $_POST['titulo']    ?? '',
            'mensagem'    => $_POST['mensagem']  ?? '',
            'id_user_cad' => (int)$_SESSION['usuario_id'],
        ]);

        if ($resultado) {
            header('Location: ' . BASE_URL . '/avisos?sucesso=1');
        } else {
            $_SESSION['erro_aviso'] = 'Erro ao publicar aviso.';
            header('Location: ' . BASE_URL . '/avisos');
        }
        exit();
    }
    
    public function excluir():void{
        $this->RequireSindico();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/avisos');
            exit();
        }

        $this->repo->excluirAvisos((int)$_POST['id_aviso']);
        header('Location: ' . BASE_URL . '/avisos?excluido=1');
        exit();
    }





}

?>