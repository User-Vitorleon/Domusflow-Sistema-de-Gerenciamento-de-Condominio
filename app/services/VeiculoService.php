<?php

require_once __DIR__ . '/../repositories/VeiculoRepository.php';
require_once __DIR__ . '/../repositories/MoradorRepository.php';

class VeiculoService
{
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
        if ($this->repo->existePlaca($placa)) {
            return ['sucesso' => false, 'mensagem' => 'Esta placa já está cadastrada.'];
        }

        $id_dono = (int)$dados['id_user'];

        // Morador (prev 1) só pode ter até 2 veículos
        $moradorRepo = new MoradorRepository();
        $dono        = $moradorRepo->findById($id_dono);
        if (($dono['previlegio'] ?? 1) == 1) {
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
        }

        $id = $this->repo->save([
            'placa'       => $placa,
            'marca'       => $marca,
            'modelo'      => $modelo,
            'cor'         => $dados['cor'],
            'principal'   => $principal,
            'id_user'     => $id_dono,
            'id_user_cad' => $id_user_cad,
        ]);

        if ($id) {
            return ['sucesso' => true];
        }

        return ['sucesso' => false, 'mensagem' => 'Erro ao salvar o veículo. Tente novamente.'];
    }

    // Lista todos os veículos
    public function listarTodos(): array
    {
        return $this->repo->findAll();
    }

    // Lista os veículos de um morador
    public function listarPorUsuario(int $id_user): array
    {
        return $this->repo->findByUsuario($id_user);
    }

    // Consulta rápida por placa
    public function consultarPorPlaca(string $placa): array
    {
        $placa   = strtoupper(preg_replace('/[^A-Z0-9]/i', '', $placa));
        $veiculo = $this->repo->findByPlaca($placa);

        if (!$veiculo) {
            return ['sucesso' => false, 'mensagem' => 'Nenhum veículo encontrado com essa placa.'];
        }

        return ['sucesso' => true, 'veiculo' => $veiculo];
    }

    // Edita um veículo
    public function editar(int $id, array $dados, int $previlegio): array
    {
        if (!in_array($previlegio, [2, 3, 4])) {
            return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para editar veículos.'];
        }

        $placa = strtoupper(preg_replace('/[^A-Z0-9]/i', '', $dados['placa']));
        if (strlen($placa) < 7) {
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

    // Define veículo principal
    public function definirPrincipal(int $id_veiculo, int $id_user): array
    {
        $this->repo->desmarcarPrincipal($id_user);
        $this->repo->marcarPrincipal($id_veiculo);
        return ['sucesso' => true];
    }

    // Exclui um veículo
    public function excluir(int $id, int $previlegio, int $id_user_logado): array
    {
        // Síndico/admin excluem qualquer um
        if (in_array($previlegio, [2, 4])) {
            $this->repo->delete($id);
            return ['sucesso' => true];
        }

        // Morador só pode excluir o próprio veículo
        if ($previlegio == 1) {
            $veiculo = $this->repo->findById($id);
            if (!$veiculo) {
                return ['sucesso' => false, 'mensagem' => 'Veículo não encontrado.'];
            }
            if ((int)$veiculo['id_user'] !== $id_user_logado) {
                return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para excluir este veículo.'];
            }
            $this->repo->delete($id);
            return ['sucesso' => true];
        }

        return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para excluir veículos.'];
    }
}
