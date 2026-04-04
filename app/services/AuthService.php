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
        $cpf     = preg_replace('/[^0-9]/', '', $cpf); // remove pontos e traço
        $usuario = $this->repo->findByCpf($cpf);

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            return ['sucesso' => false, 'mensagem' => 'CPF ou senha incorretos.'];
        }

        if ($usuario['status'] === 'P') {
            $_SESSION['usuario_id']   = $usuario['id_user'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            header('Location: ' . BASE_URL . '/pendente');
            exit();
        }

        if ($usuario['status'] === 'B') {
            return ['sucesso' => false, 'mensagem' => 'Acesso bloqueado. Entre em contato com o síndico.'];
        }

        $_SESSION['usuario_id']         = $usuario['id_user'];
        $_SESSION['usuario_nome']        = $usuario['nome'];
        $_SESSION['usuario_previlegio']  = $usuario['previlegio'];

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
