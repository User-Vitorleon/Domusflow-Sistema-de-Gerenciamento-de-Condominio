<?php
require_once "../connection/conexao.php";
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../home/index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_user = $_SESSION["usuario_id"]; // ID de quem está logado (morador)
    $id_local = $_POST["id_local"];
    $data_reserva = $_POST["data_reserva"];
    $hora_ini = $_POST["hora_ini"];
    $hora_fim = $_POST["hora_fim"];
    $status = "P"; 
    try {
  
        $query = "INSERT INTO reservas (id_local, id_user, data_reserva, hora_ini, hora_fim, status) 
                  VALUES (:id_local, :id_user, :data_reserva, :hora_ini, :hora_fim, :status)";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ":id_local"     => $id_local,
            ":id_user"      => $id_user,
            ":data_reserva" => $data_reserva,
            ":hora_ini"     => $hora_ini,
            ":hora_fim"     => $hora_fim,
            ":status"       => $status
        ]);

        header("Location: ../reserva_local/index.php?reserva=sucesso");
        exit();
    } catch (PDOException $e) {
        die("Erro ao solicitar reserva: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}
?>