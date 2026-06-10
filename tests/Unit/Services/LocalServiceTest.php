<?php

namespace Tests\Unit\Services;

use LocalService;
use PHPUnit\Framework\TestCase;
use Tests\Support\FakeLocalRepository;
use Tests\Support\FakeMoradorRepository;

final class LocalServiceTest extends TestCase
{
    private FakeLocalRepository $localRepo;
    private FakeMoradorRepository $moradorRepo;
    private LocalService $service;

    protected function setUp(): void
    {
        $this->localRepo = new FakeLocalRepository();
        $this->moradorRepo = new FakeMoradorRepository();
        $this->moradorRepo->moradores[2] = ['id_user' => 2, 'privilegio' => 2];
        $this->service = new LocalService($this->localRepo, $this->moradorRepo);
    }

    public function testCadastrarBloqueiaUsuarioSemPermissao(): void
    {
        $this->moradorRepo->moradores[5] = ['id_user' => 5, 'privilegio' => 1];

        $resultado = $this->service->cadastrar(['nome_local' => 'Salao', 'capacidade' => 30], 5);

        $this->assertFalse($resultado['sucesso']);
        $this->assertSame('Sem permissao.', $resultado['mensagem']);
        $this->assertNull($this->localRepo->dadosSalvos);
    }

    public function testCadastrarValidaNomeObrigatorio(): void
    {
        $resultado = $this->service->cadastrar(['nome_local' => ' ', 'capacidade' => 30], 2);

        $this->assertFalse($resultado['sucesso']);
        $this->assertSame('Informe o nome do local.', $resultado['mensagem']);
    }

    public function testCadastrarValidaCapacidadeMaiorQueZero(): void
    {
        $resultado = $this->service->cadastrar(['nome_local' => 'Salao', 'capacidade' => 0], 2);

        $this->assertFalse($resultado['sucesso']);
        $this->assertSame('Capacidade deve ser maior que zero.', $resultado['mensagem']);
    }

    public function testCadastrarValidaStatusPermitido(): void
    {
        $resultado = $this->service->cadastrar([
            'nome_local' => 'Salao',
            'capacidade' => 30,
            'disponivel' => 'talvez',
        ], 2);

        $this->assertFalse($resultado['sucesso']);
        $this->assertSame('Status do local invalido.', $resultado['mensagem']);
    }

    public function testCadastrarSalvaDadosNormalizados(): void
    {
        $resultado = $this->service->cadastrar([
            'nome_local' => '  Salao de Festas  ',
            'capacidade' => '80',
            'disponivel' => 'n',
        ], 2);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame([
            'local' => 'Salao de Festas',
            'capacidade' => 80,
            'disp_uso' => 'N',
            'id_user_cad' => 2,
        ], $this->localRepo->dadosSalvos);
    }

    public function testAtualizarExigeLocalExistente(): void
    {
        $resultado = $this->service->atualizar(['id_local' => 99, 'nome_local' => 'Piscina', 'capacidade' => 20], 2);

        $this->assertFalse($resultado['sucesso']);
        $this->assertSame('Local nao encontrado.', $resultado['mensagem']);
    }

    public function testAtualizarPersisteDadosValidados(): void
    {
        $this->localRepo->locais[9] = ['id_local' => 9, 'local' => 'Antigo'];

        $resultado = $this->service->atualizar([
            'id_local' => 9,
            'nome_local' => 'Churrasqueira',
            'capacidade' => '25',
            'disponivel' => 'S',
        ], 2);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame(9, $this->localRepo->idAtualizado);
        $this->assertSame([
            'local' => 'Churrasqueira',
            'capacidade' => 25,
            'disp_uso' => 'S',
        ], $this->localRepo->dadosAtualizados);
    }

    public function testAtualizarPropagaErroDoRepositorio(): void
    {
        $this->localRepo->locais[9] = ['id_local' => 9];
        $this->localRepo->updateResultado = false;

        $resultado = $this->service->atualizar([
            'id_local' => 9,
            'nome_local' => 'Piscina',
            'capacidade' => 12,
        ], 2);

        $this->assertFalse($resultado['sucesso']);
        $this->assertSame('Erro ao atualizar local.', $resultado['mensagem']);
    }
}
