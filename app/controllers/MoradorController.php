<?php
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../services/MoradorService.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class MoradorController
{
    private const ITENS_POR_PAGINA = 15;
    private const PRIVILEGIO_ADMIN = 4;

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
        AuthGuard::requerePost('/cadastro');

        $resultado = $this->service->cadastrar([
            'nome'            => $_POST['user_name']          ?? '',
            'cpf'             => $_POST['user_cpf']           ?? '',
            'apto'            => $_POST['user_apto']          ?? '',
            'bloco'           => $_POST['user_bloco']         ?? '',
            'email'           => $_POST['user_email']         ?? '',
            'telefone'        => $_POST['user_cell']          ?? '',
            'telefone_recado' => $_POST['user_recado']        ?? null,
            'senha'           => $_POST['user_senha']         ?? '',
            'conf_senha'      => $_POST['user_confirm_senha'] ?? '',
        ]);

        if ($resultado['sucesso']) {
            $this->redirecionar('/pendente');
        }

        $_SESSION['erro_cadastro'] = $resultado['mensagem'];
        $this->redirecionar('/cadastro');
    }

public function pendentes(): void
    {
        $this->requireSindico();

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int) $_SESSION['usuario_id']);

        $pagina    = max(1, (int) ($_GET['pagina'] ?? 1));
        $porPagina = self::ITENS_POR_PAGINA;
        $offset    = ($pagina - 1) * $porPagina;

        $filtros      = $this->extrairFiltrosPendentes();
        $total        = $repo->countPendentesComFiltros($filtros);
        $totalPaginas = (int) ceil($total / $porPagina);
        $moradores    = $repo->findPendentesComFiltros($filtros, $porPagina, $offset);

        require_once __DIR__ . '/../../resources/views/moradores/pendentes.php';
    }

    public function liberar(): void
    {
        AuthGuard::requerePost('/moradores/pendentes');

        $resultado = $this->service->liberarOuBloquear(
            (int) ($_POST['id_morador'] ?? 0),
            $_POST['acao']             ?? '',
            (int) $_SESSION['usuario_id']
        );

        $this->redirecionar('/moradores/pendentes?status=' . ($resultado['status'] ?? 'erro'));
    }

public function formUpdate(): void
    {
        AuthGuard::requereLogin();

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int) $_SESSION['usuario_id']);

        require_once __DIR__ . '/../../resources/views/moradores/update/index.php';
    }

    public function updateSalvar(): void
    {
        AuthGuard::requerePost('/cadastro/update');

        $resultado = $this->service->atualizar([
            'id'          => $_SESSION['usuario_id'],
            'nome'        => $_POST['user_nome']        ?? '',
            'email'       => $_POST['user_email']       ?? '',
            'apto'        => $_POST['user_apto']        ?? '',
            'bloco'       => $_POST['user_bloco']       ?? '',
            'telefone'    => $_POST['user_telefone']    ?? '',
            'tell_recado' => $_POST['user_tell_recado'] ?? '',
            'conf_senha'  => $_POST['user_conf_senha']  ?? '',
            'senha'       => $_POST['user_senha']       ?? '',
        ]);

        if ($resultado['sucesso']) {
            $this->redirecionar('/painel');
        }

        $_SESSION['erro_update'] = $resultado['mensagem'];
        $this->redirecionar('/cadastro/update');
    }

public function inativar(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        AuthGuard::requereLogin();

        $repo = new MoradorRepository();
        $repo->atualizarStatus((int) $_SESSION['usuario_id'], 'B');

        session_unset();
        session_destroy();
        session_start();
        $_SESSION['erro_login'] = 'Esta conta está inativa. Entre em contato com o síndico.';
        $this->redirecionar('/');
    }

    public function deletar(): void
    {
        AuthGuard::requereLogin();

        $this->service->deletar(['id' => $_SESSION['usuario_id']]);

        session_unset();
        session_destroy();
        $this->redirecionar('/');
    }

public function gestao(): void
    {
        $this->requireAdmin();

        $repo      = new MoradorRepository();
        $usuario   = $repo->findById((int) $_SESSION['usuario_id']);
        $moradores = $repo->findTodos();

        require_once __DIR__ . '/../../resources/views/moradores/gestao/index.php';
    }

    public function gestaoSalvar(): void
    {
        $this->requireAdmin();
        AuthGuard::requerePost('/moradores/gestao');

        $sucesso = $this->service->atualizarPrivilegio(
            (int) $_POST['id_morador'],
            (int) $_POST['privilegio']
        );

        $this->redirecionar('/moradores/gestao?' . ($sucesso ? 'sucesso=1' : 'erro=1'));
    }

private function extrairFiltrosPendentes(): array
    {
        return [
            'nome'             => trim($_GET['nome']             ?? ''),
            'bloco'            => trim($_GET['bloco']            ?? ''),
            'apto'             => trim($_GET['apto']             ?? ''),
            'cpf'              => trim($_GET['cpf']              ?? ''),
            'data_solicitacao' => trim($_GET['data_solicitacao'] ?? ''),
            'ordenar'          => trim($_GET['ordenar']          ?? 'nome'),
            'direcao'          => trim($_GET['direcao']          ?? 'asc'),
        ];
    }

    private function requireSindico(): void
    {
        if (!isset($_SESSION['usuario_id'])
            || !in_array($_SESSION['usuario_privilegio'] ?? 0, [2, 4], true)
        ) {
            $this->redirecionar('/painel');
        }
    }

    private function requireAdmin(): void
    {
        if ((int) ($_SESSION['usuario_privilegio'] ?? 0) !== self::PRIVILEGIO_ADMIN) {
            $this->redirecionar('/');
        }
    }

    private function redirecionar(string $caminho): void
    {
        header('Location: ' . BASE_URL . $caminho);
        exit();
    }
}
