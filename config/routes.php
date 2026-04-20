<?php
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$uri = preg_replace('#^Domusflow_novo/?#i', '', $uri);
$uri = trim($uri, '/');

$routes = [
    // Autenticação
    ''                    => ['HomeController',      'index'],
    'login'               => ['AuthController',      'login'],
    'logout'              => ['AuthController',      'logout'],
    'pendente'            => ['AuthController',      'pendente'],
    'pendente/checar'     => ['AuthController',      'checar'],

    // moradores
    'cadastro'               => ['MoradorController',   'formCadastro'],
    'cadastro/salvar'        => ['MoradorController',   'salvar'],
    'cadastro/update'        => ['MoradorController',   'formUpdate'  ],
    'cadastro/update/salvar' => ['Moradorcontroller',   'updateSalvar'],
    'moradores/pendentes'    => ['MoradorController',   'pendentes'],
    'moradores/liberar'      => ['MoradorController',   'liberar'],
    'moradores/inativar'     => ['MoradorController',   'inativar'],
    'moradores/deletar'      => ['MoradorController',   'deletar'],

    // Dashboard
    'dashboard'           => ['DashboardController', 'index'],

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
