<?php
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../services/MoradorService.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class MoradorController
{
    private const ITENS_POR_PAGINA = 15;
    private const ITENS_POR_PAGINA_GESTAO = 10;
    private const PRIVILEGIO_ADMIN = 4;

    private MoradorService $service;

    public function __construct()
    {
        $this->service = new MoradorService();
    }

    public function formCadastro(): void{
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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
            'privilegio'      => (int)($_POST['user_privilegio'] ?? 1),
            'termos'          => $_POST['termos']             ?? '',
        ]);

       if ($resultado['sucesso']) {
            $this->redirecionar('/pendente');
        }

        $_SESSION['erro_cadastro']   = $resultado['mensagem'];
        $_SESSION['dados_cadastro']  = [
            'user_name'          => $_POST['user_name']          ?? '',
            'user_cpf'           => $_POST['user_cpf']           ?? '',
            'user_apto'          => $_POST['user_apto']          ?? '',
            'user_bloco'         => $_POST['user_bloco']         ?? '',
            'user_email'         => $_POST['user_email']         ?? '',
            'user_cell'          => $_POST['user_cell']          ?? '',
            'user_recado'        => $_POST['user_recado']        ?? '',
            'user_privilegio'    => $_POST['user_privilegio']    ?? '1',
        ];
        $this->redirecionar('/cadastro');

    }

    public function pendentes(): void{
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

        if (!$this->confirmarSenhaAdmin($_POST['admin_senha'] ?? '')) {
            $_SESSION['erro_pendentes'] = 'Senha incorreta. A ação não foi executada.';
            $this->redirecionar('/moradores/pendentes');
        }

        $idMorador = $this->idMoradorPorPost();

        $resultado = $this->service->liberarOuBloquear(
            $idMorador,
            $_POST['acao']             ?? '',
            (int) $_SESSION['usuario_id'],
            [
                'apto'  => $_POST['apto']  ?? '',
                'bloco' => $_POST['bloco'] ?? '',
            ]
        );

        if (!$resultado['sucesso']) {
            $_SESSION['erro_pendentes'] = $resultado['mensagem'];
            $this->redirecionar('/moradores/pendentes');
        }

        $this->redirecionar('/moradores/pendentes?status=' . $resultado['status']);

    }

