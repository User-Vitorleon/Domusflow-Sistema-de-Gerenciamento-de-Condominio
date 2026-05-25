<?php
require_once __DIR__ . '/../middleware/AuthGuard.php';
require_once __DIR__ . '/../repositories/FinancasRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class FinancasController
{
    private const ITENS_POR_PAGINA = 10;
    private const PRIVILEGIO_SINDICO = 2;

    private FinancasRepository $repo;

    public function __construct()
    {
        $this->repo = new FinancasRepository();
    }

public function taxasCad(): void
    {
        $this->requireSindico();

        $moradorRepo = new MoradorRepository();
        $usuario     = $moradorRepo->findById((int) $_SESSION['usuario_id']);
        $taxas       = $this->repo->taxasCad();

        require_once __DIR__ . '/../../resources/views/financas/taxas/index.php';
    }

    public function salvarTaxas(): void
    {
        $this->requireSindico();
        AuthGuard::requerePost('/financeiro/taxas');

        $resultado = $this->repo->salvarTaxas([
            'descricao' => $_POST['descricao'] ?? '',
            'valor'     => $_POST['valor']     ?? '',
            'modulo'    => $_POST['modulo']    ?? '',
        ]);

        if (!$resultado) {
            $_SESSION['erro_taxa'] = 'Erro ao cadastrar taxa.';
        }
        $this->redirecionar('/financeiro/taxas');
    }

    public function excluirTaxa(): void
    {
        $this->requireSindico();
        AuthGuard::requerePost('/financeiro/taxas');

        $this->repo->excluirTaxa((int) ($_POST['id_taxa'] ?? 0));
        $this->redirecionar('/financeiro/taxas?excluido=1');
    }

public function lancamento(): void
    {
        AuthGuard::requereLogin();

        $idUser     = (int) $_SESSION['usuario_id'];
        $privilegio = (int) $_SESSION['usuario_privilegio'];

        $filtros   = $this->extrairFiltrosLancamento();
        $pagina    = max(1, (int) ($_GET['pagina'] ?? 1));
        $porPagina = self::ITENS_POR_PAGINA;
        $offset    = ($pagina - 1) * $porPagina;

        $total        = $this->repo->countLancamentos(
            $idUser, $privilegio,
            $filtros['busca'], $filtros['status'], $filtros['dt_lanc'], $filtros['dt_venc'], $filtros['atraso']
        );
        $totalPaginas = (int) ceil($total / $porPagina);

        $lancamentos = $this->repo->lancamento(
            $idUser, $privilegio, $offset, $porPagina,
            $filtros['busca'], $filtros['status'], $filtros['dt_lanc'], $filtros['dt_venc'], $filtros['atraso']
        );

        $todasTaxas  = $this->repo->listarTodasTaxasAtivas();
        $moradorRepo = new MoradorRepository();
        $usuario     = $moradorRepo->findById($idUser);
        $moradores   = $moradorRepo->findAtivos();

        require_once __DIR__ . '/../../resources/views/financas/lancamento/index.php';
    }

    public function salvarLancamento(): void
    {
        $this->requireSindico();
        AuthGuard::requerePost('/financeiro/lancamento');

        $dados = [
            'modelo'    => $_POST['modelo']    ?? '',
            'valor'     => $_POST['valor']     ?? '',
            'descricao' => $_POST['descricao'] ?? '',
            'data_venc' => $_POST['data_venc'] ?? '',
            'data_lanc' => $_POST['data_lanc'] ?? '',
        ];

        $erro = $this->validarDatasLancamento($dados);
        if ($erro !== null) {
            $_SESSION['erro_lancamento'] = $erro;
            $this->redirecionar('/financeiro/lancamento');
        }

        if (isset($_POST['todos_moradores'])) {
            $this->lancarParaTodos($dados);
        } else {
            $this->lancarParaUm($dados, (int) ($_POST['id_user'] ?? 0));
        }

        $this->redirecionar('/financeiro/lancamento');
    }

    public function excluirLancamento(): void
    {
        $this->requireSindico();
        AuthGuard::requerePost('/financeiro/lancamento');

        $this->repo->excluirLancamento((int) ($_POST['id_lancamento'] ?? 0));
        $this->redirecionar('/financeiro/lancamento?excluido=1');
    }

public function historico(): void
    {
        AuthGuard::requereLogin();

        $idUser    = (int) $_SESSION['usuario_id'];
        $historico = $this->repo->historico($idUser);

        $moradorRepo = new MoradorRepository();
        $usuario     = $moradorRepo->findById($idUser);

        require_once __DIR__ . '/../../resources/views/financas/historico/index.php';
    }

    public function gerarFatura(): void
    {
        AuthGuard::requereLogin();
        AuthGuard::requerePost('/financeiro/historico');

        $idUserAlvo = (int) ($_POST['id_user'] ?? 0);
        $valorTotal = $this->repo->totalPendente($idUserAlvo);
        $destino    = $this->destinoAposFatura();

        if ($valorTotal <= 0) {
            $_SESSION['erro_fatura'] = 'Nenhuma pendência encontrada.';
            $this->redirecionar($destino);
        }

        $sucesso = $this->repo->gerarFatura(
            (int) $_SESSION['usuario_id'],
            [
                'id_user'   => $idUserAlvo,
                'data'      => date('Y-m-d'),
                'valor'     => $valorTotal,
                'descricao' => $_POST['descricao'] ?? 'Fatura gerada automaticamente',
            ]
        );

        if ($sucesso) {
            $_SESSION['sucesso_fatura'] =
                'Fatura gerada com sucesso! Valor: R$ ' . number_format($valorTotal, 2, ',', '.');
        } else {
            $_SESSION['erro_fatura'] = 'Erro ao gerar fatura.';
        }

        $this->redirecionar($destino);
    }

    private function requireAuth(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }
    }

    public function gerarBoleto(): void
    {
        AuthGuard::requereUsuarioAtivo();

        $idLancamento = (int)($_GET['id'] ?? 0);

        if (!$idLancamento) {
            $this->redirecionar('/financeiro/historico');
        }

        $lancamento = $this->repo->findLancamentoById($idLancamento);

        if (!$lancamento || !in_array($lancamento['status'], ['F', 'G'])) {
            $this->redirecionar('/financeiro/historico');
        }

        if ($lancamento['id_user'] !== (int)$_SESSION['usuario_id']) {
            $this->redirecionar('/financeiro/historico');
        }

        require_once __DIR__ . '/../../resources/views/financas/boleto.php';
    }

    public function confirmarPagamento(): void{
        AuthGuard::requereUsuarioAtivo();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirecionar('/financeiro/historico');
        }

        $idLancamento = (int)($_POST['id_lancamento'] ?? 0);
        $lancamento   = $this->repo->findLancamentoById($idLancamento);

        if (!$lancamento || $lancamento['id_user'] !== (int)$_SESSION['usuario_id']) {
            $this->redirecionar('/financeiro/historico');
        }

        $this->repo->marcarComoPago($idLancamento);

        $_SESSION['sucesso_fatura'] = 'Pagamento confirmado com sucesso!';
        $this->redirecionar('/financeiro/historico');
    }
    
    public function gerarFaturaUnica(): void{
        AuthGuard::requereUsuarioAtivo();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/financeiro/historico');
            exit();
        }

        $idLancamento = (int)($_POST['id_lancamento'] ?? 0);
        $resultado    = $this->repo->gerarFaturaUnica(
            (int)$_SESSION['usuario_id'],
            $idLancamento
        );

        if ($resultado) {
            $_SESSION['sucesso_fatura'] = 'Fatura gerada com sucesso!';
        } else {
            $_SESSION['erro_fatura'] = 'Erro ao gerar fatura.';
        }

        header('Location: ' . BASE_URL . '/financeiro/historico');
        exit();
    }

    public function gerarFaturaTodos(): void
    {
        $this->requireSindico();
        AuthGuard::requerePost('/financeiro/lancamento');

        $moradorRepo = new MoradorRepository();
        $moradores   = $moradorRepo->findAtivos();
        $gerados     = 0;

        foreach ($moradores as $morador) {
            $valorTotal = $this->repo->totalPendente($morador['id_user']);
            if ($valorTotal <= 0) {
                continue;
            }
            $this->repo->gerarFatura(
                (int) $_SESSION['usuario_id'],
                [
                    'id_user'   => $morador['id_user'],
                    'data'      => date('Y-m-d'),
                    'valor'     => $valorTotal,
                    'descricao' => 'Fatura gerada automaticamente',
                ]
            );
            $gerados++;
        }

        $_SESSION['sucesso_fatura'] = "Faturas geradas para {$gerados} morador(es)!";
        $this->redirecionar('/financeiro/lancamento');
    }

    public function verificarDuplicado(): void
    {
        header('Content-Type: application/json');

        $modelo    = $_POST['modelo']    ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $dataVenc  = $_POST['data_venc'] ?? '';

        if (isset($_POST['todos_moradores'])) {
            $moradorRepo = new MoradorRepository();
            $moradores   = $moradorRepo->findAtivos();
            $duplicados  = 0;

            foreach ($moradores as $morador) {
                if ($this->repo->existeLancamentoNoMes($modelo, $descricao, $morador['id_user'], $dataVenc)) {
                    $duplicados++;
                }
            }
            echo json_encode(['duplicado' => $duplicados > 0, 'quantidade' => $duplicados]);
            exit();
        }

        $idUser    = (int) ($_POST['id_user'] ?? 0);
        $duplicado = $this->repo->existeLancamentoNoMes($modelo, $descricao, $idUser, $dataVenc);
        echo json_encode(['duplicado' => $duplicado]);
        exit();
    }

    private function extrairFiltrosLancamento(): array
    {
        return [
            'busca'   => $_GET['busca']   ?? '',
            'status'  => $_GET['status']  ?? '',
            'dt_lanc' => $_GET['dt_lanc'] ?? '',
            'dt_venc' => $_GET['dt_venc'] ?? '',
            'atraso'  => $_GET['atraso']  ?? '',
        ];
    }

    private function validarDatasLancamento(array $dados): ?string{
        if (empty($dados['data_lanc']) || empty($dados['data_venc'])) {
            return 'As datas de lançamento e vencimento são obrigatórias.';
        }
        if ($dados['data_lanc'] < date('Y-m-d')) {
            return 'A data de lançamento não pode ser inferior ao dia de hoje.';
        }
        if ($dados['data_venc'] <= date('Y-m-d')) {
            return 'A data de vencimento deve ser superior ao dia de hoje.';
        }
        return null;
    }

    private function lancarParaTodos(array $dados): void
    {
        $moradorRepo = new MoradorRepository();
        $moradores   = $moradorRepo->findAtivos();

        foreach ($moradores as $morador) {
            $this->repo->salvarLancamento(
                array_merge($dados, ['id_user' => $morador['id_user']]),
                (int) $_SESSION['usuario_id']
            );
        }
        $_SESSION['sucesso_lancamento'] =
            'Lançamento realizado para ' . count($moradores) . ' morador(es)!';
    }

    private function lancarParaUm(array $dados, int $idUser): void
    {
        $this->repo->salvarLancamento(
            array_merge($dados, ['id_user' => $idUser]),
            (int) $_SESSION['usuario_id']
        );
        $_SESSION['sucesso_lancamento'] = 'Lançamento realizado com sucesso!';
    }

    private function destinoAposFatura(): string
    {
        return ((int) ($_SESSION['usuario_privilegio'] ?? 0) === self::PRIVILEGIO_SINDICO)
            ? '/financeiro/lancamento'
            : '/financeiro/historico';
    }

    private function requireSindico(): void
    {
        if (!isset($_SESSION['usuario_id'])
            || !in_array((int) ($_SESSION['usuario_privilegio'] ?? 0), [2, 4], true)
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
