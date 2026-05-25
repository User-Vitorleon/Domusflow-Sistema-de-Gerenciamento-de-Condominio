<?php

namespace Tests\Unit;

use LocalRepository;
use LocalService;
use MoradorRepository;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../app/repositories/LocalRepository.php';
require_once __DIR__ . '/../../app/repositories/MoradorRepository.php';
require_once __DIR__ . '/../../app/services/LocalService.php';

final class LocalServiceTest extends TestCase
{
    public function testCadastrarSemPermissaoRetornaErro(): void
    {
        $moradores = new LocalServiceMoradorRepositoryFake();
        $moradores->usuarios[1] = ['privilegio' => 1];

        $resultado = (new LocalService(new LocalServiceLocalRepositoryFake(), $moradores))
            ->cadastrar(['nome_local' => 'Salao', 'capacidade' => 30, 'disponivel' => 'S'], 1);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('permiss', $resultado['mensagem']);
    }

    public function testCadastrarComNomeVazioRetornaErro(): void
    {
        $moradores = new LocalServiceMoradorRepositoryFake();
        $moradores->usuarios[2] = ['privilegio' => 2];

        $resultado = (new LocalService(new LocalServiceLocalRepositoryFake(), $moradores))
            ->cadastrar(['nome_local' => '   ', 'capacidade' => 30, 'disponivel' => 'S'], 2);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('nome', $resultado['mensagem']);
    }

    public function testCadastrarComCapacidadeZeroRetornaErro(): void
    {
        $moradores = new LocalServiceMoradorRepositoryFake();
        $moradores->usuarios[2] = ['privilegio' => 4];

        $resultado = (new LocalService(new LocalServiceLocalRepositoryFake(), $moradores))
            ->cadastrar(['nome_local' => 'Churrasqueira', 'capacidade' => 0, 'disponivel' => 'S'], 2);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Capacidade', $resultado['mensagem']);
    }

    public function testCadastrarComPermissaoSalvaDadosTratados(): void
    {
        $locais = new LocalServiceLocalRepositoryFake();
        $moradores = new LocalServiceMoradorRepositoryFake();
        $moradores->usuarios[2] = ['privilegio' => 2];

        $resultado = (new LocalService($locais, $moradores))
            ->cadastrar(['nome_local' => '  Salao de Festas  ', 'capacidade' => 80, 'disponivel' => 'N'], 2);

        $this->assertTrue($resultado['sucesso']);
        $this->assertSame('Salao de Festas', $locais->dadosSalvos['local']);
        $this->assertSame(80, $locais->dadosSalvos['capacidade']);
        $this->assertSame('N', $locais->dadosSalvos['disp_uso']);
        $this->assertSame(2, $locais->dadosSalvos['id_user_cad']);
    }
}

final class LocalServiceLocalRepositoryFake extends LocalRepository
{
    public ?array $dadosSalvos = null;

    public function __construct()
    {
    }

    public function save(array $data): bool
    {
        $this->dadosSalvos = $data;
        return true;
    }
}

final class LocalServiceMoradorRepositoryFake extends MoradorRepository
{
    public array $usuarios = [];

    public function __construct()
    {
    }

    public function findById(int $id): ?array
    {
        return $this->usuarios[$id] ?? null;
    }
}
