<?php
require_once __DIR__ . '/../repositories/ReservaRepository.php';
require_once __DIR__ . '/../repositories/LocalRepository.php';

class ReservaService {
    private ReservaRepository $reservaRepo;
    private LocalRepository   $localRepo;

    public function __construct() {
        $this->reservaRepo = new ReservaRepository();
        $this->localRepo   = new LocalRepository();
    }

    public function salvar(array $dados, int $id_user): array {
        $this->reservaRepo->save([
            'id_local'     => $dados['id_local'],
            'id_user'      => $id_user,
            'data_reserva' => $dados['data_reserva'],
            'hora_ini'     => $dados['hora_ini'],
            'hora_fim'     => $dados['hora_fim'],
        ]);
        return ['sucesso' => true];
    }

    public function listarLocaisDisponiveis(): array {
        return $this->localRepo->findDisponiveis();
    }
}