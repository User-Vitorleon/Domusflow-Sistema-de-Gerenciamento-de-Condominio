<?php
require_once '../connection/conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $nome = $_POST['user_name'];   
    $cpf = $_POST['user_cpf'];
    $apto = $_POST['user_apto']; 
    $bloco = $_POST['user_bloco']; 
    $email = $_POST['user_email'];
    $cell = $_POST['user_cell'];
    $senha = $_POST['user_senha'];
    $conf_senha = $_POST['user_confirm_senha']; 
    $iden = '1';
    $status = "P";
    
    if ($_POST['user_recado'] == "") {
        $recado = null;
    } else {
        $recado = $_POST['user_recado'];
    }

    if ($senha !== $conf_senha){
        echo "<script>
                alert('Por favor, verifique as senhas informadas'); 
                history.back();
              </script>";
        exit;
    }

    $senha_crip = password_hash($senha, PASSWORD_DEFAULT);

    try {

        $sql = "INSERT INTO morador (identificador, nome, apto, bloco, CPF, email, telefone, tell_recado, senha, status) 
                VALUES (:iden, :nome, :apto, :bloco, :cpf, :email, :cell, :recado, :senha_crip, :status)";
        
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':iden'       => $iden,
            ':nome'       => $nome,
            ':apto'       => $apto,
            ':bloco'      => $bloco,
            ':cpf'        => $cpf,
            ':email'      => $email,
            ':cell'       => $cell,
            ':recado'     => $recado,
            ':senha_crip' => $senha_crip,
            ':status'     => $status
        ]);

        echo "
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB' crossorigin='anonymous'>

        <div class='modal fade' id='modalSucesso' data-bs-backdrop='static' tabindex='-1' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered'>
                <div class='modal-content text-center p-4'>
                    <div class='modal-body'>
                        <h4 class='text-success'>Cadastro Realizado!</h4>
                        <p>Aguarde a aprovação do Síndico para acessar a dashboard.</p>
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
                    window.location.href = '../../index.php'; 
                }
            }, 1000);
        </script>";

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>alert('CPF ou Email já cadastrado!'); history.back();</script>";
        } else {
            echo "<script>alert('Erro técnico: " . addslashes($e->getMessage()) . "'); history.back();</script>";
        }
    }
}
?>