<?php
require_once __DIR__ . '/../repositories/LocalRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class LocalService
{
    private LocalRepository   $localRepo;
    private MoradorRepository $moradorRepo;

    public function __construct(?LocalRepository $localRepo = null, ?MoradorRepository $moradorRepo = null)
    {
        $this->localRepo   = $localRepo ?? new LocalRepository();
        $this->moradorRepo = $moradorRepo ?? new MoradorRepository();
    }

    public function cadastrar(array $dados, int $idLogado): array
    {
        if (!$this->temPermissao($idLogado)) {
            return ['sucesso' => false, 'mensagem' => 'Sem permissão.'];
        }

        $nomeLocal = trim($dados['nome_local'] ?? '');
        if ($nomeLocal === '') {
            return ['sucesso' => false, 'mensagem' => 'Informe o nome do local.'];
        }

        if ((int)$dados['capacidade'] <= 0) {
            return ['sucesso' => false, 'mensagem' => 'Capacidade deve ser maior que zero.'];
        }

        $this->localRepo->save([
            'local'       => $nomeLocal,
            'capacidade'  => $dados['capacidade'],
            'disp_uso'    => $dados['disponivel'],
            'id_user_cad' => $idLogado,
        ]);

        return ['sucesso' => true];
    }

    private function temPermissao(int $idUsuario): bool
    {
        $usuario = $this->moradorRepo->findById($idUsuario);
        return $usuario && in_array($usuario['privilegio'] ?? 0, [2, 4], true);
    }
}
