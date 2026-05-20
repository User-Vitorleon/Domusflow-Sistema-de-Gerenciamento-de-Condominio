<?php
require_once __DIR__ . '/../repositories/OcorrenciaRepository.php';

class OcorrenciaService
{
    private OcorrenciaRepository $repo;

    public function __construct()
    {
        $this->repo = new OcorrenciaRepository();
    }

    public function abrir(array $post, int $idUser): array
    {
        $titulo    = trim($post['titulo']    ?? '');
        $descricao = trim($post['descricao'] ?? '');
        $categoria = trim($post['categoria'] ?? '');

        if (!$titulo || !$descricao || !$categoria) {
            return ['sucesso' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
        }

        $id = $this->repo->criar([
            'id_user'   => $idUser,
            'titulo'    => $titulo,
            'descricao' => $descricao,
            'categoria' => $categoria,
        ]);

        $this->repo->adicionarTramite([
            'id_ocorrencia' => $id,
            'id_user_cad'   => $idUser,
            'nome_user_cad' => $_SESSION['usuario_nome'] ?? 'Morador',
            'descricao'     => 'OCORRÊNCIA ABERTA PELO MORADOR.',
            'status_novo'   => 'A',
        ]);

        return ['sucesso' => true];
    }

    public function cancelar(int $idOcorrencia, int $idUser): array
    {
        $ocorrencia = $this->repo->findById($idOcorrencia);

        if (!$ocorrencia) {
            return ['sucesso' => false, 'mensagem' => 'Ocorrência não encontrada.'];
        }
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
            'nome_user_cad' => $_SESSION['usuario_nome'] ?? 'Morador',
            'descricao'     => 'OCORRÊNCIA CANCELADA PELO MORADOR.',
            'status_novo'   => 'C',
        ]);

        return ['sucesso' => true];
    }

    public function tramitarMorador(int $idOcorrencia, string $descricao, string $acao, int $idUser): array
    {
        $ocorrencia = $this->repo->findById($idOcorrencia);

        if (!$ocorrencia) {
            return ['sucesso' => false, 'mensagem' => 'Ocorrência não encontrada.'];
        }
        if ((int)$ocorrencia['id_user'] !== $idUser) {
            return [
                'sucesso'  => false,
                'mensagem' => 'Você não tem permissão para tramitar esta ocorrência.',
            ];
        }

        $statusAtual = $ocorrencia['status'];

        if ($statusAtual === 'R' || $statusAtual === 'C') {
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
        ]);

        return ['sucesso' => true];
    }

    public function tramitar(array $post, int $idUserCad): array
    {
        $idOcorrencia = (int)($post['id_ocorrencia'] ?? 0);
        $descricao    = trim($post['descricao']    ?? '');
        $statusNovo   = trim($post['status_novo']  ?? '');

        if (!$idOcorrencia || !$descricao || !$statusNovo) {
            return ['sucesso' => false, 'mensagem' => 'Preencha todos os campos.'];
        }

        $ocorrencia = $this->repo->findById($idOcorrencia);
        if (!$ocorrencia) {
            return ['sucesso' => false, 'mensagem' => 'Ocorrência não encontrada.'];
        }

        $statusAtual = $ocorrencia['status'];

        if ($statusAtual === 'C') {
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

        return ['sucesso' => true];
    }

    public function listarParaMorador(int $idUser): array
    {
        return $this->repo->listarPorUsuario($idUser);
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
        if (!$ocorrencia) {
            return null;
        }

        $ocorrencia['tramites']       = $this->repo->listarTramites($id, $limit, $offset);
        $ocorrencia['total_tramites'] = $this->repo->contarTramites($id);

        return $ocorrencia;
    }

    public function contadores(): array
    {
        return $this->repo->contarPorStatus();
    }

    public function notificacoesNaoLidas(int $idUser): int
    {
        return $this->repo->contarNaoLidas($idUser);
    }

    public function marcarNotificacoesLidas(int $idUser): void
    {
        $this->repo->marcarTodasLidas($idUser);
    }

    public function listarMoradoresComOcorrencias(): array
    {
        return $this->repo->listarMoradoresComOcorrencias();
    }
}
