<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Estilizacao/style.css">
    <link rel="icon" type="image/png" href="../imagens/logo_icon.png">
    <title>DomusFlow</title>
</head>
<body>
    <div class="container-fluid vh-100">
        <div class="row h-100">            
            <div class="col-md-4 d-flex align-items-center justify-content-center bg-sidebar p-5">
                <div class="w-100">
                    <form action="../utils/login.php" method="POST">
                        <div class="mb-4"> 
                            <img width="25" height="25" src="https://img.icons8.com/ios-filled/50/ffffff/name.png" alt="icon_user"/>
                            <label class="form-label text-white ms-2" >CPF:</label>
                            <input type="text" class="form-control custom-input" id="user_cpf" name="user_cpf" placeholder="000.000.000-00" maxlength="14">
                        </div>

                        <div class="mb-4"> 
                            <img width="25" height="25" src="https://img.icons8.com/metro/26/ffffff/lock.png" alt="lock"/>
                            <label class="form-label text-white ms-2">SENHA:</label>
                            <input type="password" class="form-control custom-input" id="user_senha" name="user_senha" placeholder="********">
                        </div>

                        <button type="submit" class="btn btn-black w-100 rounded-pill mt-4">Acessar</button>                       
                        <a href="../cadastro_moradores/index.php" type="submit" class="btn btn-black w-100 rounded-pill mt-4">Cadastrar-se</a>
                        <label class="card-text">Primeiro acesso, faça o Cadastro</label>
                    </form>
                </div>
            </div>

            <div class="col-md-8 d-flex align-items-center justify-content-center p-5"> 
                <div class="text-center w-100"> 
                    <img src="../Imagens/DomusFlow.png" class="img-fluid logo-main-display" alt="Logo DomusFlow">
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Scripts/validacoes.js"></script>
</body>
</html>