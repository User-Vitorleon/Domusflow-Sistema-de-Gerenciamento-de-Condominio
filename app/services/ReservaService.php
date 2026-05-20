<?php
require_once __DIR__ . '/../repositories/ReservaRepository.php';
require_once __DIR__ . '/../repositories/LocalRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/EmailService.php';

class ReservaService
{
    private ReservaRepository $reservaRepo;
    private LocalRepository   $localRepo;
    private MoradorRepository $moradorRepo;

<<<<<<< HEAD
    public function __construct()
    {
        $this->reservaRepo = new ReservaRepository();
        $this->localRepo   = new LocalRepository();
        $this->moradorRepo = new MoradorRepository(); 
    }

    public function salvar(array $dados, int $id_user): array
    {
        // ── Validação de campos obrigatórios ──────────
=======
    public function __construct(
        ?ReservaRepository $reservaRepo = null,
        ?LocalRepository $localRepo = null,
        ?MoradorRepository $moradorRepo = null
    )
    {
        $this->reservaRepo = $reservaRepo ?? new ReservaRepository();
        $this->localRepo   = $localRepo ?? new LocalRepository();
        $this->moradorRepo = $moradorRepo ?? new MoradorRepository();
    }

    public function salvar(array $dados, int $idUser): array
    {
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        if (
            empty($dados['id_local']) || empty($dados['data_reserva'])
            || empty($dados['hora_ini']) || empty($dados['hora_fim'])
        ) {
            return ['sucesso' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
        }

<<<<<<< HEAD
        // ── Data não pode ser no passado ──────────────
=======
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        if ($dados['data_reserva'] < date('Y-m-d')) {
            return ['sucesso' => false, 'mensagem' => 'Não é possível reservar uma data passada.'];
        }

<<<<<<< HEAD
        // ── Hora fim deve ser maior que hora início ───
        if ($dados['hora_fim'] <= $dados['hora_ini']) {
            return ['sucesso' => false, 'mensagem' => 'O horário de término deve ser maior que o de início.'];
        }

        // ── Local deve estar disponível ───────────────
=======
        if ($dados['hora_fim'] <= $dados['hora_ini']) {
            return [
                'sucesso'  => false,
                'mensagem' => 'O horário de término deve ser maior que o de início.',
            ];
        }

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $local = $this->localRepo->findById((int)$dados['id_local']);
        if (!$local || $local['disp_uso'] !== 'S') {
            return ['sucesso' => false, 'mensagem' => 'Local indisponível para reserva.'];
        }

<<<<<<< HEAD
        // ── Conflito de horário no mesmo local ────────
=======
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $conflito = $this->reservaRepo->existeConflito(
            (int)$dados['id_local'],
            $dados['data_reserva'],
            $dados['hora_ini'],
            $dados['hora_fim']
        );
        if ($conflito) {
<<<<<<< HEAD
            return ['sucesso' => false, 'mensagem' => 'Já existe uma reserva aprovada nesse horário para este local.'];
        }

        // ── Morador já tem reserva pendente no dia ────
        $jaPendente = $this->reservaRepo->existeReservaPendente($id_user);
        if ($jaPendente) {
            return ['sucesso' => false, 'mensagem' => 'Já possui uma reserva pendente. Aguarde a aprovação do sindico antes de fazer uma nova !'];
        }


        $this->reservaRepo->save([
            'id_local'     => (int)$dados['id_local'],
            'id_user'      => $id_user,
=======
            return [
                'sucesso'  => false,
                'mensagem' => 'Já existe uma reserva aprovada nesse horário para este local.',
            ];
        }

        if ($this->reservaRepo->existeReservaPendente($idUser)) {
            return [
                'sucesso'  => false,
                'mensagem' => 'Já possui uma reserva pendente. Aguarde a aprovação do síndico antes de fazer uma nova!',
            ];
        }

        $this->reservaRepo->save([
            'id_local'     => (int)$dados['id_local'],
            'id_user'      => $idUser,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            'data_reserva' => $dados['data_reserva'],
            'hora_ini'     => $dados['hora_ini'],
            'hora_fim'     => $dados['hora_fim'],
        ]);

<<<<<<< HEAD
        $morador = $this->moradorRepo->findById($id_user);

        $emailService = new EmailService();
        $emailService->reservaPendente($morador['email'], 
                                       $morador['nome'], 
                                       $local['local'], 
                                       $dados ['data_reserva'], 
                                       $dados['hora_ini'], 
                                       $dados['hora_fim']);
=======
        $morador      = $this->moradorRepo->findById($idUser);
        $emailService = new EmailService();
        $emailService->reservaPendente(
            $morador['email'],
            $morador['nome'],
            $local['local'],
            $dados['data_reserva'],
            $dados['hora_ini'],
            $dados['hora_fim']
        );
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        return ['sucesso' => true];
    }

    public function listarLocaisDisponiveis(): array
    {
        return $this->localRepo->findDisponiveis();
    }

<<<<<<< HEAD
    public function listarPorUsuario(int $id_user): array
    {
        return $this->reservaRepo->findByUsuario($id_user);
    }

    public function listarPendentesGeral(int $offset = 0, int $limite = 10): array{
        return $this->reservaRepo->buscarReservasPendentesGeral($offset, $limite);
    }

    public function contarPendentesGeral(): int{
=======
    public function listarPendentesGeral(int $offset = 0, int $limite = 10): array
    {
        return $this->reservaRepo->buscarReservasPendentesGeral($offset, $limite);
    }

    public function contarPendentesGeral(): int
    {
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        return $this->reservaRepo->countPendentesGeral();
    }
}
