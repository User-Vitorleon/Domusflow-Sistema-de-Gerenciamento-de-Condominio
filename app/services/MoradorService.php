<?php
require_once __DIR__ . '/../repositories/MoradorRepository.php';
require_once __DIR__ . '/EmailService.php';
require_once __DIR__ . '/ParametrosService.php';

class MoradorService
{
    private const PRIVILEGIOS_VALIDOS = [1, 2, 3, 4];
    private const STATUS_GESTAO_VALIDOS = ['L', 'I', 'B'];

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
        $privilegio = (int) ($dados['privilegio'] ?? 1);
        if (!in_array($privilegio, self::PRIVILEGIOS_VALIDOS, true)) {
            $privilegio = 1;
        }

        [$apto, $bloco] = self::unidadePorPrivilegio($privilegio, $dados['apto'], $dados['bloco']);

        if (!self::cpfValido($cpf)) {
            return ['sucesso' => false, 'mensagem' => 'CPF inválido.'];
        }

        if ($apto === '') {
            return ['sucesso' => false, 'mensagem' => 'Apartamento deve conter apenas números.'];
        }

        if ($bloco === '') {
            return ['sucesso' => false, 'mensagem' => 'Bloco deve conter apenas uma letra.'];
        }

        if ($dados['senha'] !== $dados['conf_senha']) {
            return ['sucesso' => false, 'mensagem' => 'As senhas não conferem.'];
        }

        if ($this->repo->existeCpf($cpf)) {
            return ['sucesso' => false, 'mensagem' => 'Este CPF já está cadastrado no sistema.'];
        }

        if ($this->repo->existeEmail($dados['email'])) {
            return ['sucesso' => false, 'mensagem' => 'Este e-mail já está cadastrado no sistema.'];
        }

        if (self::exigeUnidadeReal($privilegio) && $this->repo->existeMoradorAtivoNaUnidade($apto, $bloco)) {
            return ['sucesso' => false, 'mensagem' => 'Já existe um morador ativo para este apartamento e bloco.'];
        }

