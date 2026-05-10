<?php

require_once __DIR__ . '/../repositories/OcorrenciaRepository.php';

class OcorrenciaService
{
    private OcorrenciaRepository $repo;

    public function __construct()
    {
        $this->repo = new OcorrenciaRepository();
    }

    // ── Abrir ocorrência ─────────────────────────────────────────────────────
    public function abrir(array $post, int $id_user): array
    {
        $titulo    = trim($post['titulo']    ?? '');
        $descricao = trim($post['descricao'] ?? '');
        $categoria = trim($post['categoria'] ?? '');

        if (!$titulo || !$descricao || !$categoria) {
            return ['sucesso' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
        }

        $id = $this->repo->criar([
            'id_user'   => $id_user,
            'titulo'    => $titulo,
            'descricao' => $descricao,
            'categoria' => $categoria,
        ]);

        // Tramite inicial automático
        $this->repo->adicionarTramite([
            'id_ocorrencia' => $id,
            'id_user_cad'   => $id_user,
            'nome_user_cad' => $_SESSION['usuario_nome'] ?? 'Morador',
            'descricao'     => 'OCORRÊNCIA ABERTA PELO MORADOR.',
            'status_novo'   => 'A',
        ]);

        return ['sucesso' => true];
    }

    // ── Cancelar ocorrência (morador via rota /cancelar) ─────────────────────
    public function cancelar(int $id_ocorrencia, int $id_user): array
    {
        $ocorrencia = $this->repo->findById($id_ocorrencia);

        if (!$ocorrencia) {
            return ['sucesso' => false, 'mensagem' => 'Ocorrência não encontrada.'];
        }
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
            'nome_user_cad' => $_SESSION['usuario_nome'] ?? 'Morador',
            'descricao'     => 'OCORRÊNCIA CANCELADA PELO MORADOR.',
            'status_novo'   => 'C',
        ]);

        return ['sucesso' => true];
    }

    public function tramitarMorador(int $id_ocorrencia, string $descricao, string $acao, int $id_user): array
    {
        $ocorrencia = $this->repo->findById($id_ocorrencia);

        if (!$ocorrencia) {
            return ['sucesso' => false, 'mensagem' => 'Ocorrência não encontrada.'];
        }
        if ((int)$ocorrencia['id_user'] !== $id_user) {
            return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para tramitar esta ocorrência.'];
        }

        $statusAtual = $ocorrencia['status'];

        if ($statusAtual === 'R' || $statusAtual === 'C') {
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
        ]);

        return ['sucesso' => true];
    }

    public function tramitar(array $post, int $id_user_cad): array
    {
        $id_ocorrencia = (int)($post['id_ocorrencia'] ?? 0);
        $descricao     = trim($post['descricao'] ?? '');
        $status_novo   = trim($post['status_novo'] ?? '');

        if (!$id_ocorrencia || !$descricao || !$status_novo) {
            return ['sucesso' => false, 'mensagem' => 'Preencha todos os campos.'];
        }

        $ocorrencia = $this->repo->findById($id_ocorrencia);
        if (!$ocorrencia) {
            return ['sucesso' => false, 'mensagem' => 'Ocorrência não encontrada.'];
        }

        $statusAtual = $ocorrencia['status'];

        if ($statusAtual === 'C') {
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

        return ['sucesso' => true];
    }

    // ── Listagens ─────────────────────────────────────────────────────────────
    public function listarParaMorador(int $id_user): array
    {
        return $this->repo->listarPorUsuario($id_user);
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
        if (!$ocorrencia) return null;

        $ocorrencia['tramites'] = $this->repo->listarTramites($id, $limit, $offset);
        $ocorrencia['total_tramites'] = $this->repo->contarTramites($id);

        return $ocorrencia;
    }

    public function contadores(): array
    {
        return $this->repo->contarPorStatus();
    }

    public function notificacoesNaoLidas(int $id_user): int
    {
        return $this->repo->contarNaoLidas($id_user);
    }

    public function marcarNotificacoesLidas(int $id_user): void
    {
        $this->repo->marcarTodasLidas($id_user);
    }

    public function listarMoradoresComOcorrencias(): array
    {
        return $this->repo->listarMoradoresComOcorrencias();
    }
}
