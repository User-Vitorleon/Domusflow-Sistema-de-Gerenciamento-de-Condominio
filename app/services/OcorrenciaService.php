<?php
<<<<<<< HEAD

=======
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
require_once __DIR__ . '/../repositories/OcorrenciaRepository.php';

class OcorrenciaService
{
    private OcorrenciaRepository $repo;

    public function __construct()
    {
        $this->repo = new OcorrenciaRepository();
    }

<<<<<<< HEAD
    // ── Abrir ocorrência ─────────────────────────────────────────────────────
    public function abrir(array $post, int $id_user): array
=======
    public function abrir(array $post, int $idUser): array
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    {
        $titulo    = trim($post['titulo']    ?? '');
        $descricao = trim($post['descricao'] ?? '');
        $categoria = trim($post['categoria'] ?? '');

        if (!$titulo || !$descricao || !$categoria) {
            return ['sucesso' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
        }

        $id = $this->repo->criar([
<<<<<<< HEAD
            'id_user'   => $id_user,
=======
            'id_user'   => $idUser,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            'titulo'    => $titulo,
            'descricao' => $descricao,
            'categoria' => $categoria,
        ]);

<<<<<<< HEAD
        // Tramite inicial automático
        $this->repo->adicionarTramite([
            'id_ocorrencia' => $id,
            'id_user_cad'   => $id_user,
=======
        $this->repo->adicionarTramite([
            'id_ocorrencia' => $id,
            'id_user_cad'   => $idUser,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            'nome_user_cad' => $_SESSION['usuario_nome'] ?? 'Morador',
            'descricao'     => 'OCORRÊNCIA ABERTA PELO MORADOR.',
            'status_novo'   => 'A',
        ]);

        return ['sucesso' => true];
    }

<<<<<<< HEAD
    // ── Cancelar ocorrência (morador via rota /cancelar) ─────────────────────
    public function cancelar(int $id_ocorrencia, int $id_user): array
    {
        $ocorrencia = $this->repo->findById($id_ocorrencia);
=======
    public function cancelar(int $idOcorrencia, int $idUser): array
    {
        $ocorrencia = $this->repo->findById($idOcorrencia);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        if (!$ocorrencia) {
            return ['sucesso' => false, 'mensagem' => 'Ocorrência não encontrada.'];
        }
<<<<<<< HEAD
        if ((int)$ocorrencia['id_user'] !== $id_user) {
            return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para cancelar esta ocorrência.'];
        }
        // Morador só pode cancelar em status A (Aberto)
        if ($ocorrencia['status'] !== 'A') {
            return ['sucesso' => false, 'mensagem' => 'Esta ocorrência não pode ser cancelada no status atual.'];
        }

        $this->repo->atualizarStatus($id_ocorrencia, 'C');
        $this->repo->adicionarTramite([
            'id_ocorrencia' => $id_ocorrencia,
            'id_user_cad'   => $id_user,
=======
        if ((int)$ocorrencia['id_user'] !== $idUser) {
            return [
                'sucesso'  => false,
                'mensagem' => 'Você não tem permissão para cancelar esta ocorrência.',
            ];
        }
        if ($ocorrencia['status'] !== 'A') {
            return [
                'sucesso'  => false,
                'mensagem' => 'Esta ocorrência não pode ser cancelada no status atual.',
            ];
        }

        $this->repo->atualizarStatus($idOcorrencia, 'C');
        $this->repo->adicionarTramite([
            'id_ocorrencia' => $idOcorrencia,
            'id_user_cad'   => $idUser,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            'nome_user_cad' => $_SESSION['usuario_nome'] ?? 'Morador',
            'descricao'     => 'OCORRÊNCIA CANCELADA PELO MORADOR.',
            'status_novo'   => 'C',
        ]);

        return ['sucesso' => true];
    }

<<<<<<< HEAD
    public function tramitarMorador(int $id_ocorrencia, string $descricao, string $acao, int $id_user): array
    {
        $ocorrencia = $this->repo->findById($id_ocorrencia);
=======
    public function tramitarMorador(int $idOcorrencia, string $descricao, string $acao, int $idUser): array
    {
        $ocorrencia = $this->repo->findById($idOcorrencia);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        if (!$ocorrencia) {
            return ['sucesso' => false, 'mensagem' => 'Ocorrência não encontrada.'];
        }
<<<<<<< HEAD
        if ((int)$ocorrencia['id_user'] !== $id_user) {
            return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para tramitar esta ocorrência.'];
=======
        if ((int)$ocorrencia['id_user'] !== $idUser) {
            return [
                'sucesso'  => false,
                'mensagem' => 'Você não tem permissão para tramitar esta ocorrência.',
            ];
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        }

        $statusAtual = $ocorrencia['status'];

        if ($statusAtual === 'R' || $statusAtual === 'C') {
<<<<<<< HEAD
            return ['sucesso' => false, 'mensagem' => 'Não é possível tramitar uma ocorrência ' . ($statusAtual === 'R' ? 'resolvida' : 'cancelada') . '.'];
        }
        if ($acao === 'cancelar' && $statusAtual !== 'A') {
            return ['sucesso' => false, 'mensagem' => 'Só é possível cancelar ocorrências em status Aberto.'];
        }

        $status_novo = $statusAtual;
        if ($acao === 'cancelar') {
            $status_novo = 'C';
            $this->repo->atualizarStatus($id_ocorrencia, $status_novo);
        }

        $this->repo->adicionarTramite([
            'id_ocorrencia' => $id_ocorrencia,
            'id_user_cad'   => $id_user,
            'nome_user_cad' => $_SESSION['usuario_nome'] ?? 'Morador',
            'descricao'     => strtoupper($descricao),
            'status_novo'   => $status_novo,
=======
            $rotulo = $statusAtual === 'R' ? 'resolvida' : 'cancelada';
            return [
                'sucesso'  => false,
                'mensagem' => "Não é possível tramitar uma ocorrência {$rotulo}.",
            ];
        }
        if ($acao === 'cancelar' && $statusAtual !== 'A') {
            return [
                'sucesso'  => false,
                'mensagem' => 'Só é possível cancelar ocorrências em status Aberto.',
            ];
        }

        $statusNovo = $statusAtual;
        if ($acao === 'cancelar') {
            $statusNovo = 'C';
            $this->repo->atualizarStatus($idOcorrencia, $statusNovo);
        }

        $this->repo->adicionarTramite([
            'id_ocorrencia' => $idOcorrencia,
            'id_user_cad'   => $idUser,
            'nome_user_cad' => $_SESSION['usuario_nome'] ?? 'Morador',
            'descricao'     => strtoupper($descricao),
            'status_novo'   => $statusNovo,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        ]);

        return ['sucesso' => true];
    }

<<<<<<< HEAD
    public function tramitar(array $post, int $id_user_cad): array
    {
        $id_ocorrencia = (int)($post['id_ocorrencia'] ?? 0);
        $descricao     = trim($post['descricao'] ?? '');
        $status_novo   = trim($post['status_novo'] ?? '');

        if (!$id_ocorrencia || !$descricao || !$status_novo) {
            return ['sucesso' => false, 'mensagem' => 'Preencha todos os campos.'];
        }

        $ocorrencia = $this->repo->findById($id_ocorrencia);
=======
    public function tramitar(array $post, int $idUserCad): array
    {
        $idOcorrencia = (int)($post['id_ocorrencia'] ?? 0);
        $descricao    = trim($post['descricao']    ?? '');
        $statusNovo   = trim($post['status_novo']  ?? '');

        if (!$idOcorrencia || !$descricao || !$statusNovo) {
            return ['sucesso' => false, 'mensagem' => 'Preencha todos os campos.'];
        }

        $ocorrencia = $this->repo->findById($idOcorrencia);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        if (!$ocorrencia) {
            return ['sucesso' => false, 'mensagem' => 'Ocorrência não encontrada.'];
        }

        $statusAtual = $ocorrencia['status'];

        if ($statusAtual === 'C') {
<<<<<<< HEAD
            return ['sucesso' => false, 'mensagem' => 'Ocorrência cancelada não permite novas tramitações.'];
        }
        if ($statusAtual === 'R' && $status_novo !== 'R') {
            return ['sucesso' => false, 'mensagem' => 'Ocorrência resolvida não permite alteração de status.'];
        }

        $permitidos = match ($statusAtual) {
            'A' => ['A', 'E', 'R', 'C'],
            'E' => ['E', 'R', 'C'],
            'R' => ['R'],
            default => []
        };

        if (!in_array($status_novo, $permitidos, true)) {
            return ['sucesso' => false, 'mensagem' => 'Transição de status não permitida.'];
        }

        $this->repo->atualizarStatus($id_ocorrencia, $status_novo);
        $this->repo->adicionarTramite([
            'id_ocorrencia' => $id_ocorrencia,
            'id_user_cad'   => $id_user_cad,
            'nome_user_cad' => $_SESSION['usuario_nome'] ?? 'Síndico',
            'descricao'     => strtoupper($descricao),
            'status_novo'   => $status_novo,
        ]);

        $this->repo->criarNotificacao((int)$ocorrencia['id_user'], $id_ocorrencia);
=======
            return [
                'sucesso'  => false,
                'mensagem' => 'Ocorrência cancelada não permite novas tramitações.',
            ];
        }
        if ($statusAtual === 'R' && $statusNovo !== 'R') {
            return [
                'sucesso'  => false,
                'mensagem' => 'Ocorrência resolvida não permite alteração de status.',
            ];
        }

        $permitidos = match ($statusAtual) {
            'A'     => ['A', 'E', 'R', 'C'],
            'E'     => ['E', 'R', 'C'],
            'R'     => ['R'],
            default => [],
        };

        if (!in_array($statusNovo, $permitidos, true)) {
            return ['sucesso' => false, 'mensagem' => 'Transição de status não permitida.'];
        }

        $this->repo->atualizarStatus($idOcorrencia, $statusNovo);
        $this->repo->adicionarTramite([
            'id_ocorrencia' => $idOcorrencia,
            'id_user_cad'   => $idUserCad,
            'nome_user_cad' => $_SESSION['usuario_nome'] ?? 'Síndico',
            'descricao'     => strtoupper($descricao),
            'status_novo'   => $statusNovo,
        ]);

        $this->repo->criarNotificacao((int)$ocorrencia['id_user'], $idOcorrencia);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)

        return ['sucesso' => true];
    }

<<<<<<< HEAD
    // ── Listagens ─────────────────────────────────────────────────────────────
    public function listarParaMorador(int $id_user): array
    {
        return $this->repo->listarPorUsuario($id_user);
=======
    public function listarParaMorador(int $idUser): array
    {
        return $this->repo->listarPorUsuario($idUser);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function listarParaPainel(array $filtros, int $limit = 15, int $offset = 0): array
    {
        return $this->repo->listarComFiltros($filtros, $limit, $offset);
    }

    public function contarParaPainel(array $filtros): int
    {
        return $this->repo->contarComFiltros($filtros);
    }

    public function buscarDetalhes(int $id, int $limit = 10, int $offset = 0): ?array
    {
        $ocorrencia = $this->repo->findById($id);
<<<<<<< HEAD
        if (!$ocorrencia) return null;

        $ocorrencia['tramites'] = $this->repo->listarTramites($id, $limit, $offset);
=======
        if (!$ocorrencia) {
            return null;
        }

        $ocorrencia['tramites']       = $this->repo->listarTramites($id, $limit, $offset);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $ocorrencia['total_tramites'] = $this->repo->contarTramites($id);

        return $ocorrencia;
    }

    public function contadores(): array
    {
        return $this->repo->contarPorStatus();
    }

<<<<<<< HEAD
    public function notificacoesNaoLidas(int $id_user): int
    {
        return $this->repo->contarNaoLidas($id_user);
    }

    public function marcarNotificacoesLidas(int $id_user): void
    {
        $this->repo->marcarTodasLidas($id_user);
=======
    public function notificacoesNaoLidas(int $idUser): int
    {
        return $this->repo->contarNaoLidas($idUser);
    }

    public function marcarNotificacoesLidas(int $idUser): void
    {
        $this->repo->marcarTodasLidas($idUser);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }

    public function listarMoradoresComOcorrencias(): array
    {
        return $this->repo->listarMoradoresComOcorrencias();
    }
}
