<?php
require_once __DIR__ . '/../repositories/VeiculoRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class VeiculoService
{
    private const LIMITE_VEICULOS_MORADOR = 2;
    private const TAMANHO_MINIMO_PLACA    = 7;

    private VeiculoRepository $repo;
    private MoradorRepository $moradorRepo;

    public function __construct(?VeiculoRepository $repo = null, ?MoradorRepository $moradorRepo = null)
    {
        $this->repo        = $repo ?? new VeiculoRepository();
        $this->moradorRepo = $moradorRepo ?? new MoradorRepository();
    }

    public function cadastrar(array $dados, int $idUserCad, int $prevCad): array
    {
        $placa = $this->normalizarPlaca($dados['placa']);
        if (strlen($placa) < self::TAMANHO_MINIMO_PLACA) {
            return [
                'sucesso'  => false,
                'mensagem' => 'Placa inválida. Informe 7 caracteres (ex: ABC1234).',
            ];
        }

        if ($this->repo->existePlaca($placa)) {
            return ['sucesso' => false, 'mensagem' => 'Esta placa já está cadastrada.'];
        }

        $idDono      = (int)$dados['id_user'];
        $dono        = $this->moradorRepo->findById($idDono);

        if (($dono['privilegio'] ?? 1) == 1) {
            $total = $this->repo->countByUser($idDono);
            if ($total >= self::LIMITE_VEICULOS_MORADOR) {
                return [
                    'sucesso'  => false,
                    'mensagem' => 'Limite de ' . self::LIMITE_VEICULOS_MORADOR . ' veículos por morador atingido.',
                ];
            }
        }

        $marca  = ucwords(strtolower(trim($dados['marca'])));
        $modelo = ucwords(strtolower(trim($dados['modelo'])));

        $principal = !empty($dados['principal']) ? 1 : 0;
        if ($principal) {
            $this->repo->desmarcarPrincipal($idDono);
        }

        $id = $this->repo->save([
            'placa'       => $placa,
            'marca'       => $marca,
            'modelo'      => $modelo,
            'cor'         => $dados['cor'],
            'principal'   => $principal,
            'id_user'     => $idDono,
            'id_user_cad' => $idUserCad,
        ]);

        if ($id) {
            return ['sucesso' => true];
        }

        return ['sucesso' => false, 'mensagem' => 'Erro ao salvar o veículo. Tente novamente.'];
    }

    public function listarTodos(): array
    {
        return $this->repo->findAll();
    }

    public function listarPorUsuario(int $idUser): array
    {
        return $this->repo->findByUsuario($idUser);
    }

    public function consultarPorPlaca(string $placa): array
    {
        $placa   = $this->normalizarPlaca($placa);
        $veiculo = $this->repo->findByPlaca($placa);

        if (!$veiculo) {
            return ['sucesso' => false, 'mensagem' => 'Nenhum veículo encontrado com essa placa.'];
        }

        return ['sucesso' => true, 'veiculo' => $veiculo];
    }

    public function editar(int $id, array $dados, int $privilegio): array
    {
        if (!in_array($privilegio, [2, 3, 4])) {
            return [
                'sucesso'  => false,
                'mensagem' => 'Você não tem permissão para editar veículos.',
            ];
        }

        $placa = $this->normalizarPlaca($dados['placa']);
        if (strlen($placa) < self::TAMANHO_MINIMO_PLACA) {
            return ['sucesso' => false, 'mensagem' => 'Placa inválida.'];
        }

        $this->repo->update($id, [
            'placa'  => $placa,
            'marca'  => ucwords(strtolower(trim($dados['marca']))),
            'modelo' => ucwords(strtolower(trim($dados['modelo']))),
            'cor'    => $dados['cor'],
        ]);

        return ['sucesso' => true];
    }

    public function definirPrincipal(int $idVeiculo, int $idUser): array
    {
        $this->repo->desmarcarPrincipal($idUser);
        $this->repo->marcarPrincipal($idVeiculo);
        return ['sucesso' => true];
    }

    public function excluir(int $id, int $privilegio, int $idUserLogado): array
    {
        if (in_array($privilegio, [2, 4])) {
            $this->repo->delete($id);
            return ['sucesso' => true];
        }

        if ($privilegio === 1) {
            $veiculo = $this->repo->findById($id);
            if (!$veiculo) {
                return ['sucesso' => false, 'mensagem' => 'Veículo não encontrado.'];
            }
            if ((int)$veiculo['id_user'] !== $idUserLogado) {
                return [
                    'sucesso'  => false,
                    'mensagem' => 'Você não tem permissão para excluir este veículo.',
                ];
            }
            $this->repo->delete($id);
            return ['sucesso' => true];
        }

        return [
            'sucesso'  => false,
            'mensagem' => 'Você não tem permissão para excluir veículos.',
        ];
    }

    private function normalizarPlaca(string $placa): string
    {
        return strtoupper(preg_replace('/[^A-Z0-9]/i', '', $placa));
    }
}
