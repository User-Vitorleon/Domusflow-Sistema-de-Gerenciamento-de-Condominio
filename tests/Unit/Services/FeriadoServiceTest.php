<?php

namespace Tests\Unit;

use FeriadoService;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../app/services/FeriadoService.php';

final class FeriadoServiceTest extends TestCase
{
    public function testGetProximosFeriadosFiltraLimitaEFormataDatas(): void
    {
        $service = new FeriadoServiceFake([
            date('Y') => [
                ['date' => '2000-01-01', 'name' => 'Antigo'],
                ['date' => date('Y-m-d', strtotime('+2 days')), 'name' => 'Depois de amanha'],
                ['date' => date('Y-m-d', strtotime('+5 days')), 'name' => 'Proxima semana'],
            ],
            date('Y') + 1 => [
                ['date' => date('Y-m-d', strtotime('+10 days')), 'name' => 'Outro'],
            ],
        ]);

        $feriados = $service->getProximosFeriados(2);

        $this->assertCount(2, $feriados);
        $this->assertSame('Depois de amanha', $feriados[0]['name']);
        $this->assertSame(2, $feriados[0]['dias_restantes']);
        $this->assertSame(date('d/m/Y', strtotime('+2 days')), $feriados[0]['data_formatada']);
        $this->assertSame('Proxima semana', $feriados[1]['name']);
    }

    public function testGetProximoFeriadoRetornaPrimeiroDaLista(): void
    {
        $service = new FeriadoServiceFake([
            date('Y') => [
                ['date' => date('Y-m-d', strtotime('+1 day')), 'name' => 'Primeiro'],
                ['date' => date('Y-m-d', strtotime('+2 days')), 'name' => 'Segundo'],
            ],
            date('Y') + 1 => [],
        ]);

        $this->assertSame('Primeiro', $service->getProximoFeriado()['name']);
    }

    public function testGetProximoFeriadoRetornaNullQuandoNaoHaFeriados(): void
    {
        $service = new FeriadoServiceFake([
            date('Y') => [],
            date('Y') + 1 => [],
        ]);

        $this->assertNull($service->getProximoFeriado());
    }
}

final class FeriadoServiceFake extends FeriadoService
{
    public function __construct(private array $feriadosPorAno)
    {
    }

    public function getFeriadosPorAno(int $ano): array
    {
        return $this->feriadosPorAno[$ano] ?? [];
    }
}
