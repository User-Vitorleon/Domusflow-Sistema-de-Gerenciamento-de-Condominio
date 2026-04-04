<?php
require_once __DIR__ . '/../services/FeriadoService.php';

class FeriadoController {
    private FeriadoService $service;

    public function __construct() {
        $this->service = new FeriadoService();
    }

    public function index(): void {
        $ano      = (int)($_GET['ano'] ?? date('Y'));
        $feriados = $this->service->getFeriadosPorAno($ano);
        header('Content-Type: application/json');
        echo json_encode($feriados);
        exit();
    }
}