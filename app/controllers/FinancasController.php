<?php
<<<<<<< HEAD

require_once __DIR__ . '/../repositories/FinancasRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class FinancasController{
    private FinancasRepository $repo;

    private function requireSindico(): void{
    if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['usuario_privilegio'] ?? 0, [2, 4])) {
        header('Location: ' . BASE_URL . '/');
        exit();
    }
}

    public function __construct (){
        $this->repo = new FinancasRepository();
    }

    public function taxasCad(): void
    {
        $this->requireSindico();

        $repo    = new MoradorRepository();
        $usuario = $repo->findById((int)$_SESSION['usuario_id']); 

        $taxas = $this->repo->taxasCad();
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        require_once __DIR__ . '/../../resources/views/financas/taxas/index.php';
    }

<<<<<<< HEAD
    public function salvarTaxas():void {
        if ($_SESSION['usuario_privilegio'] == 2 AND $_SERVER['REQUEST_METHOD'] == 'POST'){ // validamos se esta logado / se é sindico / e foi via post
            
            $resultado = $this->repo->salvarTaxas([ // enviamos os paramentos para a repository
            'descricao'         => $_POST['descricao']        ?? '',
            'valor'             => $_POST['valor']            ?? '',
            'modulo'            => $_POST['modulo']           ?? '',
            ]);
            
            if ($resultado) { // redirecionamento em caso de erro ou sucesso
                header('Location: ' . BASE_URL . '/financeiro/taxas');
            } else {
                $_SESSION['erro_taxa'] = 'Erro ao cadastrar taxa.';
                header('Location: ' . BASE_URL . '/financeiro/taxas');
            }          
        }else{
            header('Location: ' . BASE_URL . '/');
        }
            exit();
    }

    public function excluirTaxa(): void{
        $this->requireSindico();
        $this->repo->excluirTaxa((int)$_POST['id_taxa']);
        header('Location: ' . BASE_URL . '/financeiro/taxas?excluido=1');
        exit();
    }

    public function lancamento(): void
{
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . '/');
        exit();
    }

    $id_user    = (int)$_SESSION['usuario_id'];
    $privilegio = (int)$_SESSION['usuario_privilegio'];

    $busca   = $_GET['busca']   ?? '';
    $status  = $_GET['status']  ?? '';
    $dt_lanc = $_GET['dt_lanc'] ?? '';
    $dt_venc = $_GET['dt_venc'] ?? '';
    $atraso  = $_GET['atraso']  ?? '';
    $pagina  = (int)($_GET['pagina'] ?? 1);
    $porPagina = 10;

    $total        = $this->repo->countLancamentos($id_user, $privilegio, $busca, $status, $dt_lanc, $dt_venc, $atraso);
    $totalPaginas = (int)ceil($total / $porPagina);
    $offset       = ($pagina - 1) * $porPagina;

    $lancamentos = $this->repo->lancamento($id_user, $privilegio, $offset, $porPagina, $busca, $status, $dt_lanc, $dt_venc, $atraso);
    $todasTaxas  = $this->repo->listarTodasTaxasAtivas();

    $repo      = new MoradorRepository();
    $usuario   = $repo->findById((int)$_SESSION['usuario_id']);
    $moradores = $repo->findAtivos();

    require_once __DIR__ . '/../../resources/views/financas/lancamento/index.php';
}

public function salvarLancamento(): void{
    if ($_SESSION['usuario_privilegio'] != 2 || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . BASE_URL . '/');
        exit();
    }

    $dados = [
        'modelo'    => $_POST['modelo'],
        'valor'     => $_POST['valor'],
        'descricao' => $_POST['descricao'],
        'data_venc' => $_POST['data_venc'],
        'data_lanc' => $_POST['data_lanc'],
    ];

        if ($dados['data_lanc'] < date('Y-m-d')) {
            $_SESSION['erro_lancamento'] = 'A data de lançamento não pode ser inferior ao dia de hoje.';
            header('Location: ' . BASE_URL . '/financeiro/lancamento');
            exit();
        }

        if ($dados['data_venc'] < date('Y-m-d')) {
            $_SESSION['erro_lancamento'] = 'A data de vencimento não pode ser inferior ao dia de hoje.';
            header('Location: ' . BASE_URL . '/financeiro/lancamento');
            exit();
        }

        if (isset($_POST['todos_moradores'])) {
        $moradorRepo = new MoradorRepository();
        $moradores   = $moradorRepo->findAtivos();

        foreach ($moradores as $m) {
            $this->repo->salvarLancamento(
                array_merge($dados, ['id_user' => $m['id_user']]),
                (int)$_SESSION['usuario_id']
            );
        }
        $_SESSION['sucesso_lancamento'] = 'Lançamento realizado para ' . count($moradores) . ' morador(es)!'; // ← adiciona
    } else {
        $this->repo->salvarLancamento(
            array_merge($dados, ['id_user' => $_POST['id_user']]),
            (int)$_SESSION['usuario_id']
        );
        $_SESSION['sucesso_lancamento'] = 'Lançamento realizado com sucesso!'; // ← adiciona
    }

    header('Location: ' . BASE_URL . '/financeiro/lancamento');
    exit();
}

