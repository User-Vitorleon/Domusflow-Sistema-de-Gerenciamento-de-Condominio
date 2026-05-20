<?php
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$uri = preg_replace('#^Domusflow-Sistema-de-Gerenciamento-de-Condominio/?#i', '', $uri);
$uri = trim($uri, '/');

$routes = [
<<<<<<< HEAD
    // Autenticação
    ''                    => ['HomeController',      'index'],
    'login'               => ['AuthController',      'login'],
    'logout'              => ['AuthController',      'logout'],
    'pendente'            => ['AuthController',      'pendente'],
    'pendente/checar'     => ['AuthController',      'checar'],

    // moradores
    'cadastro'               => ['MoradorController',   'formCadastro'],
    'cadastro/salvar'        => ['MoradorController',   'salvar'],
    'cadastro/update'        => ['MoradorController',   'formUpdate'],
    'cadastro/update/salvar' => ['MoradorController',   'updateSalvar'],
    'moradores/pendentes'    => ['MoradorController',   'pendentes'],
    'moradores/liberar'      => ['MoradorController',   'liberar'],
    'moradores/inativar'     => ['MoradorController',   'inativar'],
    'moradores/deletar'      => ['MoradorController',   'deletar'],
    

    // Dashboard
    'dashboard'           => ['DashboardController', 'index'],
    'painel'              => ['PainelController',    'index'],

    // Reservas
    'reserva'             => ['ReservaController',   'index'],
    'reserva/salvar'      => ['ReservaController',   'salvar'],
    'reservas/decidir'    => ['ReservaController',   'decidir'],

    // Veículos
    'veiculo'             => ['VeiculoController',   'index'],
    'veiculo/salvar'      => ['VeiculoController',   'salvar'],
    'veiculo/editar'      => ['VeiculoController',   'editar'],
    'veiculo/excluir'     => ['VeiculoController',   'excluir'],
    'veiculo/consultar'   => ['VeiculoController',   'consultar'],

    // API
    'api/feriados'        => ['FeriadoController',   'index'],

    // Finanças
    'financeiro/taxas'                => ['FinancasController',     'taxasCad'],
    'financeiro/taxas/salvar'         => ['FinancasController',     'salvarTaxas'],
    'financeiro/taxas/excluir'        => ['FinancasController',     'excluirTaxa'],
    'financeiro/lancamento'           => ['FinancasController',     'lancamento'],
    'financeiro/lancamento/salvar'    => ['FinancasController',     'salvarLancamento'],
    'financeiro/lancamento/excluir'   => ['FinancasController' ,    'excluirLancamento'],
    'financeiro/historico'            => ['FinancasController',     'historico'],
    'financeiro/fatura/gerar'         => ['FinancasController',     'gerarFatura'],
    'financeiro/lancamento/verificar' => ['FinancasController',     'verificarDuplicado'],
    'financeiro/fatura/gerarTodos'    => ['FinancasController',     'gerarFaturaTodos'],

    // Ocorrências
    'ocorrencia'                    => ['OcorrenciaController', 'index'],
    'ocorrencia/abrir'              => ['OcorrenciaController', 'abrir'],
    'ocorrencia/cancelar'           => ['OcorrenciaController', 'cancelar'],
    'ocorrencia/tramitar-morador'   => ['OcorrenciaController', 'tramitarMorador'],
    'ocorrencia/painel'             => ['OcorrenciaController', 'painel'],
    'ocorrencia/tramitar'           => ['OcorrenciaController', 'tramitar'],
    'ocorrencia/detalhes'           => ['OcorrenciaController', 'detalhes'],

    // Avisos
    'avisos'              => ['AvisosController', 'index'],
    'avisos/salvar'       => ['AvisosController', 'salvar'],
    'avisos/excluir'      => ['AvisosController', 'excluir'],

    // Assembleia
    'assembleia'           => ['AssembleiaController', 'index'],
    'assembleia/salvar'    => ['AssembleiaController', 'salvar'],
    'assembleia/presenca'  => ['AssembleiaController', 'confirmarPresenca'],
    'assembleia/excluir'   => ['AssembleiaController', 'excluir'],
    'assembleia/presencas' => ['AssembleiaController', 'listarPresencas'],


    // testaaaar 
    
    'cadastro/admin'        => ['MoradorController', 'cadastrarAdmin'],
    'cadastro/admin/salvar' => ['MoradorController', 'cadastrarAdminSalvar'],

=======
    ''                               => ['HomeController',       'index'],
    'login'                          => ['AuthController',       'login'],
    'logout'                         => ['AuthController',       'logout'],
    'pendente'                       => ['AuthController',       'pendente'],
    'pendente/checar'                => ['AuthController',       'checar'],

    'cadastro'                       => ['MoradorController',    'formCadastro'],
    'cadastro/salvar'                => ['MoradorController',    'salvar'],
    'cadastro/update'                => ['MoradorController',    'formUpdate'],
    'cadastro/update/salvar'         => ['MoradorController',    'updateSalvar'],
    'moradores/pendentes'            => ['MoradorController',    'pendentes'],
    'moradores/liberar'              => ['MoradorController',    'liberar'],
    'moradores/inativar'             => ['MoradorController',    'inativar'],
    'moradores/deletar'              => ['MoradorController',    'deletar'],
    'moradores/gestao'               => ['MoradorController',    'gestao'],
    'moradores/gestao/salvar'        => ['MoradorController',    'gestaoSalvar'],

    'dashboard'                      => ['DashboardController',  'index'],
    'painel'                         => ['PainelController',     'index'],

    'reserva'                        => ['ReservaController',    'index'],
    'reserva/salvar'                 => ['ReservaController',    'salvar'],
    'reservas/decidir'               => ['ReservaController',    'decidir'],

    'veiculo'                        => ['VeiculoController',    'index'],
    'veiculo/salvar'                 => ['VeiculoController',    'salvar'],
    'veiculo/editar'                 => ['VeiculoController',    'editar'],
    'veiculo/excluir'                => ['VeiculoController',    'excluir'],
    'veiculo/consultar'              => ['VeiculoController',    'consultar'],

    'api/feriados'                   => ['FeriadoController',    'index'],

    'financeiro/taxas'                => ['FinancasController',  'taxasCad'],
    'financeiro/taxas/salvar'         => ['FinancasController',  'salvarTaxas'],
    'financeiro/taxas/excluir'        => ['FinancasController',  'excluirTaxa'],
    'financeiro/lancamento'           => ['FinancasController',  'lancamento'],
    'financeiro/lancamento/salvar'    => ['FinancasController',  'salvarLancamento'],
    'financeiro/lancamento/excluir'   => ['FinancasController',  'excluirLancamento'],
    'financeiro/historico'            => ['FinancasController',  'historico'],
    'financeiro/fatura/gerar'         => ['FinancasController',  'gerarFatura'],
    'financeiro/lancamento/verificar' => ['FinancasController',  'verificarDuplicado'],
    'financeiro/fatura/gerarTodos'    => ['FinancasController',  'gerarFaturaTodos'],

    'ocorrencia'                     => ['OcorrenciaController', 'index'],
    'ocorrencia/abrir'               => ['OcorrenciaController', 'abrir'],
    'ocorrencia/cancelar'            => ['OcorrenciaController', 'cancelar'],
    'ocorrencia/tramitar-morador'    => ['OcorrenciaController', 'tramitarMorador'],
    'ocorrencia/painel'              => ['OcorrenciaController', 'painel'],
    'ocorrencia/tramitar'            => ['OcorrenciaController', 'tramitar'],
    'ocorrencia/detalhes'            => ['OcorrenciaController', 'detalhes'],

    'avisos'                         => ['AvisosController',     'index'],
    'avisos/salvar'                  => ['AvisosController',     'salvar'],
    'avisos/excluir'                 => ['AvisosController',     'excluir'],

    'assembleia'                     => ['AssembleiaController', 'index'],
    'assembleia/salvar'              => ['AssembleiaController', 'salvar'],
    'assembleia/presenca'            => ['AssembleiaController', 'confirmarPresenca'],
    'assembleia/excluir'             => ['AssembleiaController', 'excluir'],
    'assembleia/presencas'           => ['AssembleiaController', 'listarPresencas'],
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

];

if (isset($routes[$uri])) {
    [$controllerName, $method] = $routes[$uri];
    require_once __DIR__ . "/../app/controllers/{$controllerName}.php";
    $controller = new $controllerName();
    $controller->$method();
} else {
    http_response_code(404);
    echo '404 - Página não encontrada';
}
