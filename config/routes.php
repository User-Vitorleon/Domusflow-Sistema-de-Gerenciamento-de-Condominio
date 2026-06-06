<?php
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$uri = preg_replace('#^Domusflow-Sistema-de-Gerenciamento-de-Condominio/?#i', '', $uri);
$uri = trim($uri, '/');

$routes = [
    ''                               => ['HomeController',       'index'],
    'login'                          => ['AuthController',       'login'],
    'logout'                         => ['AuthController',       'logout'],
    'pendente'                       => ['AuthController',       'pendente'],
    'pendente/checar'                => ['AuthController',       'checar'],
    'recuperar-senha'                => ['AuthController',       'recuperarSenha'],
    'recuperar-senha/enviar'         => ['AuthController',       'enviarRecuperacao'],

    'cadastro'                           => ['MoradorController',    'formCadastro'],
    'cadastro/salvar'                    => ['MoradorController',    'salvar'],
    'cadastro/update'                    => ['MoradorController',    'formUpdate'],
    'cadastro/update/salvar'             => ['MoradorController',    'updateSalvar'],
    'moradores/pendentes'                => ['MoradorController',    'pendentes'],
    'moradores/liberar'                  => ['MoradorController',    'liberar'],
    'moradores/cpf'                      => ['MoradorController',    'cpf'],
    'moradores/inativar'                 => ['MoradorController',    'inativar'],
    'moradores/deletar'                  => ['MoradorController',    'deletar'],
    'moradores/gestao'                   => ['MoradorController',    'gestao'],
    'moradores/gestao/salvar'            => ['MoradorController',    'gestaoSalvar'],
    'moradores/gestao/resetar-senha'     => ['MoradorController',    'resetarSenha'],
    'moradores/gestao/status'            => ['MoradorController',    'gestaoStatus'],
    'moradores/gestao/deletar'           => ['MoradorController',    'gestaoDeletar'],
    
    'dashboard'                      => ['DashboardController',  'index'],
    'painel'                         => ['PainelController',     'index'],
    'parametros'                     => ['ParametrosController', 'index'],
    'parametros/salvar'              => ['ParametrosController', 'salvar'],

    'reserva'                        => ['ReservaController',    'index'],
    'reserva/historico'              => ['ReservaController',    'historico'],
    'reserva/salvar'                 => ['ReservaController',    'salvar'],
    'reserva/local/editar'           => ['ReservaController',    'editarLocal'],
    'reservas/decidir'               => ['ReservaController',    'decidir'],

    'veiculo'                        => ['VeiculoController',    'index'],
    'veiculo/salvar'                 => ['VeiculoController',    'salvar'],
    'veiculo/editar'                 => ['VeiculoController',    'editar'],
    'veiculo/excluir'                => ['VeiculoController',    'excluir'],
    'veiculo/principal'              => ['VeiculoController',    'principal'],
    'veiculo/consultar'              => ['VeiculoController',    'consultar'],

    'api/feriados'                   => ['FeriadoController',    'index'],

    'financeiro/taxas'                => ['FinancasController',  'taxasCad'],
    'financeiro/taxas/salvar'         => ['FinancasController',  'salvarTaxas'],
    'financeiro/taxas/editar'         => ['FinancasController',  'editarTaxa'],
    'financeiro/taxas/excluir'        => ['FinancasController',  'excluirTaxa'],
    'financeiro/lancamento'           => ['FinancasController',  'lancamento'],
    'financeiro/lancamento/salvar'    => ['FinancasController',  'salvarLancamento'],
    'financeiro/lancamento/excluir'   => ['FinancasController',  'excluirLancamento'],
    'financeiro/historico'            => ['FinancasController',  'historico'],
    'financeiro/lancamento/verificar' => ['FinancasController',  'verificarDuplicado'],
    'financeiro/boleto'               => ['FinancasController',  'gerarBoleto'],
    'financeiro/pagar'                => ['FinancasController', 'confirmarPagamento'],

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
    'assembleia/presencas/detalhe'   => ['AssembleiaController', 'detalhePresencas'],


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
