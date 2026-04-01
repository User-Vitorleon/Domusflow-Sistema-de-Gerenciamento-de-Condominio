<?php
require_once '../connection/conexao.php'; // Adicionado ;
session_start(); // OBRIGATÓRIO para ler as sessões

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../home/index.php");
    exit();
}

$id_logado = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $local = $_POST['nome_local'];
    $capac = $_POST['capacidade'];
    $disp  = $_POST['disponivel'];


    if ($capac <= 0) {
        echo "<script>
                alert('O local não pode conter capacidade inferior ou igual a 0'); 
                history.back();
              </script>";
        exit(); 
    }

    try {
        
        $SQL = "INSERT INTO locais_festivos (local, capacidade, disp_uso, id_user_cad) 
                VALUES (:local, :capac, :disp, :id_logado)";
        
        $stmt = $pdo->prepare($SQL);
        $stmt->execute([
            ':local'     => $local,
            ':capac'     => $capac,
            ':disp'      => $disp,
            ':id_logado' => $id_logado
        ]);

    if($disp == "S"){
        echo "
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB' crossorigin='anonymous'>

        <div class='modal fade' id='modalSucesso' data-bs-backdrop='static' tabindex='-1' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered'>
                <div class='modal-content text-center p-4'>
                    <div class='modal-body'>
                        <h4 class='text-success'>Local Festivo Cadastrado!</h4>
                        <p>O local já consta disponivel para os moradores reservarem para uso.</p>
                        <hr>
                        <p class='text-muted'>Redirecionando em <span id='timer' class='fw-bold'>3</span> segundos...</p>
                    </div>
                </div>
            </div>
        </div>

        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
        <script>
            var meuModal = new bootstrap.Modal(document.getElementById('modalSucesso'));
            meuModal.show();

            let tempo = 5;
            let contador = setInterval(function() {
                tempo--;
                document.getElementById('timer').innerText = tempo;
                if (tempo <= 0) {
                    clearInterval(contador);
                    window.location.href = '../reserva_local/index.php'; 
                }
            }, 1000);
        </script>";
    }else{
        echo "
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB' crossorigin='anonymous'>

        <div class='modal fade' id='modalSucesso' data-bs-backdrop='static' tabindex='-1' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered'>
                <div class='modal-content text-center p-4'>
                    <div class='modal-body'>
                        <h4 class='text-success'>Local Festivo Cadastrado!</h4>
                        <p>Local cadastrado, porém não esta disponivel para Uso no momento...</p>
                        <hr>
                        <p class='text-muted'>Redirecionando em <span id='timer' class='fw-bold'>3</span> segundos...</p>
                    </div>
                </div>
            </div>
        </div>

        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
        <script>
            var meuModal = new bootstrap.Modal(document.getElementById('modalSucesso'));
            meuModal.show();

            let tempo = 5;
            let contador = setInterval(function() {
                tempo--;
                document.getElementById('timer').innerText = tempo;
                if (tempo <= 0) {
                    clearInterval(contador);
                    window.location.href = '../reserva_local/index.php'; 
                }
            }, 1000);
        </script>";
    }

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>alert('Erro: Este local já pode estar cadastrado ou erro de integridade.'); history.back();</script>";
        } else {
            echo "<script>alert('Erro técnico: " . addslashes($e->getMessage()) . "'); history.back();</script>";
        }
    }
}
?>