        $idNovoUsuario = $this->repo->save([
            'nome'            => $dados['nome'],
            'cpf'             => $cpf,
            'apto'            => $apto,
            'bloco'           => $bloco,
            'email'           => $dados['email'],
            'telefone'        => $dados['telefone'],
            'telefone_recado' => $dados['telefone_recado'] ?? null,
            'senha'           => hashSenha($dados['senha']),
            'status'          => 'P',
            'privilegio'      => $privilegio,
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

    public function liberarOuBloquear(int $id, string $acao, int $idLogado, ?array $unidade = null): array
    {
        if (!in_array($acao, ['aceitar', 'recusar'], true)) {
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

        $privilegioMorador = (int)($morador['privilegio'] ?? 1);

        if ($acao === 'aceitar' && $privilegioMorador === 1) {
            $parametros = new ParametrosService();
            if ($this->repo->countMoradoresAtivos() >= $parametros->limiteMoradoresAtivos()) {
                return ['sucesso' => false, 'mensagem' => 'Limite de moradores ativos atingido. Ajuste os parametros do sistema antes de aprovar novos moradores.'];
            }
        }

        if ($acao === 'aceitar' && $unidade !== null) {
            [$apto, $bloco] = self::unidadePorPrivilegio($privilegioMorador, $unidade['apto'] ?? '', $unidade['bloco'] ?? '');
            $resultadoUnidade = $this->atualizarUnidade($id, $apto, $bloco, $privilegioMorador);
            if (!$resultadoUnidade['sucesso']) {
                return $resultadoUnidade;
            }
        }

        $morador = $this->repo->findById($id);
        if ($acao === 'aceitar'
            && self::exigeUnidadeReal($privilegioMorador)
            && $this->repo->existeMoradorAtivoNaUnidade($morador['apto'], $morador['bloco'], $id)
        ) {
            return ['sucesso' => false, 'mensagem' => 'Já existe um morador ativo para este apartamento e bloco.'];
        }

        $emailService = new EmailService();
        if ($acao === 'aceitar') {
            $this->repo->atualizarStatus($id, 'L');
            $emailService->contaAprovada($morador['email'], $morador['nome']);
        } else {
            $this->repo->deletarDados($id);
            $emailService->contaNegada($morador['email'], $morador['nome']);
        }

        return [
            'sucesso' => true,
            'status'  => ($acao === 'aceitar') ? 'liberado' : 'recusado',
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

    public function atualizarStatusGestao(int $id, string $status): array
    {
        $status = strtoupper(trim($status));

        if ($id <= 0 || !in_array($status, self::STATUS_GESTAO_VALIDOS, true)) {
            return ['sucesso' => false, 'mensagem' => 'Status invalido.'];
        }

        $morador = $this->repo->findById($id);
        if ($status === 'L'
            && $morador
            && self::exigeUnidadeReal((int)($morador['privilegio'] ?? 1))
            && $this->repo->existeMoradorAtivoNaUnidade($morador['apto'], $morador['bloco'], $id)
        ) {
            return ['sucesso' => false, 'mensagem' => 'Já existe um morador ativo para este apartamento e bloco.'];
        }

        return $this->repo->atualizarStatus($id, $status)
            ? ['sucesso' => true]
            : ['sucesso' => false, 'mensagem' => 'Erro ao atualizar status.'];
    }

    public function atualizarPrivilegio(int $id, int $privilegio): bool
    {
        if (!in_array($privilegio, self::PRIVILEGIOS_VALIDOS, true)) {
            return false;
        }
        $morador = $this->repo->findById($id);
        if (!$morador || (int)($morador['privilegio'] ?? 0) === 4) {
            return false;
        }
        return $this->repo->atualizarPrivilegio($id, $privilegio);
    }

    public function atualizarPrivilegioEUnidade(int $id, int $privilegio, string $apto, string $bloco): bool
    {
        [$apto, $bloco] = self::unidadePorPrivilegio($privilegio, $apto, $bloco);

        $morador = $this->repo->findById($id);
        if ($apto === ''
            || $bloco === ''
            || ($morador && ($morador['status'] ?? '') === 'L'
                && self::exigeUnidadeReal($privilegio)
                && $this->repo->existeMoradorAtivoNaUnidade($apto, $bloco, $id))
            || !$this->atualizarPrivilegio($id, $privilegio)
        ) {
            return false;
        }

        return $this->atualizarUnidade($id, $apto, $bloco, $privilegio)['sucesso'];
    }

    public function atualizarUnidade(int $id, string $apto, string $bloco, ?int $privilegio = null): array
    {
        if ($privilegio !== null) {
            [$apto, $bloco] = self::unidadePorPrivilegio($privilegio, $apto, $bloco);
        } else {
            $apto = self::normalizarApto($apto);
            $bloco = self::normalizarBloco($bloco);
        }

        if ($id <= 0 || $apto === '' || $bloco === '') {
            return ['sucesso' => false, 'mensagem' => 'Informe apartamento numérico e bloco com uma letra.'];
        }

        return $this->repo->atualizarUnidade($id, $apto, $bloco)
            ? ['sucesso' => true]
            : ['sucesso' => false, 'mensagem' => 'Erro ao atualizar bloco e apartamento.'];
    }

    private static function normalizarApto(string $apto): string
    {
        return preg_replace('/\D/', '', $apto);
    }

    private static function normalizarBloco(string $bloco): string
    {
        $bloco = strtoupper(trim($bloco));
        return preg_match('/^[A-Z]$/', $bloco) ? $bloco : '';
    }

    private static function exigeUnidadeReal(int $privilegio): bool
    {
        return in_array($privilegio, [1, 2], true);
    }

    private static function unidadePorPrivilegio(int $privilegio, string $apto, string $bloco): array
    {
        if (!self::exigeUnidadeReal($privilegio)) {
            return ['0', 'G'];
        }

        return [self::normalizarApto($apto), self::normalizarBloco($bloco)];
    }

    private static function cpfValido(string $cpf): bool
    {
        if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $soma = 0;
            for ($i = 0; $i < $t; $i++) {
                $soma += (int) $cpf[$i] * (($t + 1) - $i);
            }
            $digito = ((10 * $soma) % 11) % 10;
            if ((int) $cpf[$t] !== $digito) {
                return false;
            }
        }

        return true;
    }

    public function resetarSenha(int $idMorador, bool $resetadoPeloAdmin = false): array{
        $morador = $this->repo->findById($idMorador);
        if (!$morador) {
            return ['sucesso' => false, 'mensagem' => 'Morador não encontrado.'];
        }

        $novaSenha = substr(str_replace(['+', '/', '='], '', base64_encode(random_bytes(8))), 0, 8);
        $this->repo->atualizarSenha($idMorador, hashSenha($novaSenha));

        $emailService = new EmailService();
        if ($resetadoPeloAdmin) {
            $emailService->senhaResetada($morador['email'], $morador['nome'], $novaSenha);
        } else {
            $emailService->senhaEsquecida($morador['email'], $morador['nome'], $novaSenha);
        }

        return ['sucesso' => true];
    }
}
