<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use ReservaService;
use Tests\Support\FakeLocalRepository;
use Tests\Support\FakeMoradorRepository;
use Tests\Support\FakeReservaRepository;

final class ReservaServiceTest extends TestCase
{
    private FakeReservaRepository $reservaRepo;
    private FakeLocalRepository $localRepo;
    private FakeMoradorRepository $moradorRepo;
    private ReservaService $service;

    protected function setUp(): void
    {
        $this->reservaRepo = new FakeReservaRepository();
        $this->localRepo = new FakeLocalRepository();
        $this->moradorRepo = new FakeMoradorRepository();
        $this->localRepo->locais[1] = ['id_local' => 1, 'local' => 'Salao', 'disp_uso' => 'S'];
        $this->moradorRepo->moradores[7] = ['id_user' => 7, 'nome' => 'Ana', 'email' => 'ana@example.com'];
        $this->service = new ReservaService($this->reservaRepo, $this->localRepo, $this->moradorRepo);
    }

    private function dadosValidos(array $override = []): array
    {
        return array_replace([
            'id_local' => 1,
            'data_reserva' => date('Y-m-d', strtotime('+3 days')),
            'hora_ini' => '10:00',
            'hora_fim' => '12:00',
        ], $override);
    }

    public function testSalvarExigeCamposObrigatorios(): void
    {
        $resultado = $this->service->salvar(['id_local' => 1], 7);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('obrig', $resultado['mensagem']);
    }

    public function testSalvarNaoPermiteDataPassada(): void
    {
        $resultado = $this->service->salvar($this->dadosValidos(['data_reserva' => '2000-01-01']), 7);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('data passada', $resultado['mensagem']);
    }

    public function testSalvarExigeHoraFimMaiorQueInicio(): void
    {
        $resultado = $this->service->salvar($this->dadosValidos(['hora_ini' => '12:00', 'hora_fim' => '11:00']), 7);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('maior que', $resultado['mensagem']);
    }

    public function testSalvarBloqueiaLocalIndisponivel(): void
    {
        $this->localRepo->locais[1]['disp_uso'] = 'N';

        $resultado = $this->service->salvar($this->dadosValidos(), 7);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('Local', $resultado['mensagem']);
        $this->assertStringContainsString('reserva', $resultado['mensagem']);
    }

    public function testSalvarBloqueiaConflitoDeHorario(): void
    {
        $this->reservaRepo->conflito = true;

        $resultado = $this->service->salvar($this->dadosValidos(), 7);

        $this->assertFalse($resultado['sucesso']);
        $this->assertStringContainsString('reserva aprovada', $resultado['mensagem']);
        $this->assertSame([1, $this->dadosValidos()['data_reserva'], '10:00', '12:00'], $this->reservaRepo->conflitoConsultado);
    }

    public function testListarLocaisDisponiveisDelegadoAoRepositorio(): void
    {
        $this->localRepo->disponiveis = [['id_local' => 1, 'local' => 'Salao']];

        $this->assertSame($this->localRepo->disponiveis, $this->service->listarLocaisDisponiveis());
    }

    public function testListarPendentesGeralDelegadoAoRepositorio(): void
    {
        $this->reservaRepo->pendentesGeral = [['id_reserva' => 2]];

        $this->assertSame($this->reservaRepo->pendentesGeral, $this->service->listarPendentesGeral(5, 15));
    }

    public function testContarPendentesGeralDelegadoAoRepositorio(): void
    {
        $this->reservaRepo->totalPendentesGeral = 6;

        $this->assertSame(6, $this->service->contarPendentesGeral());
    }
}
