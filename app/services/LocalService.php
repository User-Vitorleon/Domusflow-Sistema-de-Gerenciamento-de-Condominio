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
            return ['sucesso' => false, 'mensagem' => 'Sem permissao.'];
        }

        $validacao = $this->validarDadosLocal($dados);
        if (!$validacao['sucesso']) {
            return $validacao;
        }

        $this->localRepo->save([
            'local'       => $validacao['dados']['local'],
            'capacidade'  => $validacao['dados']['capacidade'],
            'disp_uso'    => $validacao['dados']['disp_uso'],
            'id_user_cad' => $idLogado,
        ]);

        return ['sucesso' => true];
    }

    public function atualizar(array $dados, int $idLogado): array
    {
        if (!$this->temPermissao($idLogado)) {
            return ['sucesso' => false, 'mensagem' => 'Sem permissao.'];
        }

        $idLocal = (int)($dados['id_local'] ?? 0);
        if ($idLocal <= 0 || !$this->localRepo->findById($idLocal)) {
            return ['sucesso' => false, 'mensagem' => 'Local nao encontrado.'];
        }

        $validacao = $this->validarDadosLocal($dados);
        if (!$validacao['sucesso']) {
            return $validacao;
        }

        return $this->localRepo->update($idLocal, $validacao['dados'])
            ? ['sucesso' => true]
            : ['sucesso' => false, 'mensagem' => 'Erro ao atualizar local.'];
    }

    private function validarDadosLocal(array $dados): array
    {
        $nomeLocal = trim($dados['nome_local'] ?? '');
        if ($nomeLocal === '') {
            return ['sucesso' => false, 'mensagem' => 'Informe o nome do local.'];
        }

        $capacidade = (int)($dados['capacidade'] ?? 0);
        if ($capacidade <= 0) {
            return ['sucesso' => false, 'mensagem' => 'Capacidade deve ser maior que zero.'];
        }

        $disponivel = strtoupper(trim($dados['disponivel'] ?? 'S'));
        if (!in_array($disponivel, ['S', 'N'], true)) {
            return ['sucesso' => false, 'mensagem' => 'Status do local invalido.'];
        }

        return [
            'sucesso' => true,
            'dados' => [
                'local'      => $nomeLocal,
                'capacidade' => $capacidade,
                'disp_uso'   => $disponivel,
            ],
        ];
    }

    private function temPermissao(int $idUsuario): bool
    {
        $usuario = $this->moradorRepo->findById($idUsuario);
        return $usuario && in_array((int)($usuario['privilegio'] ?? 0), [2, 4], true);
    }
}
