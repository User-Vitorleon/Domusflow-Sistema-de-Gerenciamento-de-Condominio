<?php
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class AuthService
{
    private MoradorRepository $repo;

    public function __construct()
    {
        $this->repo = new MoradorRepository();
    }

    public function login(string $cpf, string $senha): array
{
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    $usuario = $this->repo->findByCpf($cpf);

    if (!$usuario || !password_verify($senha, $usuario['senha'])) {
        return ['sucesso' => false, 'mensagem' => 'CPF ou senha incorretos.'];
    }

    // Definimos os dados básicos da sessão para todos que passarem na senha
    $_SESSION['usuario_id']   = $usuario['id_user'];
    $_SESSION['usuario_nome'] = $usuario['nome'];

    // Se estiver pendente, avisamos o Controller para mandar para /pendente
    if ($usuario['status'] === 'P') {
        return ['sucesso' => true, 'redirecionar' => BASE_URL . '/pendente'];
    }

    if ($usuario['status'] === 'B') {
        return ['sucesso' => false, 'mensagem' => 'Acesso bloqueado. Entre em contato com o síndico.'];
    }

    // Se chegou aqui, está Liberado (L)
    $_SESSION['usuario_previlegio'] = $usuario['previlegio'];
    return ['sucesso' => true, 'redirecionar' => BASE_URL . '/dashboard'];
}

    public function logout(): void
    {
        session_destroy();
    }

    public function checarAprovacao(int $id): bool
    {
        return $this->repo->getStatus($id) === 'L';
    }
}