public function formUpdate(): void
    {
        AuthGuard::requereUsuarioAtivo();

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int) $_SESSION['usuario_id']);

        require_once __DIR__ . '/../../resources/views/moradores/update/index.php';
    }

    public function updateSalvar(): void
    {
        AuthGuard::requerePost('/cadastro/update');

        $repo = new MoradorRepository();
        $usuarioAtual = $repo->findById((int) $_SESSION['usuario_id']);

        $resultado = $this->service->atualizar([
            'id'          => $_SESSION['usuario_id'],
            'nome'        => $_POST['user_nome']        ?? '',
            'email'       => $_POST['user_email']       ?? '',
            'apto'        => $usuarioAtual['apto']      ?? '',
            'bloco'       => $usuarioAtual['bloco']     ?? '',
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
        AuthGuard::requereUsuarioAtivo();

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
        AuthGuard::requereUsuarioAtivo();

        $this->service->deletar(['id' => $_SESSION['usuario_id']]);

        session_unset();
        session_destroy();
        $this->redirecionar('/');
    }

    public function gestao(): void{
        $this->requireAdmin();

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int) $_SESSION['usuario_id']);

        $pagina    = max(1, (int) ($_GET['pagina'] ?? 1));
        $porPagina = self::ITENS_POR_PAGINA_GESTAO;
        $offset    = ($pagina - 1) * $porPagina;

        $statusFiltro = trim($_GET['status'] ?? '');
        if (!in_array($statusFiltro, ['L', 'P', 'I', 'B', 'E'], true)) {
            $statusFiltro = '';
        }

        $filtros   = [
            'nome'   => trim($_GET['nome']   ?? ''),
            'apto'   => trim($_GET['apto']   ?? ''),
            'bloco'  => trim($_GET['bloco']  ?? ''),
            'status' => $statusFiltro,
            'perfil' => trim($_GET['perfil'] ?? ''),
            'foco'   => (int) ($_GET['foco'] ?? 0),
        ];
        $total        = $repo->countTodosComFiltros($filtros);
        $totalPaginas = (int) ceil($total / $porPagina);
        $moradores    = $repo->findTodosComFiltros($filtros, $porPagina, $offset);

        require_once __DIR__ . '/../../resources/views/moradores/gestao/index.php';
    }

    public function resetarSenha(): void{
        $this->requireAdmin();
        AuthGuard::requerePost('/moradores/gestao');

        $idMorador = $this->idMoradorPorPost();
        if ($this->alvoEhAdmin($idMorador)) {
            $this->redirecionarGestaoComFoco($idMorador, 'erro=1');
        }
        if (!$this->confirmarSenhaAdmin($_POST['admin_senha'] ?? '')) {
            $this->redirecionarGestaoComFoco($idMorador, 'senha=1');
        }

        $resultado = ($idMorador > 0)
            ? $this->service->resetarSenha($idMorador, true)
            : ['sucesso' => false];

        $this->redirecionarGestaoComFoco($idMorador, $resultado['sucesso'] ? 'reset=1' : 'erro=1');
    }

    public function gestaoSalvar(): void
    {
        $this->requireAdmin();
        AuthGuard::requerePost('/moradores/gestao');


        $idMorador  = $this->idMoradorPorPost();
        $privilegio = (int) ($_POST['privilegio']  ?? 0);
        $apto       = $_POST['apto']  ?? '';
        $bloco      = $_POST['bloco'] ?? '';

        $repo = new MoradorRepository();
        $moradorAlvo = $repo->findById($idMorador);
        if (!$moradorAlvo || (int) ($moradorAlvo['privilegio'] ?? 0) === self::PRIVILEGIO_ADMIN) {
            $this->redirecionarGestaoComFoco($idMorador, 'erro=1');
        }

        if (!$this->confirmarSenhaAdmin($_POST['admin_senha'] ?? '')) {
            $this->redirecionarGestaoComFoco($idMorador, 'senha=1');
        }

        $sucesso = ($idMorador > 0)
            ? $this->service->atualizarPrivilegioEUnidade($idMorador, $privilegio, $apto, $bloco)
            : false;

        $this->redirecionarGestaoComFoco($idMorador, $sucesso ? 'sucesso=1' : 'erro=1');
    }

    public function gestaoStatus(): void
    {
        $this->requireAdmin();
        AuthGuard::requerePost('/moradores/gestao');

        $idMorador = $this->idMoradorPorPost();
        if ($idMorador === (int) ($_SESSION['usuario_id'] ?? 0)) {
            $this->redirecionarGestaoComFoco($idMorador, 'erro=1');
        }
        if ($this->alvoEhAdmin($idMorador)) {
            $this->redirecionarGestaoComFoco($idMorador, 'erro=1');
        }
        if (!$this->confirmarSenhaAdmin($_POST['admin_senha'] ?? '')) {
            $this->redirecionarGestaoComFoco($idMorador, 'senha=1');
        }

        $resultado = $this->service->atualizarStatusGestao(
            $idMorador,
            $_POST['status'] ?? ''
        );

        $this->redirecionarGestaoComFoco($idMorador, $resultado['sucesso'] ? 'status_ok=1' : 'erro=1');
    }

    public function gestaoDeletar(): void
    {
        $this->requireAdmin();
        AuthGuard::requerePost('/moradores/gestao');

        $idMorador = $this->idMoradorPorPost();
        if ($idMorador <= 0 || $idMorador === (int) ($_SESSION['usuario_id'] ?? 0)) {
            $this->redirecionarGestaoComFoco($idMorador, 'erro=1');
        }
        if ($this->alvoEhAdmin($idMorador)) {
            $this->redirecionarGestaoComFoco($idMorador, 'erro=1');
        }
        if (!$this->confirmarSenhaAdmin($_POST['admin_senha'] ?? '')) {
            $this->redirecionarGestaoComFoco($idMorador, 'senha=1');
        }

        $resultado = $this->service->deletar(['id' => $idMorador]);

        $this->redirecionarGestaoComFoco($idMorador, $resultado['sucesso'] ? 'excluido=1' : 'erro=1');
    }

    private function redirecionarGestaoComFoco(int $idMorador, string $resultado): void
    {
        $query = $resultado;
        if ($idMorador > 0) {
            $query .= '&foco=' . $idMorador;
        }

        $this->redirecionar('/moradores/gestao?' . $query);
    }

    private function confirmarSenhaAdmin(string $senha): bool
    {
        if ($senha === '') {
            return false;
        }

        $repo  = new MoradorRepository();
        $admin = $repo->findById((int) ($_SESSION['usuario_id'] ?? 0));

        return $admin && password_verify($senha, $admin['senha'] ?? '');
    }

    private function alvoEhAdmin(int $idMorador): bool
    {
        if ($idMorador <= 0) {
            return true;
        }

        $repo = new MoradorRepository();
        $morador = $repo->findById($idMorador);

        return !$morador || (int) ($morador['privilegio'] ?? 0) === self::PRIVILEGIO_ADMIN;
    }

    public function cpf(): void
    {
        $this->requireSindico();
        header('Content-Type: application/json; charset=utf-8');

        $uuid = trim($_GET['uuid'] ?? '');
        $repo = new MoradorRepository();
        $morador = $uuid !== '' ? $repo->findByUuid($uuid) : null;

        if (!$morador) {
            echo json_encode(['sucesso' => false]);
            exit();
        }

        $cpf = preg_replace('/\D/', '', (string) $morador['cpf']);
        echo json_encode([
            'sucesso' => true,
            'cpf' => preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf),
        ]);
        exit();
    }

    private function idMoradorPorPost(): int
    {
        $uuid = trim($_POST['uuid_morador'] ?? '');
        if ($uuid !== '') {
            $repo = new MoradorRepository();
            $morador = $repo->findByUuid($uuid);
            return (int) ($morador['id_user'] ?? 0);
        }

        return (int) ($_POST['id_morador'] ?? 0);
    }

private function extrairFiltrosPendentes(): array
    {
        return [
            'nome'             => trim($_GET['nome']             ?? ''),
            'bloco'            => trim($_GET['bloco']            ?? ''),
            'apto'             => trim($_GET['apto']             ?? ''),
            'cpf'              => trim($_GET['cpf']              ?? ''),
            'data_solicitacao' => trim($_GET['data_solicitacao'] ?? ''),
            'ordenar'          => trim($_GET['ordenar']          ?? 'data_solicitacao'),
            'direcao'          => trim($_GET['direcao']          ?? 'asc'),
            'perfil'           => trim($_GET['perfil'] ?? ''),
        ];
    }

    private function requireSindico(): void
    {
        if (!isset($_SESSION['usuario_id'])
            || !in_array((int) ($_SESSION['usuario_privilegio'] ?? 0), [2, 4], true)
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
