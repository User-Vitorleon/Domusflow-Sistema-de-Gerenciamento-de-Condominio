<?php
require_once '../connection/conexao.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../home/index.php");
    exit();
}

$id_logado = $_SESSION['usuario_id'];

try {
    $sql_check = "SELECT previlegio FROM morador WHERE id_user = :id LIMIT 1";
    $stmt_check = $pdo->prepare($sql_check); 
    $stmt_check->execute(['id' => $id_logado]);
    $dados_usuario = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if (!$dados_usuario || $dados_usuario['previlegio'] != 2) {
        header("Location: ../home/index.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_morador']) && isset($_POST['acao'])) {
        $id = $_POST['id_morador'];
        $acao = $_POST['acao'];

        if ($acao === 'aceitar') {
            $query = "UPDATE morador SET status = 'L' WHERE id_user = :id";
        } else {
            $query = "UPDATE morador SET status = 'B' WHERE id_user = :id";
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);

        header("Location: ../new_moradores/index.php?status=" . ($acao === 'aceitar' ? 'liberado' : 'negado'));
        exit();
    } else {
        header("Location: ../new_moradores/index.php");
        exit();
    }

} catch (PDOException $e) {
    die("Erro no banco de dados: " . $e->getMessage());
}
?>