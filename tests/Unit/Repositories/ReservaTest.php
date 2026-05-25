<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Reserva;

final class ReservaTest extends TestCase
{
    public function testFromArrayMapeiaCampos(): void
    {
        $r = Reserva::fromArray([
            'id_reserva'   => '21',
            'id_local'     => '3',
            'id_user'      => '8',
            'data_reserva' => '2026-06-10',
            'hora_ini'     => '18:00',
            'hora_fim'     => '22:00',
            'status'       => 'A',
        ]);

        $this->assertSame(21, $r->id);
        $this->assertSame(3, $r->id_local);
        $this->assertSame(8, $r->id_user);
        $this->assertSame('2026-06-10', $r->data_reserva);
        $this->assertSame('18:00', $r->hora_ini);
        $this->assertSame('22:00', $r->hora_fim);
        $this->assertSame('A', $r->status);
    }

    public function testFromArrayUsaStatusPadraoPendente(): void
    {
        $r = Reserva::fromArray([]);

        $this->assertSame(0, $r->id);
        $this->assertSame(0, $r->id_local);
        $this->assertSame(0, $r->id_user);
        $this->assertSame('', $r->data_reserva);
        $this->assertSame('', $r->hora_ini);
        $this->assertSame('', $r->hora_fim);
        $this->assertSame('P', $r->status);
    }

    public function testFromArrayConverteIdsNumericosParaInt(): void
    {
        $r = Reserva::fromArray([
            'id_reserva' => '100',
            'id_local'   => '7',
            'id_user'    => '50',
        ]);

        $this->assertIsInt($r->id);
        $this->assertIsInt($r->id_local);
        $this->assertIsInt($r->id_user);
    }
}
