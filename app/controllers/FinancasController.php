<?php

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

        require_once __DIR__ . '/../../resources/views/financas/taxas/index.php';
    }

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

        $moradorRepo = new MoradorRepository();
        $moradores   = $moradorRepo->findAtivos();
        $gerados     = 0;

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