<?php
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/EmailService.php';

class MoradorService
{
    private MoradorRepository $repo;

    public function __construct(?MoradorRepository $repo = null)
    {
        $this->repo = $repo ?? new MoradorRepository();
    }

    public function cadastrar(array $dados): array
    {
        $cpf = preg_replace('/[^0-9]/', '', $dados['cpf']);

        if ($dados['senha'] !== $dados['conf_senha']) {
            return ['sucesso' => false, 'mensagem' => 'As senhas não conferem.'];
        }

        if ($this->repo->existeCpf($cpf)) {
            return ['sucesso' => false, 'mensagem' => 'Este CPF já está cadastrado no sistema.'];
        }

        $idNovoUsuario = $this->repo->save([
            'nome'            => $dados['nome'],
            'cpf'             => $cpf,
            'apto'            => $dados['apto'],
            'bloco'           => $dados['bloco'],
            'email'           => $dados['email'],
            'telefone'        => $dados['telefone'],
            'telefone_recado' => $dados['telefone_recado'] ?? null,
            'senha'           => hashSenha($dados['senha']),
            'status'          => 'P',
        ]);

        if (!$idNovoUsuario) {
            return [
                'sucesso'  => false,
                'mensagem' => 'Erro interno ao salvar os dados. Tente novamente.',
            ];
        }

        $_SESSION['usuario_id']   = (int)$idNovoUsuario;
        $_SESSION['usuario_nome'] = $dados['nome'];

        $emailService = new EmailService();
        $emailService->boasVindas($dados['email'], $dados['nome']);

        return ['sucesso' => true];
    }

    public function listarPendentes(): array
    {
        return $this->repo->findPendentes();
    }

    public function liberarOuBloquear(int $id, string $acao, int $idLogado): array
    {
        $solicitante = $this->repo->findById($idLogado);
        if (!$solicitante || !in_array($solicitante['privilegio'] ?? 0, [2, 4])) {
            return [
                'sucesso'  => false,
                'mensagem' => 'Você não tem permissão para realizar esta ação.',
            ];
        }

        $novoStatus = ($acao === 'aceitar') ? 'L' : 'B';
        $this->repo->atualizarStatus($id, $novoStatus);

        $morador      = $this->repo->findById($id);
        $emailService = new EmailService();
        if ($acao === 'aceitar') {
            $emailService->contaAprovada($morador['email'], $morador['nome']);
        } else {
            $emailService->contaNegada($morador['email'], $morador['nome']);
        }

        return [
            'sucesso' => true,
            'status'  => ($acao === 'aceitar') ? 'liberado' : 'negado',
        ];
    }

    public function atualizar(array $dadosUpdate): array
    {
        $camposObrigatorios = [
            'nome'     => 'Por favor, preencha o campo nome!',
            'email'    => 'Por favor, preencha o campo Email!',
            'bloco'    => 'Por favor, preencha o campo com o Bloco que reside!',
            'apto'     => 'Por favor, preencha o campo com o número do Apto que reside!',
            'telefone' => 'Por favor, preencha o campo com seu número para contato!',
        ];

        foreach ($camposObrigatorios as $campo => $mensagem) {
            if (empty($dadosUpdate[$campo])) {
                return ['sucesso' => false, 'mensagem' => $mensagem];
            }
        }

        if (!empty($dadosUpdate['senha'])) {
            $dadosUpdate['senha'] = hashSenha($dadosUpdate['senha']);
        }

        $atualizado = $this->repo->atualizarDados($dadosUpdate);
        return $atualizado
            ? ['sucesso' => true]
            : ['sucesso' => false, 'mensagem' => 'Erro ao atualizar. Tente novamente.'];
    }

    public function deletar(array $dados): array
    {
        $this->repo->deletarDados($dados['id']);
        return ['sucesso' => true];
    }

    public function atualizarPrivilegio(int $id, int $privilegio): bool
    {
        return $this->repo->atualizarPrivilegio($id, $privilegio);
    }
}
