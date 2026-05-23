<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Local;

final class LocalTest extends TestCase
{
    public function testIsDisponivelQuandoFlagS(): void
    {
        $l = new Local();
        $l->disp_uso = 'S';
        $this->assertTrue($l->isDisponivel());
    }

    public function testNaoEhDisponivelQuandoFlagN(): void
    {
        $l = new Local();
        $l->disp_uso = 'N';
        $this->assertFalse($l->isDisponivel());
    }

    public function testFromArrayMapeiaCampos(): void
    {
        $l = Local::fromArray([
            'id_local'    => '11',
            'local'       => 'Salao de Festas',
            'capacidade'  => '50',
            'disp_uso'    => 'S',
            'id_user_cad' => '2',
        ]);

        $this->assertSame(11, $l->id);
        $this->assertSame('Salao de Festas', $l->local);
        $this->assertSame(50, $l->capacidade);
        $this->assertSame('S', $l->disp_uso);
        $this->assertSame(2, $l->id_user_cad);
        $this->assertTrue($l->isDisponivel());
    }

    public function testFromArrayUsaPadroes(): void
    {
        $l = Local::fromArray([]);

        $this->assertSame(0, $l->id);
        $this->assertSame('', $l->local);
        $this->assertSame(0, $l->capacidade);
        $this->assertSame('S', $l->disp_uso);
        $this->assertSame(0, $l->id_user_cad);
    }
}
