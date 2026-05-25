<?php

namespace Tests\Unit;

use LocalRepository;
use MoradorRepository;
use PHPUnit\Framework\TestCase;
use ReservaRepository;
use ReservaService;

require_once __DIR__ . '/../../app/repositories/ReservaRepository.php';
require_once __DIR__ . '/../../app/repositories/LocalRepository.php';
require_once __DIR__ . '/../../app/repositories/MoradorRepository.php';
require_once __DIR__ . '/../../app/services/ReservaService.php';

final class ReservaServiceTest extends TestCase
{
    public function testSalvarComCamposObrigatoriosAusentesRetornaErro(): void
    {
        $resultado = $this->criarService()->salvar([], 1);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('obrig', $resultado['mensagem']);
    }

    public function testSalvarComDataPassadaRetornaErro(): void
    {
        $resultado = $this->criarService()->salvar([
            'id_local' => 1,
            'data_reserva' => '2000-01-01',
            'hora_ini' => '10:00',
            'hora_fim' => '12:00',
        ], 1);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('passada', $resultado['mensagem']);
    }

    public function testSalvarComHorarioFimMenorOuIgualInicioRetornaErro(): void
    {
        $resultado = $this->criarService()->salvar([
            'id_local' => 1,
            'data_reserva' => date('Y-m-d', strtotime('+1 day')),
            'hora_ini' => '12:00',
            'hora_fim' => '12:00',
        ], 1);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('t', $resultado['mensagem']);
    }

    public function testSalvarComLocalIndisponivelRetornaErro(): void
    {
        $locais = new ReservaServiceLocalRepositoryFake();
        $locais->localPorId = ['disp_uso' => 'N'];

        $resultado = $this->criarService(localRepo: $locais)->salvar($this->dadosValidos(), 1);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('indispon', $resultado['mensagem']);
    }

    public function testSalvarComConflitoRetornaErro(): void
    {
        $reservas = new ReservaServiceReservaRepositoryFake();
        $reservas->temConflito = true;

        $resultado = $this->criarService(reservaRepo: $reservas)->salvar($this->dadosValidos(), 1);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('reserva aprovada', $resultado['mensagem']);
    }

    public function testSalvarComPendenteDoUsuarioRetornaErro(): void
    {
        $reservas = new ReservaServiceReservaRepositoryFake();
        $reservas->temPendente = true;

        $resultado = $this->criarService(reservaRepo: $reservas)->salvar($this->dadosValidos(), 1);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('reserva pendente', $resultado['mensagem']);
    }

    public function testListarLocaisDisponiveisRetornaRepositorio(): void
    {
        $locais = new ReservaServiceLocalRepositoryFake();
        $locais->disponiveis = [['local' => 'Salao']];

        $this->assertSame($locais->disponiveis, $this->criarService(localRepo: $locais)->listarLocaisDisponiveis());
    }

    public function testListarPendentesGeralRetornaRepositorio(): void
    {
        $reservas = new ReservaServiceReservaRepositoryFake();
        $reservas->pendentes = [['id_reserva' => 1]];

        $resultado = $this->criarService(reservaRepo: $reservas)->listarPendentesGeral(10, 5);

        $this->assertSame($reservas->pendentes, $resultado);
        $this->assertSame([10, 5], $reservas->consultaPendentes);
    }

    public function testContarPendentesGeralRetornaRepositorio(): void
    {
        $reservas = new ReservaServiceReservaRepositoryFake();
        $reservas->totalPendentes = 12;

        $this->assertSame(12, $this->criarService(reservaRepo: $reservas)->contarPendentesGeral());
    }

    private function criarService(
        ?ReservaServiceReservaRepositoryFake $reservaRepo = null,
        ?ReservaServiceLocalRepositoryFake $localRepo = null,
        ?ReservaServiceMoradorRepositoryFake $moradorRepo = null
    ): ReservaService {
        return new ReservaService(
            $reservaRepo ?? new ReservaServiceReservaRepositoryFake(),
            $localRepo ?? new ReservaServiceLocalRepositoryFake(),
            $moradorRepo ?? new ReservaServiceMoradorRepositoryFake()
        );
    }

    private function dadosValidos(): array
    {
        return [
            'id_local' => 1,
            'data_reserva' => date('Y-m-d', strtotime('+1 day')),
            'hora_ini' => '10:00',
            'hora_fim' => '12:00',
        ];
    }
}

final class ReservaServiceReservaRepositoryFake extends ReservaRepository
{
    public bool $temConflito = false;
    public bool $temPendente = false;
    public array $pendentes = [];
    public int $totalPendentes = 0;
    public ?array $consultaPendentes = null;

    public function __construct()
    {
    }

    public function existeConflito(int $idLocal, string $data, string $horaIni, string $horaFim): bool
    {
        return $this->temConflito;
    }

    public function existeReservaPendente(int $idUser): bool
    {
        return $this->temPendente;
    }

    public function buscarReservasPendentesGeral(int $offset = 0, int $limite = 10): array
    {
        $this->consultaPendentes = [$offset, $limite];
        return $this->pendentes;
    }

    public function countPendentesGeral(): int
    {
        return $this->totalPendentes;
    }
}

final class ReservaServiceLocalRepositoryFake extends LocalRepository
{
    public ?array $localPorId = ['disp_uso' => 'S', 'local' => 'Salao'];
    public array $disponiveis = [];

    public function __construct()
    {
    }

    public function findById(int $id): ?array
    {
        return $this->localPorId;
    }

    public function findDisponiveis(): array
    {
        return $this->disponiveis;
    }
}

final class ReservaServiceMoradorRepositoryFake extends MoradorRepository
{
    public function __construct()
    {
    }

    public function findById(int $id): ?array
    {
        return ['email' => 'maria@example.com', 'nome' => 'Maria'];
    }
}
