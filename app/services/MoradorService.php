<?php
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/EmailService.php';

class MoradorService
{
    private const PRIVILEGIOS_VALIDOS = [1, 2, 3, 4];

    private MoradorRepository $repo;

    public function __construct(?MoradorRepository $repo = null)
    {
        $this->repo = $repo ?? new MoradorRepository();
    }

    public function cadastrar(array $dados): array
    {
        if (empty($dados['termos'])) {
            return ['sucesso' => false, 'mensagem' => 'Você precisa aceitar os termos de uso.'];
        }

        $obrigatorios = [
            'nome'     => 'Por favor, preencha o campo nome.',
            'cpf'      => 'Por favor, preencha o CPF.',
            'apto'     => 'Por favor, preencha o número do apartamento.',
            'bloco'    => 'Por favor, preencha o bloco.',
            'email'    => 'Por favor, preencha o e-mail.',
            'telefone' => 'Por favor, preencha o telefone.',
            'senha'    => 'Por favor, preencha a senha.',
        ];
        foreach ($obrigatorios as $campo => $mensagem) {
            if (empty($dados[$campo])) {
                return ['sucesso' => false, 'mensagem' => $mensagem];
            }
        }

        $cpf = preg_replace('/[^0-9]/', '', $dados['cpf']);

        if ($dados['senha'] !== $dados['conf_senha']) {
            return ['sucesso' => false, 'mensagem' => 'As senhas não conferem.'];
        }

        if ($this->repo->existeCpf($cpf)) {
            return ['sucesso' => false, 'mensagem' => 'Este CPF já está cadastrado no sistema.'];
        }

        if ($this->repo->existeEmail($dados['email'])) {
            return ['sucesso' => false, 'mensagem' => 'Este e-mail já está cadastrado no sistema.'];
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
            'privilegio'      => $dados['privilegio'] ?? 1,
        ]);

        if (!$idNovoUsuario) {
            return ['sucesso' => false, 'mensagem' => 'Erro interno ao salvar os dados. Tente novamente.'];
        }

        $_SESSION['usuario_id']   = (int)$idNovoUsuario;
        $_SESSION['usuario_nome'] = $dados['nome'];

        $emailService = new EmailService();
        $emailService->boasVindas($dados['email'], $dados['nome']);

        return ['sucesso' => true];
    }

    public function listarPendentes(int $privilegioLogado = 2): array
    {
        $filtro = $privilegioLogado === 4 ? [1, 2, 3, 4] : [1];
        return $this->repo->findPendentes($filtro);
    }

    public function liberarOuBloquear(int $id, string $acao, int $idLogado): array
    {
        if (!in_array($acao, ['aceitar', 'negar'], true)) {
            return ['sucesso' => false, 'mensagem' => 'Ação inválida.'];
        }

        $solicitante = $this->repo->findById($idLogado);

        if (!$solicitante || !in_array((int)($solicitante['privilegio'] ?? 0), [2, 4])) {
            return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para realizar esta ação.'];
        }

        $morador = $this->repo->findById($id);
        if (!$morador) {
            return ['sucesso' => false, 'mensagem' => 'Morador não encontrado.'];
        }

        if ((int)$solicitante['privilegio'] === 2 && (int)($morador['privilegio'] ?? 1) !== 1) {
            return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para aprovar este perfil.'];
        }

        $novoStatus = ($acao === 'aceitar') ? 'L' : 'B';
        $this->repo->atualizarStatus($id, $novoStatus);

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
            if ($dadosUpdate['senha'] !== $dadosUpdate['conf_senha']) {
                return ['sucesso' => false, 'mensagem' => 'As senhas não conferem.'];
            }
            $dadosUpdate['senha'] = hashSenha($dadosUpdate['senha']);
        }

        if ($this->repo->existeEmailParaOutro($dadosUpdate['email'], (int)$dadosUpdate['id'])) {
            return ['sucesso' => false, 'mensagem' => 'Este e-mail já está em uso por outro cadastro.'];
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
        if (!in_array($privilegio, self::PRIVILEGIOS_VALIDOS, true)) {
            return false;
        }
        return $this->repo->atualizarPrivilegio($id, $privilegio);
    }

    public function resetarSenha(int $idMorador): array{
        $morador = $this->repo->findById($idMorador);
        if (!$morador) {
            return ['sucesso' => false, 'mensagem' => 'Morador não encontrado.'];
        }

        $novaSenha = substr(str_replace(['+', '/', '='], '', base64_encode(random_bytes(8))), 0, 8);
        $this->repo->atualizarSenha($idMorador, hashSenha($novaSenha));

        $emailService = new EmailService();
        $emailService->senhaResetada($morador['email'], $morador['nome'], $novaSenha);

        return ['sucesso' => true];
    }
}