public function excluirLancamento(): void{
    $this->requireSindico();
    $this->repo->excluirLancamento((int)$_POST['id_lancamento']);
    header('Location: ' . BASE_URL . '/financeiro/lancamento?excluido=1');
    exit();
}
    

    public function historico():void{
        if(!isset($_SESSION['usuario_id'])){ // se nao estiver logado direcionamos ele ! 
            header('Location: ' . BASE_URL . '/'); 
            exit();
        }

        $id_user = (int)$_SESSION['usuario_id']; // esta logado passamos o id do usuario para a repository metodo historico 
        $historico = $this->repo->historico($id_user);

        $repo    = new MoradorRepository();
$usuario = $repo->findById((int)$_SESSION['usuario_id']);


        require_once __DIR__ . '/../../resources/views/financas/historico/index.php';    

    }

public function gerarFatura(): void{
    // tanto morador quanto síndico podem gerar fatura
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . '/');
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . BASE_URL . '/financeiro/historico');
        exit();
    }

    $id_user_alvo = (int)$_POST['id_user'];
    $valor_total  = $this->repo->totalPendente($id_user_alvo);

    if ($valor_total <= 0) {
        $_SESSION['erro_fatura'] = 'Nenhuma pendência encontrada.';
        $destino = ($_SESSION['usuario_privilegio'] == 2) ? '/financeiro/lancamento' : '/financeiro/historico';
        header('Location: ' . BASE_URL . $destino);
        exit();
    }

    $resultado = $this->repo->gerarFatura(
        (int)$_SESSION['usuario_id'],
        [
            'id_user'   => $id_user_alvo,
            'data'      => date('Y-m-d'),
            'valor'     => $valor_total,
            'descricao' => $_POST['descricao'] ?? 'Fatura gerada automaticamente',
        ]
    );

    if ($resultado) {
        $_SESSION['sucesso_fatura'] = 'Fatura gerada com sucesso! Valor: R$ ' . number_format($valor_total, 2, ',', '.');
    } else {
        $_SESSION['erro_fatura'] = 'Erro ao gerar fatura.';
    }

    $destino = ($_SESSION['usuario_privilegio'] == 2) ? '/financeiro/lancamento' : '/financeiro/historico';
    header('Location: ' . BASE_URL . $destino);
    exit();
}


    public function verificarDuplicado(): void {
        header ('Content-Type: application/json');

        $modelo    = $_POST['modelo']    ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $data_venc = $_POST['data_venc'] ?? '';
        $id_user   = (int)($_POST['id_user'] ?? 0);

        if (isset($_POST['todos_moradores'])){
            $moradorRepo = new MoradorRepository();
            $moradores   = $moradorRepo->findAtivos();
            $duplicados  = 0;



            foreach($moradores as $m){
                if ($this->repo->existeLancamentoNoMes($modelo, $descricao, $m['id_user'], $data_venc)){
                    $duplicados++;
                }
            }
            echo json_encode(['duplicado' => $duplicados > 0, 'quantidade' => $duplicados]);
        } else {
            $duplicado = $this->repo->existeLancamentoNoMes($modelo, $descricao, $id_user, $data_venc);
            echo json_encode(['duplicado' => $duplicado]);
        }
        exit();
    }

    public function gerarFaturaTodos(): void{
        $this->requireSindico();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/financeiro/lancamento');
            exit();
        }

=======
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

    public function gerarFaturaTodos(): void
    {
        $this->requireSindico();
        AuthGuard::requerePost('/financeiro/lancamento');

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $moradorRepo = new MoradorRepository();
        $moradores   = $moradorRepo->findAtivos();
        $gerados     = 0;

<<<<<<< HEAD
        foreach ($moradores as $m) {
            $valor_total = $this->repo->totalPendente($m['id_user']);
            if ($valor_total > 0) {
                $this->repo->gerarFatura(
                    (int)$_SESSION['usuario_id'],
                    [
                        'id_user'   => $m['id_user'],
                        'data'      => date('Y-m-d'),
                        'valor'     => $valor_total,
                        'descricao' => 'Fatura gerada automaticamente',
                    ]
                );
                $gerados++;
            }
        }

        $_SESSION['sucesso_fatura'] = "Faturas geradas para {$gerados} morador(es)!";
        header('Location: ' . BASE_URL . '/financeiro/lancamento');
        exit();
    }

}
?>
=======
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

    private function validarDatasLancamento(array $dados): ?string
    {
        $hoje = date('Y-m-d');
        if ($dados['data_lanc'] < $hoje) {
            return 'A data de lançamento não pode ser inferior ao dia de hoje.';
        }
        if ($dados['data_venc'] < $hoje) {
            return 'A data de vencimento não pode ser inferior ao dia de hoje.';
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
