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
    $prev          = $dados_usuario['previlegio'];
    $primeiro_nome = explode(" ", $nome_completo)[0];
    
    if($prev <> 2){
      header("Location: ../home/index.php");
      exit();  
    }
    
} catch (PDOException $e) {
    echo "Erro ao carregar dados: " . $e->getMessage();
} 

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Festivo</title>
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
                    <li class="nav-link">
                        <a href="../dashboard_domusflow/index.php">
                            <i class='bx bxs-dashboard icon' ></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../reserva_local/index.php">
                            <i class='bx bx-calendar-check icon'></i>
                            <span class="text nav-text">Reserva</span>
                        </a>
                    </li>
                    <?php
                        if($prev == 2){
                           echo "<li class='nav-link disabled'>
                                    <a href='#'>
                                        <i class='bx bx-user-check icon'></i>
                                        <span class='text nav-text'>Novos Usuarios</span>
                                    </a>
                                </li>"; 
                        }
                    ?>
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
                              Bloco: <?php echo htmlspecialchars($dados_usuario['bloco']); ?>
                            </span>
                        </div>
                    </div>
                    <i class='bx bx-log-out icon'></i>
                </li>
            </a>   
        </div>
    </nav>  

        <div class="container mt-4">
        <h4 class="mb-4"><i class="bi bi-shield-check"></i>Solicitações de Acesso</h4>

        <?php
            $query_lib = "SELECT * FROM morador WHERE status = 'P'";
            $stmt_lib = $pdo->prepare($query_lib);
            $stmt_lib->execute();

            $moradores_pendentes = $stmt_lib->fetchAll(PDO::FETCH_ASSOC); // transforma o resultado da query em array 

            // inicio do loop
            foreach($moradores_pendentes as $morador): 
        ?>
        <div class="card shadow-sm mb-2 border-left-warning">
            <div class="card-body d-flex align-items-center p-2">
                
                <div class="me-3 ms-2">
                    <?php
                        if ($morador['sexo'] == 'M') {
                            $avatar = 'https://png.pngtree.com/png-vector/20231019/ourmid/pngtree-user-profile-avatar-png-image_10211467.png';
                        } else {
                            $avatar = 'https://images.icon-icons.com/3708/PNG/512/girl_female_woman_person_people_avatar_icon_230018.png';
                        }
                    ?>
                    <img src="<?php echo $avatar; ?>" alt="profile" class="rounded-circle border" width="60" height="60" style="object-fit: cover;">
                </div>

                <div class="flex-grow-1">
                    <h6 class="mb-0 text-dark"><?php echo $morador['nome']; ?></h6>
                    <small class="text-muted">
                        CPF: <?php echo $morador['CPF']; ?> |  Apartamento: <?php echo $morador['apto']; ?> |  Bloco: <?php echo $morador['bloco']  ?>
                    </small>
                </div>

                <div class="d-flex gap-2 pe-2">
                    <form action="../utils/libera_moradores.php" method="POST" class="d-inline">
                        <input type="hidden" name="id_morador" value="<?php echo $morador['id_user']; ?>">
                        
                        <button type="submit" name="acao" value="aceitar" class="btn btn-sm btn-success shadow-sm">
                            <i class="bi bi-check-lg"></i> Aceitar
                        </button>
                        <button type="submit" name="acao" value="negar" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-x-lg"></i> Negar
                        </button>
                    </form>
                </div>

            </div>
        </div>

    <?php endforeach; ?>  

    <?php if (empty($moradores_pendentes)): ?>
        <div class="alert alert-light text-center border">
            Nenhuma solicitação pendente no momento.
        </div>
    <?php endif; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="script/script.js"></script>
</body>
</html>