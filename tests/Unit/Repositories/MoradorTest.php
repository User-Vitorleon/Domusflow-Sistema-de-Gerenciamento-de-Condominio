<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Morador;

final class MoradorTest extends TestCase
{
    public function testGetPrimeiroNomeRetornaPrimeiraPalavra(): void
    {
        $m = new Morador();
        $m->nome = 'Maria Aparecida da Silva';
        $this->assertSame('Maria', $m->getPrimeiroNome());
    }

    public function testGetPrimeiroNomeComNomeUnico(): void
    {
        $m = new Morador();
        $m->nome = 'Joao';
        $this->assertSame('Joao', $m->getPrimeiroNome());
    }

    public function testIsSindicoQuandoPrivilegioDois(): void
    {
        $m = new Morador();
        $m->privilegio = 2;
        $this->assertTrue($m->isSindico());
    }

    public function testNaoEhSindicoQuandoPrivilegioUm(): void
    {
        $m = new Morador();
        $m->privilegio = 1;
        $this->assertFalse($m->isSindico());
    }

    public function testIsAtivoQuandoStatusL(): void
    {
        $m = new Morador();
        $m->status = 'L';
        $this->assertTrue($m->isAtivo());
    }

    public function testNaoEhAtivoQuandoStatusP(): void
    {
        $m = new Morador();
        $m->status = 'P';
        $this->assertFalse($m->isAtivo());
    }

    public function testNaoEhAtivoQuandoStatusB(): void
    {
        $m = new Morador();
        $m->status = 'B';
        $this->assertFalse($m->isAtivo());
    }

    public function testFromArrayMapeiaTodosOsCampos(): void
    {
        $dados = [
            'id_user'    => '42',
            'nome'       => 'Carlos Souza',
            'cpf'        => '12345678900',
            'apto'       => '101',
            'bloco'      => 'A',
            'email'      => 'carlos@example.com',
            'telefone'   => '11999999999',
            'tell_recado'=> '1133334444',
            'status'     => 'L',
            'privilegio' => '2',
        ];

        $m = Morador::fromArray($dados);

        $this->assertSame(42, $m->id);
        $this->assertSame('Carlos Souza', $m->nome);
        $this->assertSame('12345678900', $m->cpf);
        $this->assertSame('101', $m->apto);
        $this->assertSame('A', $m->bloco);
        $this->assertSame('carlos@example.com', $m->email);
        $this->assertSame('11999999999', $m->telefone);
        $this->assertSame('1133334444', $m->telefone_recado);
        $this->assertSame('L', $m->status);
        $this->assertSame(2, $m->privilegio);
    }

    public function testFromArrayUsaPadroesQuandoCamposAusentes(): void
    {
        $m = Morador::fromArray([]);

        $this->assertSame(0, $m->id);
        $this->assertSame('', $m->nome);
        $this->assertSame('P', $m->status);
        $this->assertSame(1, $m->privilegio);
        $this->assertNull($m->telefone_recado);
    }
}
