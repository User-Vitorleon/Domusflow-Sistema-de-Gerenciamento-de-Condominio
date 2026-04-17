<?php
require_once __DIR__ . '/../services/MoradorService.php';

class MoradorController
{
    private MoradorService $service;

    public function __construct()
    {
        $this->service = new MoradorService();
    }

    public function formCadastro(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        session_unset(); 
        
        require_once __DIR__ . '/../../resources/views/cadastro/index.php';
    }

    public function salvar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/cadastro');
            exit();
        }

        $resultado = $this->service->cadastrar([
            'nome'            => $_POST['user_name']           ?? '',
            'cpf'             => $_POST['user_cpf']            ?? '',
            'apto'            => $_POST['user_apto']           ?? '',
            'bloco'           => $_POST['user_bloco']          ?? '',
            'email'           => $_POST['user_email']          ?? '',
            'sexo'            => $_POST['user_sexo']           ?? 'M',
            'telefone'        => $_POST['user_cell']           ?? '',
            'telefone_recado' => $_POST['user_recado']         ?? null,
            'senha'           => $_POST['user_senha']          ?? '',
            'conf_senha'      => $_POST['user_confirm_senha']  ?? '',
        ]);

        if ($resultado['sucesso']) {
            header('Location: ' . BASE_URL . '/pendente');
        } else {
            $_SESSION['erro_cadastro'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/cadastro');
        }
        exit();
    }

    public function pendentes(): void
    {
        $this->requireSindico();

        $repo      = new MoradorRepository();
        $usuario   = $repo->findById((int)$_SESSION['usuario_id']);
        $moradores = $this->service->listarPendentes();

        require_once __DIR__ . '/../../resources/views/moradores/pendentes.php';
    }

    public function liberar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/moradores/pendentes');
            exit();
        }

        $resultado = $this->service->liberarOuBloquear(
            (int)($_POST['id_morador'] ?? 0),
            $_POST['acao']             ?? '',
            (int)$_SESSION['usuario_id']
        );

        header('Location: ' . BASE_URL . '/moradores/pendentes?status=' . ($resultado['status'] ?? 'erro'));
        exit();
    }

    private function requireSindico(): void
    {
        if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_previlegio'] ?? 0) != 2) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
    }

    public function formUpdate(): void 
    {
        if(!isset($_SESSION['usuario_id'])){
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        $repo    = new MoradorRepository();    
        $usuario = $repo->findById((int)$_SESSION['usuario_id']);

        require_once __DIR__ . '/../../resources/views/moradores/update/index.php';
    }

    public function updateSalvar(): void 
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: ' . BASE_URL . '/cadastro/update');
            exit();
        }

        $resultado = $this->service->atualizar ([
            'id'           => $_SESSION['usuario_id'],
            'nome'         => $_POST['user_nome'] ?? '',
            'email'        => $_POST['user_email'] ?? '',
            'apto'         => $_POST['user_apto'] ?? '',
            'bloco'        => $_POST['user_bloco'] ?? '',
            'telefone'     => $_POST['user_telefone'] ?? '',
            'tell_recado'  => $_POST['user_tell_recado'] ?? '',
            'conf_senha'   => $_POST['user_conf_senha'] ?? '',
            'senha'        => $_POST['user_senha'] ?? ''
        ]);

        if ($resultado['sucesso']) {
            header('Location: ' . BASE_URL . '/dashboard');
        } else {
            $_SESSION['erro_update'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/cadastro/update');
        }
        exit();

    }




}