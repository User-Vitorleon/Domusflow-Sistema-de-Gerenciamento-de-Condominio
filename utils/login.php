<?php

    require_once '../connection/conexao.php';
    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $CPF = $_POST['user_cpf'];
        $senha = $_POST['user_senha'];

        try{
            $sql = "SELECT * FROM morador where cpf = :cpf LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':cpf' => $CPF]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])){
              
                if($usuario['status'] == 'L'){
                    $_SESSION['usuario_id'] = $usuario['id_user'];
                    $_SESSION['usuario_nome']= $usuario['nome'];

                    header("Location: ../dashboard/index.php");
                    exit;
                } else {
                    header("Location: ../dashboard/pendente.php");
                }
                
            } else {
                echo "  <script>
                            alert('Email ou senha incorretos!'); 
                            history.back();
                        </script>";  
            }

        } catch (PDOException $e) {
        echo "Erro no sistema: " . $e->getMessage();
    }
}

?>