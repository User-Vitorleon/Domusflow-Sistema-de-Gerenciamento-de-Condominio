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
                            <i class='bx bx-lock-alt icon'></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link disabled">
                        <a href="#">
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
                              Bloco: <?php echo htmlspecialchars($dados_usuario['bloco']); ?>
                            </span>
                        </div>
                    </div>
                    <i class='bx bx-log-out icon'></i>
                </li>
            </a>   
        </div>
    </nav>

    
     <?php

        switch ($prev){
            case 1: // morador
                echo "Ola morador, $nome_completo";
            break;

            case 2: // sindico
                echo "<section class='home'>
                    <div class='text'>Gestão de Espaços</div>

                    <div class='container-fluid px-4'> 
                        <div class='row justify-content-center'>
                            <div class='col-12 col-xl-8'>
                                
                                <div class='card shadow-sm border-0 mt-3'>
                                    <div class='card-header d-flex align-items-center'>
                                        <i class='bx bx-building-house fs-4 me-2'></i>
                                        <h5 class='mb-0'>Cadastrar Local Festivo</h5>
                                    </div>
                                    
                                    <div class='card-body p-4'>
                                        <form action='../utils/cadastro_locais.php' method='POST'>
                                            <div class='row'>
                                                <div class='col-12 mb-3'>
                                                    <label class='form-label fw-bold'>Nome do Local</label>
                                                    <input type='text' name='nome_local' class='form-control form-control-lg' placeholder='Ex: Salão de Festas' required>
                                                </div>

                                                <div class='col-md-6 mb-3'>
                                                    <label class='form-label fw-bold'>Capacidade (Pessoas)</label>
                                                    <div class='input-group'>
                                                        <span class='input-group-text'><i class='bx bx-group'></i></span>
                                                        <input type='number' name='capacidade' class='form-control' placeholder='0' required>
                                                    </div>
                                                </div>

                                                <div class='col-md-6 mb-3'>
                                                    <label class='form-label fw-bold'>Status de Uso</label>
                                                    <select name='disponivel' class='form-select' required>
                                                        <option value='S' selected>Disponível</option>
                                                        <option value='N'>Indisponível / Manutenção</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class='border-top pt-3 mt-3 d-flex justify-content-end gap-2'>
                                                <button type='reset' class='btn btn-light border'>Limpar</button>
                                                <button type='submit' class='btn px-5'>Salvar Espaço</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </section>";
                break;

            default: // adm
                echo "Previlegio nao encontrado";
        }
     ?>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="script/script.js"></script>
</body>
</html>