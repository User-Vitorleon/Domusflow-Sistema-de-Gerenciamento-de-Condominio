<?php

require_once __DIR__ . '/../repositories/VeiculoRepository.php';

class VeiculoService
{
    private VeiculoRepository $repo;

    public function __construct()
    {
        $this->repo = new VeiculoRepository();
    }

    // Cadastrar veículo :
    public function cadastrar(array $dados, int $id_user_cad): array
    {
        // Evita placa duplicada !!! 
        if ($this->repo->existePlaca($dados['placa'])) {
            return ['sucesso' => false, 'mensagem' => 'Esta placa já está cadastrada.'];
        }

        $id = $this->repo->save([
            'placa'       => $dados['placa'],
            'marca'       => $dados['marca'],
            'modelo'      => $dados['modelo'],
            'cor'         => $dados['cor'],
            'id_user'     => (int)$dados['id_user'], // dono do veículo
            'id_user_cad' => $id_user_cad,           // usuário que cadastrou
        ]);

        if ($id) {
            return ['sucesso' => true];
        }

        return ['sucesso' => false, 'mensagem' => 'Erro ao salvar o veículo. Tente novamente.'];
    }

    // lista todos os veículos
    public function listarTodos(): array
    {
        return $this->repo->findAll();
    }

    // lista os veículos de um morador
    public function listarPorUsuario(int $id_user): array
    {
        return $this->repo->findByUsuario($id_user);
    }

    // consulta rápida por placa
    public function consultarPorPlaca(string $placa): array
    {
        $veiculo = $this->repo->findByPlaca($placa);

        if (!$veiculo) {
            return ['sucesso' => false, 'mensagem' => 'Nenhum veículo encontrado com essa placa.'];
        }

        return ['sucesso' => true, 'veiculo' => $veiculo];
    }

    // edita um veículo
    public function editar(int $id, array $dados, int $previlegio): array
    {
        // só síndico, porteiro e admin podem editar
        if (!in_array($previlegio, [2, 3, 4])) {
            return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para editar veículos.'];
        }

        $this->repo->update($id, [
            'placa'  => $dados['placa'],
            'marca'  => $dados['marca'],
            'modelo' => $dados['modelo'],
            'cor'    => $dados['cor'],
        ]);

        return ['sucesso' => true];
    }

    // Exclui um veículo
    public function excluir(int $id, int $previlegio): array
    {
        // Só síndico, porteiro e admin podem excluir
        if (!in_array($previlegio, [2, 3, 4])) {
            return ['sucesso' => false, 'mensagem' => 'Você não tem permissão para excluir veículos.'];
        }

        $this->repo->delete($id);

        return ['sucesso' => true];
    }
}
