<?php
require_once __DIR__ . '/../services/FeriadoService.php';

<<<<<<< HEAD
class FeriadoController {
    private FeriadoService $service;

    public function __construct() {
        $this->service = new FeriadoService();
    }

    public function index(): void {
        $ano      = (int)($_GET['ano'] ?? date('Y'));
        $feriados = $this->service->getFeriadosPorAno($ano);
=======
class FeriadoController
{
    private FeriadoService $service;

    public function __construct()
    {
        $this->service = new FeriadoService();
    }

    public function index(): void
    {
        $ano      = (int) ($_GET['ano'] ?? date('Y'));
        $feriados = $this->service->getFeriadosPorAno($ano);

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        header('Content-Type: application/json');
        echo json_encode($feriados);
        exit();
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
