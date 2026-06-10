<?php

namespace Tests\Unit\Services;

use FeriadoService;
use PHPUnit\Framework\TestCase;

final class FeriadoServiceTest extends TestCase
{
    public function testGetProximosFeriadosFiltraEFormataDatasFuturas(): void
    {
        $service = new class extends FeriadoService {
            public function getFeriadosPorAno(int $ano): array
            {
                return [
                    ['date' => '2000-01-01', 'name' => 'Passado'],
                    ['date' => date('Y-m-d', strtotime('+2 days')), 'name' => 'Proximo'],
                    ['date' => date('Y-m-d', strtotime('+5 days')), 'name' => 'Depois'],
                ];
            }
        };

        $feriados = $service->getProximosFeriados(1);

        $this->assertCount(1, $feriados);
        $this->assertSame('Proximo', $feriados[0]['name']);
        $this->assertSame(2, $feriados[0]['dias_restantes']);
        $this->assertMatchesRegularExpression('/^\d{2}\/\d{2}\/\d{4}$/', $feriados[0]['data_formatada']);
    }

    public function testGetProximoFeriadoRetornaPrimeiroDaLista(): void
    {
        $service = new class extends FeriadoService {
            public function getProximosFeriados(int $limite = 3): array
            {
                return [['date' => '2099-01-01', 'name' => 'Ano Novo']];
            }
        };

        $this->assertSame(['date' => '2099-01-01', 'name' => 'Ano Novo'], $service->getProximoFeriado());
    }

    public function testGetProximoFeriadoRetornaNullQuandoNaoHaFeriados(): void
    {
        $service = new class extends FeriadoService {
            public function getProximosFeriados(int $limite = 3): array
            {
                return [];
            }
        };

        $this->assertNull($service->getProximoFeriado());
    }
}
