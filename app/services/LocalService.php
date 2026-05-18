<?php
require_once __DIR__ . '/../repositories/LocalRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class LocalService
{
    private LocalRepository   $localRepo;
    private MoradorRepository $moradorRepo;

    public function __construct()
    {
        $this->localRepo   = new LocalRepository();
        $this->moradorRepo = new MoradorRepository();
    }

    public function cadastrar(array $dados, int $id_logado): array
    {
        $solicitante = $this->moradorRepo->findById($id_logado);
        if (!$solicitante || !in_array($solicitante['privilegio'] ?? 0, [2, 4])) {
            return ['sucesso' => false, 'mensagem' => 'Sem permissão.'];
        }

        if ((int)$dados['capacidade'] <= 0) {
            return ['sucesso' => false, 'mensagem' => 'Capacidade deve ser maior que zero.'];
        }

        $this->localRepo->save([
            'local'       => $dados['nome_local'],
            'capacidade'  => $dados['capacidade'],
            'disp_uso'    => $dados['disponivel'],
            'id_user_cad' => $id_logado,
        ]);

        return ['sucesso' => true];
    }
}
