<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilizacao/style.css">
    <link rel="icon" type="image/png" href="../home/imagens/logo_icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cadastro - DomusFlow</title>
</head>
<body>
    <form action="../utils/proc_cadastro.php" method="POST">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8">               
                    <div class="card text-center shadow-lg border-0">
                        <div class="p-4 bg-white rounded">
                            <div class="card-body">
                                <h5 class="card-title">Preencha os campos para realizar o cadastro</h5>
                                <p class="card-text text-muted">Após preencher os campos, será necessário aguardar a aprovação do Síndico.</p>
                                <hr>
                                <h2 class="mb-4">Dados Pessoais</h2>
                                <hr>
                                <div class="row g-2 mb-3">  
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Nome Completo" required>
                                            <label for="user_name">Nome Completo:</label>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="user_cpf" name="user_cpf" placeholder="000.000.000-00" maxlength="14" required>
                                            <label for="user_cpf">CPF:</label>
                                        </div>
                                    </div>                                
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="user_apto" name="user_apto" placeholder="23A" maxlength="4" required>
                                            <label for="user_apto">Apartamento:</label>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="user_bloco" name="user_bloco" placeholder="A" maxlength="3" required>
                                            <label for="user_bloco">Bloco:</label>
                                        </div>
                                    </div>                                
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-md-8">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email" required>
                                            <label for="user_email">Email:</label>
                                        </div>
                                    </div>                                
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <select class="form-select" id="user_sexo" name="user_sexo" required>
                                                <option value="" selected disabled>Selecione</option>
                                                <option value="M">Masculino</option>
                                                <option value="F">Feminino</option>
                                            </select>
                                            <label for="user_sexo">Sexo:</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control" id="user_cell" name="user_cell" placeholder="(00) 00000-0000" maxlength="15" required>
                                            <label for="user_cell">Telefone:</label>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control" id="user_recado" name="user_recado" placeholder="(00) 00000-0000" maxlength="15">
                                            <label for="user_recado">Telefone de Recado:</label>
                                        </div>
                                    </div>                                
                                </div>

                                <div class="row g-2 mb-4">
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="user_senha" name="user_senha" placeholder="Senha" required>
                                            <label for="user_senha">Senha:</label>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="user_confirm_senha" name="user_confirm_senha" placeholder="Confirmar Senha" required>
                                            <label for="user_confirm_senha">Confirmar Senha:</label>
                                        </div>
                                    </div>                                
                                </div>

                                <div class="d-grid gap-2 col-md-6 mx-auto">
                                    <button class="btn btn-dark p-2" type="submit">Cadastrar</button>
                                    <a href="../home/index.php" class="btn btn-outline-dark">Realizar Login</a>
                                </div>
                            </div>
                            <div class="card-footer text-body-secondary mt-3"></div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </form>

    <script src="script/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>