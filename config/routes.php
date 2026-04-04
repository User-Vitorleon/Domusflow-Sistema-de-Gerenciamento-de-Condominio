<?php
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$uri = preg_replace('#^Domusflow_novo/?#i', '', $uri);
$uri = trim($uri, '/');

$routes = [
    ''                    => ['HomeController',      'index'],
    'login'               => ['AuthController',      'login'],
    'logout'              => ['AuthController',      'logout'],
    'cadastro'            => ['MoradorController',   'formCadastro'],
    'cadastro/salvar'     => ['MoradorController',   'salvar'],
    'dashboard'           => ['DashboardController', 'index'],
    'pendente'            => ['AuthController',      'pendente'],
    'pendente/checar'     => ['AuthController',      'checar'],
    'reserva'             => ['ReservaController',   'index'],
    'reserva/salvar'      => ['ReservaController',   'salvar'],
    'moradores/pendentes' => ['MoradorController',   'pendentes'],
    'moradores/liberar'   => ['MoradorController',   'liberar'],
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