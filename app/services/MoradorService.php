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
            'sexo'            => $dados['sexo'],
            'telefone'        => $dados['telefone'],
            'telefone_recado' => $dados['telefone_recado'] ?? null,
            'senha'           => hashSenha($dados['senha']),
            'status'          => 'P' 
        ]);

        if ($idNovoUsuario) {
            $_SESSION['usuario_id']   = (int)$idNovoUsuario;
            $_SESSION['usuario_nome'] = $dados['nome'];
      
            
            return ['sucesso' => true];
        }

        return ['sucesso' => false, 'mensagem' => 'Erro interno ao salvar os dados. Tente novamente.'];
    }


    public function listarPendentes(): array
    {
        return $this->repo->findPendentes();
    }

    public function liberarOuBloquear(int $id, string $acao, int $id_logado): array
    {
    
        $solicitante = $this->repo->findById($id_logado);
        if (!$solicitante || ($solicitante['previlegio'] ?? 0) != 2) {
            return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para realizar esta ação.'];
        }

        $novoStatus = ($acao === 'aceitar') ? 'L' : 'B';
        $this->repo->atualizarStatus($id, $novoStatus);

        return [
            'sucesso' => true, 
            'status'  => ($acao === 'aceitar') ? 'liberado' : 'negado'
        ];
    }

    public function atualizar(array $dadosUpdate): array{

        if (empty($dadosUpdate['nome'])){
            return ['sucesso' => false, 'mensagem' => 'Por favor, preencha o campo nome !'];
        }

        if (empty($dadosUpdate['email'])){
            return ['sucesso' => false, 'mensagem' => 'Por favor, preencha o campo Email !'];
        }

        if (empty($dadosUpdate['bloco'])){
            return ['sucesso' => false, 'mensagem' => 'Por favor, preencha o campo com o Bloco que reside !'];
        }

        if (empty($dadosUpdate['apto'])){
            return ['sucesso' => false, 'mensagem' => 'Por favor, preencha o campo com o numero do Apto que reside !'];
        }

        if (empty($dadosUpdate['telefone'])){
            return ['sucesso' => false, 'mensagem' => 'Por favor, preencha o campo com seu numero para contato !'];
        }

        if (!empty($dadosUpdate['senha'])) {
            $dadosUpdate['senha'] = hashSenha($dadosUpdate['senha']);
        }
        $atualizado = $this->repo->atualizarDados($dadosUpdate);
        return $atualizado
            ? ['sucesso' => true]
            : ['sucesso' => false, 'mensagem' => 'Erro ao atualizar. Tente novamente.'];

    }

    public function deletar(array $dados): array{
        $this->repo->deletarDados($dados['id']);
        return ['sucesso' => true];
    }
}