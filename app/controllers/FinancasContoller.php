<?php

require_once __DIR__ . '/../repositories/FinancasRepository.php';

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

    public function taxasCad():void {
        $this->requireSindico();
        $taxas = $this->repo->taxasCad();
        $usuario    = $_SESSION['usuario_nome'];
        
        require_once __DIR__ . '/../../resources/views/financas/taxas/index.php';

    }

    public function salvarTaxas():void {

        if ($_SESSION['usuario_previlegio'] == 2 AND $_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $resultado = $this->repo->salvarTaxas([
            'descricao'         => $_POST['descricao']        ?? '',
            'valor'             => $_POST['valor']            ?? '',
            ]);
            
            if ($resultado) {
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

    }

    public function salvarLancamento():void{

    }

    public function historico():void{

    }

    public function gerarFatura():void{

    }

}


?>