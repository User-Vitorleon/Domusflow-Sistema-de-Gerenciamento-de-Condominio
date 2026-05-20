<?php
<<<<<<< HEAD

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
=======
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../repositories/AvisosRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class AvisosController
{
    private AvisosRepository $repo;

    public function __construct()
    {
        $this->repo = new AvisosRepository();
    }

    public function index(): void
    {
        AuthGuard::requereLogin();

        $moradorRepo = new MoradorRepository();
        $usuario     = $moradorRepo->findById((int) $_SESSION['usuario_id']);
        $avisos      = $this->repo->listar();

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $_SESSION['avisos_visto_em'] = date('Y-m-d H:i:s');

        require_once __DIR__ . '/../../resources/views/avisos/index.php';
    }

<<<<<<< HEAD
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
=======
    public function salvar(): void
    {
        $this->requireSindico();
        AuthGuard::requerePost('/avisos');

        $resultado = $this->repo->salvarAvisos([
            'titulo'      => $_POST['titulo']   ?? '',
            'mensagem'    => $_POST['mensagem'] ?? '',
            'id_user_cad' => (int) $_SESSION['usuario_id'],
        ]);

        if ($resultado) {
            $this->redirecionar('/avisos?sucesso=1');
        }

        $_SESSION['erro_aviso'] = 'Erro ao publicar aviso.';
        $this->redirecionar('/avisos');
    }

    public function excluir(): void
    {
        $this->requireSindico();
        AuthGuard::requerePost('/avisos');

        $this->repo->excluirAvisos((int) $_POST['id_aviso']);
        $this->redirecionar('/avisos?excluido=1');
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
