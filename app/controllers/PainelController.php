<?php
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class PainelController
{
    private $moradorRepo;

    public function __construct()
    {
        $this->moradorRepo = new MoradorRepository();
    }

    public function index(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        $usuario = $this->moradorRepo->findById((int)$_SESSION['usuario_id']);

        if (!$usuario) {
            session_destroy();
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        if ($usuario['status'] === 'P') {
            header('Location: ' . BASE_URL . '/pendente');
            exit();
        }

        if ($usuario['status'] === 'B') {
            $_SESSION['erro_login'] = 'Esta conta está inativa. Entre em contato com o síndico.';
            session_unset();
            session_destroy();
            header('Location: ' . BASE_URL . '/');
            exit();
        }

        require_once __DIR__ . '/../../resources/views/painel/index.php';
    }
}
