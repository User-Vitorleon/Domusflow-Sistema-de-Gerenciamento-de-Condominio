<?php
<<<<<<< HEAD
class HomeController {
    public function index(): void {
=======

class HomeController
{
    public function index(): void
    {
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        if (isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/dashboard');
            exit();
        }
        require_once __DIR__ . '/../../resources/views/home/index.php';
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
