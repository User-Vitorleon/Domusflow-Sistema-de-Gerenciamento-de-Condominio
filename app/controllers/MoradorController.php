<?php
require_once __DIR__ . '/../services/MoradorService.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

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

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int)$_SESSION['usuario_id']);

        $pagina = max(1, (int)($_GET['pagina'] ?? 1));
        $porPagina = 15;

        $filtros = [
            'nome' => trim($_GET['nome'] ?? ''),
            'bloco' => trim($_GET['bloco'] ?? ''),
            'apto' => trim($_GET['apto'] ?? ''),
            'cpf' => trim($_GET['cpf'] ?? ''),
            'data_solicitacao' => trim($_GET['data_solicitacao'] ?? ''),
            'ordenar' => trim($_GET['ordenar'] ?? 'nome'),
            'direcao' => trim($_GET['direcao'] ?? 'asc'),
        ];

        $total = $repo->countPendentesComFiltros($filtros);
        $totalPaginas = (int)ceil($total / $porPagina);
        $offset = ($pagina - 1) * $porPagina;

        $moradores = $repo->findPendentesComFiltros($filtros, $porPagina, $offset);

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
        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_previlegio'] ?? 0, [2, 4])) {
            header('Location: ' . BASE_URL . '/painel');
            exit();
        }
    }

    public function formUpdate(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int)$_SESSION['usuario_id']);

        require_once __DIR__ . '/../../resources/views/moradores/update/index.php';
    }

    public function updateSalvar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/cadastro/update');
            exit();
        }

        $resultado = $this->service->atualizar([
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
            header('Location: ' . BASE_URL . '/painel');
        } else {
            $_SESSION['erro_update'] = $resultado['mensagem'];
            header('Location: ' . BASE_URL . '/cadastro/update');
        }
        exit();
    }

    public function inativar(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        $repo = new MoradorRepository();
        $id = $_SESSION['usuario_id'];
        $repo->atualizarStatus($id, 'B');

        session_unset();
        session_destroy();
        session_start();
        $_SESSION['erro_login'] = 'Esta conta está inativa. Entre em contato com o síndico.';
        header('Location: ' . BASE_URL . '/');
        exit();
    }

    public function deletar(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
        $this->service->deletar([
            'id'         => $_SESSION['usuario_id'],
            'nome'       => '***',
            'email'      => '***',
            'apto'       => '***',
            'bloco'      => '***',
            'telefone'   => '***',
            'tell_recado' => '***',
            'senha'      => '***',
            'cpf'        => '***'
        ]);

        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/');
        exit();
    }
}
