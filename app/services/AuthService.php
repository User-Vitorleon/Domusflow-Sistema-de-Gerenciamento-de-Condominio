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
<<<<<<< HEAD
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $usuario = $this->repo->findByCpf($cpf);


        if (!$usuario) {
            return ['sucesso' => false, 'mensagem' => 'CPF ou senha incorretos.'];
        }

        // 2. conta bloqueada ou deletada?
        if ($usuario['status'] === 'B' || $usuario['status'] === 'E') {
            return ['sucesso' => false, 'mensagem' => 'Esta conta não pode ser acessada. Entre em contato com o síndico.'];
        }

        // 3. valida a senha
        if (!password_verify($senha, $usuario['senha'])) {
            return ['sucesso' => false, 'mensagem' => 'CPF ou senha incorretos.'];
        }

        // só agora salva na sessão
        $_SESSION['usuario_id']   = $usuario['id_user'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

        // Se estiver pendente, avisamos o Controller para mandar para /pendente
=======
        $cpf     = $this->somenteDigitos($cpf);
        $usuario = $this->repo->findByCpf($cpf);

        if (!$usuario) {
            return $this->credenciaisInvalidas();
        }

        if ($this->contaInacessivel($usuario['status'])) {
            return [
                'sucesso'  => false,
                'mensagem' => 'Esta conta não pode ser acessada. Entre em contato com o síndico.',
            ];
        }

        if (!password_verify($senha, $usuario['senha'])) {
            return $this->credenciaisInvalidas();
        }

        $_SESSION['usuario_id']   = $usuario['id_user'];
        $_SESSION['usuario_nome'] = $usuario['nome'];

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        if ($usuario['status'] === 'P') {
            return ['sucesso' => true, 'redirecionar' => BASE_URL . '/pendente'];
        }

<<<<<<< HEAD
        // Se chegou aqui, está Liberado (L)
=======
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $_SESSION['usuario_privilegio'] = $usuario['privilegio'];
        return ['sucesso' => true, 'redirecionar' => BASE_URL . '/painel'];
    }

    public function logout(): void
    {
        session_destroy();
    }

    public function checarAprovacao(int $id): bool
    {
        return $this->repo->getStatus($id) === 'L';
    }
<<<<<<< HEAD
=======

    private function somenteDigitos(string $valor): string
    {
        return preg_replace('/[^0-9]/', '', $valor);
    }

    private function contaInacessivel(string $status): bool
    {
        return $status === 'B' || $status === 'E';
    }

    private function credenciaisInvalidas(): array
    {
        return ['sucesso' => false, 'mensagem' => 'CPF ou senha incorretos.'];
    }
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
}
