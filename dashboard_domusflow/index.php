<?php
require_once '../connection/conexao.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../home/index.php");
    exit();
}

$id_logado = $_SESSION['usuario_id'];

try {
  
    $sql = "SELECT * FROM morador WHERE id_user = :id LIMIT 1";
    $stmt = $pdo->prepare($sql); 
    $stmt->execute(['id' => $id_logado]);

    $dados_usuario = $stmt->fetch(PDO::FETCH_ASSOC);
   
    if (!$dados_usuario) {                                     
        session_destroy();
        header("Location: ../home/index.php");
        exit();
    }
    
    $nome_completo = $dados_usuario['nome']; 
    $primeiro_nome = explode(" ", $nome_completo)[0];
    $prev = $dados_usuario['previlegio'];
    
} catch (PDOException $e) {
    echo "Erro ao carregar dados: " . $e->getMessage();
} 

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="estilizacao/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/png" href="../imagens/logo_icon.png">
</head>
<body>
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                    <i class='bx bxs-buildings icon'></i>
                </span>
                <div class="text logo-text">
                    <span class="name">DomusFlow</span>
                </div>
            </div>
            <i class='bx bx-menu toggle'></i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link disabled">
                        <a href="#">
                            <i class='bx bx-lock-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../reserva_local/index.php">
                            <i class='bx bx-category icon'></i>
                            <span class="text nav-text">Reserva</span>
                        </a>
                    </li>
                </ul>
            </div>
            <a href="../utils/sair.php">
                <li class="profile">
                    <div class="profile-details">
                        <?php
                        if ($dados_usuario['sexo'] == 'M'){
                            echo "<img src='https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png' alt='profile'>";
                        }else{
                            echo "<img src='https://images.icon-icons.com/3708/PNG/512/girl_female_woman_person_people_avatar_icon_230018.png' alt='profile'>";
                        }
                        ?>
                        <div class="name-job">
                            <span class="name">
                                <?php echo htmlspecialchars($primeiro_nome); ?>
                            </span>
                            <span class="job">
                              Ap: <?php echo htmlspecialchars($dados_usuario['apto']); ?> 
                              bloco: <?php echo htmlspecialchars($dados_usuario['bloco']); ?>
                            </span>
                        </div>
                    </div>
                    <i class='bx bx-log-out icon'></i>
                </li>
            </a>   
        </div>
    </nav>
    <section class="home"> 
    </section>
    <script src="script/script.js"></script>
</body>
</html>