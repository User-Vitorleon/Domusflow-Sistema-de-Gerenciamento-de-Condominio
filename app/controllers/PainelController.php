<?php
require_once __DIR__ . '/../middleware/AuthGuard.php';

class PainelController
{
    public function index(): void
    {
        $usuario = AuthGuard::requereUsuarioAtivo();

        require_once __DIR__ . '/../../resources/views/painel/index.php';
    }
}
