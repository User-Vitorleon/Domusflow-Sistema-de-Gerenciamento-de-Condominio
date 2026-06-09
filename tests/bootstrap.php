<?php

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../app/models/Morador.php';
require_once __DIR__ . '/../app/models/Veiculo.php';
require_once __DIR__ . '/../app/models/Local.php';
require_once __DIR__ . '/../app/models/Reserva.php';

foreach (glob(__DIR__ . '/../app/helpers/*.php') as $arquivo) {
    require_once $arquivo;
}

foreach (glob(__DIR__ . '/../app/repositories/*.php') as $arquivo) {
    require_once $arquivo;
}

foreach (glob(__DIR__ . '/../app/services/*.php') as $arquivo) {
    require_once $arquivo;
}

require_once __DIR__ . '/Support/RepositoryTestCase.php';
require_once __DIR__ . '/Support/Fakes.php';
