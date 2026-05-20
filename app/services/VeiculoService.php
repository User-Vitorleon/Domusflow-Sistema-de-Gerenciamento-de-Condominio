<?php
<<<<<<< HEAD

=======
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
require_once __DIR__ . '/../repositories/VeiculoRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class VeiculoService
{
<<<<<<< HEAD
    private VeiculoRepository $repo;

    public function __construct()
    {
        $this->repo = new VeiculoRepository();
    }

    // Cadastrar veículo
    public function cadastrar(array $dados, int $id_user_cad, int $prev_cad): array
    {
        // Sanitiza placa: maiúsculo, só letras e números, máx 7
        $placa = strtoupper(preg_replace('/[^A-Z0-9]/i', '', $dados['placa']));
        if (strlen($placa) < 7) {
            return ['sucesso' => false, 'mensagem' => 'Placa inválida. Informe 7 caracteres (ex: ABC1234).'];
        }

        // Evita placa duplicada
=======
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

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        if ($this->repo->existePlaca($placa)) {
            return ['sucesso' => false, 'mensagem' => 'Esta placa já está cadastrada.'];
        }

<<<<<<< HEAD
        $id_dono = (int)$dados['id_user'];

        // Morador (prev 1) só pode ter até 2 veículos
        $moradorRepo = new MoradorRepository();
        $dono        = $moradorRepo->findById($id_dono);
        if (($dono['privilegio'] ?? 1) == 1) {
            $total = $this->repo->countByUser($id_dono);
            if ($total >= 2) {
                return ['sucesso' => false, 'mensagem' => 'Limite de 2 veículos por morador atingido.'];
            }
        }

        // Formata marca e modelo: primeira letra maiúscula
        $marca  = ucwords(strtolower(trim($dados['marca'])));
        $modelo = ucwords(strtolower(trim($dados['modelo'])));

        // Trata campo principal
        $principal = !empty($dados['principal']) ? 1 : 0;
        if ($principal) {
            $this->repo->desmarcarPrincipal($id_dono);
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        }

        $id = $this->repo->save([
            'placa'       => $placa,
            'marca'       => $marca,
            'modelo'      => $modelo,
            'cor'         => $dados['cor'],
            'principal'   => $principal,
<<<<<<< HEAD
            'id_user'     => $id_dono,
            'id_user_cad' => $id_user_cad,
=======
            'id_user'     => $idDono,
            'id_user_cad' => $idUserCad,
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        ]);

        if ($id) {
            return ['sucesso' => true];
        }

        return ['sucesso' => false, 'mensagem' => 'Erro ao salvar o veículo. Tente novamente.'];
    }

<<<<<<< HEAD
    // Lista todos os veículos
=======
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    public function listarTodos(): array
    {
        return $this->repo->findAll();
    }

<<<<<<< HEAD
    // Lista os veículos de um morador
    public function listarPorUsuario(int $id_user): array
    {
        return $this->repo->findByUsuario($id_user);
    }

    // Consulta rápida por placa
    public function consultarPorPlaca(string $placa): array
    {
        $placa   = strtoupper(preg_replace('/[^A-Z0-9]/i', '', $placa));
=======
    public function listarPorUsuario(int $idUser): array
    {
        return $this->repo->findByUsuario($idUser);
    }

    public function consultarPorPlaca(string $placa): array
    {
        $placa   = $this->normalizarPlaca($placa);
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $veiculo = $this->repo->findByPlaca($placa);

        if (!$veiculo) {
            return ['sucesso' => false, 'mensagem' => 'Nenhum veículo encontrado com essa placa.'];
        }

        return ['sucesso' => true, 'veiculo' => $veiculo];
    }

<<<<<<< HEAD
    // Edita um veículo
    public function editar(int $id, array $dados, int $privilegio): array
    {
        if (!in_array($privilegio, [2, 3, 4])) {
            return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para editar veículos.'];
        }

        $placa = strtoupper(preg_replace('/[^A-Z0-9]/i', '', $dados['placa']));
        if (strlen($placa) < 7) {
=======
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
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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

<<<<<<< HEAD
    // Define veículo principal
    public function definirPrincipal(int $id_veiculo, int $id_user): array
    {
        $this->repo->desmarcarPrincipal($id_user);
        $this->repo->marcarPrincipal($id_veiculo);
        return ['sucesso' => true];
    }

    // Exclui um veículo
    public function excluir(int $id, int $privilegio, int $id_user_logado): array
    {
        // Síndico/admin excluem qualquer um
=======
    public function definirPrincipal(int $idVeiculo, int $idUser): array
    {
        $this->repo->desmarcarPrincipal($idUser);
        $this->repo->marcarPrincipal($idVeiculo);
        return ['sucesso' => true];
    }

    public function excluir(int $id, int $privilegio, int $idUserLogado): array
    {
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        if (in_array($privilegio, [2, 4])) {
            $this->repo->delete($id);
            return ['sucesso' => true];
        }

<<<<<<< HEAD
        // Morador só pode excluir o próprio veículo
        if ($privilegio == 1) {
=======
        if ($privilegio === 1) {
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            $veiculo = $this->repo->findById($id);
            if (!$veiculo) {
                return ['sucesso' => false, 'mensagem' => 'Veículo não encontrado.'];
            }
<<<<<<< HEAD
            if ((int)$veiculo['id_user'] !== $id_user_logado) {
                return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para excluir este veículo.'];
=======
            if ((int)$veiculo['id_user'] !== $idUserLogado) {
                return [
                    'sucesso'  => false,
                    'mensagem' => 'Você não tem permissão para excluir este veículo.',
                ];
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            }
            $this->repo->delete($id);
            return ['sucesso' => true];
        }

<<<<<<< HEAD
        return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para excluir veículos.'];
=======
        return [
            'sucesso'  => false,
            'mensagem' => 'Você não tem permissão para excluir veículos.',
        ];
    }

    private function normalizarPlaca(string $placa): string
    {
        return strtoupper(preg_replace('/[^A-Z0-9]/i', '', $placa));
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
    }
}
