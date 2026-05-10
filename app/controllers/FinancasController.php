<?php

require_once __DIR__ . '/../repositories/FinancasRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class FinancasController{

    private FinancasRepository $repo;

    private function requireSindico(): void{
        if (!isset($_SESSION['usuario_id']) || ($_SESSION['usuario_previlegio'] ?? 0) != 2) {
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
        $usuario = $repo->findById((int)$_SESSION['usuario_id']); // ← só essa linha

        $taxas = $this->repo->taxasCad();

        require_once __DIR__ . '/../../resources/views/financas/taxas/index.php';
    }

    public function salvarTaxas():void {

        if ($_SESSION['usuario_previlegio'] == 2 AND $_SERVER['REQUEST_METHOD'] == 'POST'){ // validamos se esta logado / se é sindico / e foi via post
            
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

    public function lancamento():void{
        if (!isset($_SESSION['usuario_id'])) { // validamos se esta logado
            header('Location: ' . BASE_URL . '/');
            exit();
        }
        $id_user    = (int)$_SESSION['usuario_id']; // resgatamos os id e o previlegio
        $previlegio = (int)$_SESSION['usuario_previlegio'];

        $lancamentos = $this->repo->lancamento($id_user, $previlegio); // enviamos para a repository
        $todasTaxas = $this->repo->listarTodasTaxasAtivas();
        
        $repo      = new MoradorRepository();
        $usuario   = $repo->findById((int)$_SESSION['usuario_id']);
        $moradores = $repo->findAll();
        

        require_once __DIR__ . '/../../resources/views/financas/lancamento/index.php';
    }

public function salvarLancamento(): void
{
    if ($_SESSION['usuario_previlegio'] != 2 || $_SERVER['REQUEST_METHOD'] !== 'POST') {
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

    if (isset($_POST['todos_moradores'])) {
        // lança para todos os moradores ativos
        $moradorRepo = new MoradorRepository();
        $moradores   = $moradorRepo->findAtivos();

        foreach ($moradores as $m) {
            $this->repo->salvarLancamento(
                array_merge($dados, ['id_user' => $m['id_user']]),
                (int)$_SESSION['usuario_id']
            );
        }
    } else {
        // lança só para o morador selecionado
        $this->repo->salvarLancamento(
            array_merge($dados, ['id_user' => $_POST['id_user']]),
            (int)$_SESSION['usuario_id']
        );
    }

    header('Location: ' . BASE_URL . '/financeiro/lancamento');
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

    public function gerarFatura():void{

        $this->requireSindico(); // validamos se é sindico atraves da function private no topo do arquivo

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') { // validamos se os dados foram enviados via post
        header('Location: ' . BASE_URL . '/financeiro/lancamento'); // caso nao seja, redirecionamos 
        exit();
    }

    $id_user_alvo = (int)$_POST['id_user']; // resgatamos os dados do usuario
    $valor_total  = $this->repo->totalPendente($id_user_alvo);

    if ($valor_total <= 0) { // em caso do morador nao tiver valores pendentes, apenas exibimos msg informando que nao a debitos pendentes
        $_SESSION['erro_fatura'] = 'Morador não possui lançamentos pendentes.';
        header('Location: ' . BASE_URL . '/financeiro/lancamento');
        exit();
    }

    $resultado = $this->repo->gerarFatura( // passamos os dados para a repository realizar a query no sql
        (int)$_SESSION['usuario_id'],
        [
            'id_user'   => $id_user_alvo,
            'data'      => date('Y-m-d'),
            'valor'     => $valor_total,
            'descricao' => $_POST['descricao'] ?? 'Fatura gerada automaticamente',
        ]
    );

    if ($resultado) { // redirecionamos em caso de sucesso ou erro
        $_SESSION['sucesso_fatura'] = 'Fatura gerada com sucesso! Valor: R$ ' . number_format($valor_total, 2, ',', '.');
    } else {
        $_SESSION['erro_fatura'] = 'Erro ao gerar fatura.';
    }

    header('Location: ' . BASE_URL . '/financeiro/lancamento');
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
                echo json_encode(['duplicado' => $duplicados > 0, 'quantidade' => $duplicados]);
            }
        } else {
            $duplicado = $this->repo->existeLancamentoNoMes($modelo, $descricao, $id_user, $data_venc);
            echo json_encode(['duplicado' => $duplicado]);
        }
        exit();
    }

}


?>