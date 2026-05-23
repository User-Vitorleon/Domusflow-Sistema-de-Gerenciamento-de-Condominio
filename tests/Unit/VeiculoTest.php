<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Veiculo;

final class VeiculoTest extends TestCase
{
    public function testFromArrayMapeiaCamposPrincipais(): void
    {
        $dados = [
            'id_veiculo'  => '7',
            'placa'       => 'ABC1D23',
            'marca'       => 'Fiat',
            'modelo'      => 'Uno',
            'cor'         => 'Branca',
            'id_user'     => '15',
            'id_user_cad' => '3',
            'created_at'  => '2026-01-01 10:00:00',
        ];

        $v = Veiculo::fromArray($dados);

        $this->assertSame(7, $v->id);
        $this->assertSame('ABC1D23', $v->placa);
        $this->assertSame('Fiat', $v->marca);
        $this->assertSame('Uno', $v->modelo);
        $this->assertSame('Branca', $v->cor);
        $this->assertSame(15, $v->id_user);
        $this->assertSame(3, $v->id_user_cad);
        $this->assertSame('2026-01-01 10:00:00', $v->created_at);
    }

    public function testFromArrayConverteIdsParaInteiro(): void
    {
        $v = Veiculo::fromArray([
            'id_veiculo'  => '99',
            'id_user'     => '12',
            'id_user_cad' => '5',
        ]);

        $this->assertIsInt($v->id);
        $this->assertIsInt($v->id_user);
        $this->assertIsInt($v->id_user_cad);
    }

    public function testFromArrayUsaPadroesQuandoVazio(): void
    {
        $v = Veiculo::fromArray([]);

        $this->assertSame(0, $v->id);
        $this->assertSame('', $v->placa);
        $this->assertSame('', $v->marca);
        $this->assertSame('', $v->modelo);
        $this->assertSame('', $v->cor);
        $this->assertSame(0, $v->id_user);
        $this->assertSame(0, $v->id_user_cad);
        $this->assertSame('', $v->created_at);
    }
}
