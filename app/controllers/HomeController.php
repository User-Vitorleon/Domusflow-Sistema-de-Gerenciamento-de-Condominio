<?php
class HomeController {
    public function index(): void {
        if (isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit();
        }
        require_once __DIR__ . '/../../resources/views/home/index.php';
    }
}