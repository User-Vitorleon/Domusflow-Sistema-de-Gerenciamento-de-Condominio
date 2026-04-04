<?php
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class MoradorService
{
    private MoradorRepository $repo;

    public function __construct()
    {
        $this->repo = new MoradorRepository();
    }

    public function cadastrar(array $dados): array
    {
        $cpf = preg_replace('/[^0-9]/', '', $dados['cpf']); // remove formatação

        if ($dados['senha'] !== $dados['conf_senha']) {
            return ['sucesso' => false, 'mensagem' => 'As senhas não conferem.'];
        }

        if ($this->repo->existeCpf($cpf)) {
            return ['sucesso' => false, 'mensagem' => 'CPF já cadastrado.'];
        }

        $this->repo->save([
            'nome'            => $dados['nome'],
            'cpf'             => $cpf,              // ← salva só números
            'apto'            => $dados['apto'],
            'bloco'           => $dados['bloco'],
            'email'           => $dados['email'],
            'sexo'            => $dados['sexo'],
            'telefone'        => $dados['telefone'],
            'telefone_recado' => $dados['telefone_recado'] ?? null,
            'senha'           => password_hash($dados['senha'], PASSWORD_DEFAULT),
        ]);

        return ['sucesso' => true];
    }

    public function listarPendentes(): array
    {
        return $this->repo->findPendentes();
    }

    public function liberarOuBloquear(int $id, string $acao, int $id_logado): array
    {
        $solicitante = $this->repo->findById($id_logado);
        if (!$solicitante || $solicitante['previlegio'] != 2) {
            return ['sucesso' => false, 'mensagem' => 'Sem permissão.'];
        }

        $novoStatus = ($acao === 'aceitar') ? 'L' : 'B';
        $this->repo->atualizarStatus($id, $novoStatus);

        return ['sucesso' => true, 'status' => ($acao === 'aceitar') ? 'liberado' : 'negado'];
    }
}
