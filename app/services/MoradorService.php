<?php
<<<<<<< HEAD

=======
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/EmailService.php';

class MoradorService
{
    private MoradorRepository $repo;

<<<<<<< HEAD
    public function __construct()
    {
        $this->repo = new MoradorRepository();
=======
    public function __construct(?MoradorRepository $repo = null)
    {
        $this->repo = $repo ?? new MoradorRepository();
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function cadastrar(array $dados): array
    {
<<<<<<< HEAD

        $cpf = preg_replace('/[^0-9]/', '', $dados['cpf']);


=======
        $cpf = preg_replace('/[^0-9]/', '', $dados['cpf']);

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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
<<<<<<< HEAD
            'status'          => 'P'
        ]);

        if ($idNovoUsuario) {
            $_SESSION['usuario_id']   = (int)$idNovoUsuario;
            $_SESSION['usuario_nome'] = $dados['nome'];

            $emailservice = new EmailService();
            $emailservice->boasVindas($dados['email'], $dados['nome']);

            return ['sucesso' => true];
        }

        return ['sucesso' => false, 'mensagem' => 'Erro interno ao salvar os dados. Tente novamente.'];
    }

=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

    public function listarPendentes(): array
    {
        return $this->repo->findPendentes();
    }

<<<<<<< HEAD
    public function liberarOuBloquear(int $id, string $acao, int $id_logado): array
    {
        $solicitante = $this->repo->findById($id_logado);
        if (!$solicitante || !in_array($solicitante['privilegio'] ?? 0, [2, 4])) {
            return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para realizar esta ação.'];
=======
    public function liberarOuBloquear(int $id, string $acao, int $idLogado): array
    {
        $solicitante = $this->repo->findById($idLogado);
        if (!$solicitante || !in_array($solicitante['privilegio'] ?? 0, [2, 4])) {
            return [
                'sucesso'  => false,
                'mensagem' => 'Você não tem permissão para realizar esta ação.',
            ];
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        }

        $novoStatus = ($acao === 'aceitar') ? 'L' : 'B';
        $this->repo->atualizarStatus($id, $novoStatus);

<<<<<<< HEAD
        $morador = $this->repo->findById($id);
        $emailservice = new EmailService();
        if ($acao === 'aceitar') {
            $emailservice->contaAprovada($morador['email'], $morador['nome']);
        } else {
            $emailservice->contaNegada($morador['email'], $morador['nome']);
=======
        $morador      = $this->repo->findById($id);
        $emailService = new EmailService();
        if ($acao === 'aceitar') {
            $emailService->contaAprovada($morador['email'], $morador['nome']);
        } else {
            $emailService->contaNegada($morador['email'], $morador['nome']);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        }

        return [
            'sucesso' => true,
<<<<<<< HEAD
            'status'  => ($acao === 'aceitar') ? 'liberado' : 'negado'
=======
            'status'  => ($acao === 'aceitar') ? 'liberado' : 'negado',
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        ];
    }

    public function atualizar(array $dadosUpdate): array
    {
<<<<<<< HEAD

        if (empty($dadosUpdate['nome'])) {
            return ['sucesso' => false, 'mensagem' => 'Por favor, preencha o campo nome !'];
        }

        if (empty($dadosUpdate['email'])) {
            return ['sucesso' => false, 'mensagem' => 'Por favor, preencha o campo Email !'];
        }

        if (empty($dadosUpdate['bloco'])) {
            return ['sucesso' => false, 'mensagem' => 'Por favor, preencha o campo com o Bloco que reside !'];
        }

        if (empty($dadosUpdate['apto'])) {
            return ['sucesso' => false, 'mensagem' => 'Por favor, preencha o campo com o numero do Apto que reside !'];
        }

        if (empty($dadosUpdate['telefone'])) {
            return ['sucesso' => false, 'mensagem' => 'Por favor, preencha o campo com seu numero para contato !'];
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        }

        if (!empty($dadosUpdate['senha'])) {
            $dadosUpdate['senha'] = hashSenha($dadosUpdate['senha']);
        }
<<<<<<< HEAD
=======

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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

<<<<<<< HEAD
    public function atualizarPrivilegio(int $id, int $privilegio): bool{
        return $this->repo->atualizarPrivilegio($id, $privilegio);
}
=======
    public function atualizarPrivilegio(int $id, int $privilegio): bool
    {
        return $this->repo->atualizarPrivilegio($id, $privilegio);
    }
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
}
