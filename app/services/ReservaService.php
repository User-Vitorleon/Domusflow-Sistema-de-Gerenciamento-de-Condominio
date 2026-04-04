<?php
require_once __DIR__ . '/../repositories/ReservaRepository.php';
require_once __DIR__ . '/../repositories/LocalRepository.php';

class ReservaService
{
    private ReservaRepository $reservaRepo;
    private LocalRepository   $localRepo;

    public function __construct()
    {
        $this->reservaRepo = new ReservaRepository();
        $this->localRepo   = new LocalRepository();
    }

    public function salvar(array $dados, int $id_user): array
    {
        // ── Validação de campos obrigatórios ──────────
        if (
            empty($dados['id_local']) || empty($dados['data_reserva'])
            || empty($dados['hora_ini']) || empty($dados['hora_fim'])
        ) {
            return ['sucesso' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
        }

        // ── Data não pode ser no passado ──────────────
        if ($dados['data_reserva'] < date('Y-m-d')) {
            return ['sucesso' => false, 'mensagem' => 'Não é possível reservar uma data passada.'];
        }

        // ── Hora fim deve ser maior que hora início ───
        if ($dados['hora_fim'] <= $dados['hora_ini']) {
            return ['sucesso' => false, 'mensagem' => 'O horário de término deve ser maior que o de início.'];
        }

        // ── Local deve estar disponível ───────────────
        $local = $this->localRepo->findById((int)$dados['id_local']);
        if (!$local || $local['disp_uso'] !== 'S') {
            return ['sucesso' => false, 'mensagem' => 'Local indisponível para reserva.'];
        }

        // ── Conflito de horário no mesmo local ────────
        $conflito = $this->reservaRepo->existeConflito(
            (int)$dados['id_local'],
            $dados['data_reserva'],
            $dados['hora_ini'],
            $dados['hora_fim']
        );
        if ($conflito) {
            return ['sucesso' => false, 'mensagem' => 'Já existe uma reserva aprovada nesse horário para este local.'];
        }

        // ── Morador já tem reserva pendente no dia ────
        $jaPendente = $this->reservaRepo->existePendenteNoDia(
            $id_user,
            $dados['data_reserva']
        );
        if ($jaPendente) {
            return ['sucesso' => false, 'mensagem' => 'Você já possui uma reserva pendente nesta data.'];
        }

        // ── Salva ─────────────────────────────────────
        $this->reservaRepo->save([
            'id_local'     => (int)$dados['id_local'],
            'id_user'      => $id_user,
            'data_reserva' => $dados['data_reserva'],
            'hora_ini'     => $dados['hora_ini'],
            'hora_fim'     => $dados['hora_fim'],
        ]);

        return ['sucesso' => true];
    }

    public function listarLocaisDisponiveis(): array
    {
        return $this->localRepo->findDisponiveis();
    }

    public function listarPorUsuario(int $id_user): array
    {
        return $this->reservaRepo->findByUsuario($id_user);
    }
}
