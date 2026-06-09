<?php

namespace Tests\Support;

use LocalRepository;
use MoradorRepository;
use ReservaRepository;
use VeiculoRepository;

final class FakeMoradorRepository extends MoradorRepository
{
    public array $moradores = [];
    public bool $cpfExiste = false;
    public bool $emailExiste = false;
    public bool $emailOutroExiste = false;
    public bool $unidadeOcupada = false;
    public bool $atualizarDadosResultado = true;
    public bool $atualizarStatusResultado = true;
    public bool $atualizarPrivilegioResultado = true;
    public bool $atualizarUnidadeResultado = true;
    public bool $atualizarSenhaResultado = true;
    public int|bool $saveResultado = 10;
    public int $ativos = 0;
    public array $pendentes = [];
    public ?array $dadosSalvos = null;
    public ?array $dadosAtualizados = null;
    public ?array $statusAtualizado = null;
    public ?array $privilegioAtualizado = null;
    public ?array $unidadeAtualizada = null;
    public ?int $idDeletado = null;
    public ?int $idSenhaAtualizada = null;

    public function __construct()
    {
    }

    public function findById(int $id): ?array
    {
        return $this->moradores[$id] ?? null;
    }

    public function existeCpf(string $cpf): bool
    {
        return $this->cpfExiste;
    }

    public function existeEmail(string $email): bool
    {
        return $this->emailExiste;
    }

    public function existeEmailParaOutro(string $email, int $idAtual): bool
    {
        return $this->emailOutroExiste;
    }

    public function existeMoradorAtivoNaUnidade(string $apto, string $bloco, int $ignorarId = 0): bool
    {
        return $this->unidadeOcupada;
    }

    public function save(array $data): int|bool
    {
        $this->dadosSalvos = $data;
        return $this->saveResultado;
    }

    public function findPendentes(): array
    {
        return $this->pendentes;
    }

    public function countMoradoresAtivos(): int
    {
        return $this->ativos;
    }

    public function atualizarDados(array $update): bool
    {
        $this->dadosAtualizados = $update;
        return $this->atualizarDadosResultado;
    }

    public function deletarDados(int $id): bool
    {
        $this->idDeletado = $id;
        return true;
    }

    public function atualizarStatus(int $id, string $status): bool
    {
        $this->statusAtualizado = [$id, $status];
        return $this->atualizarStatusResultado;
    }

    public function atualizarPrivilegio(int $id, int $privilegio): bool
    {
        $this->privilegioAtualizado = [$id, $privilegio];
        return $this->atualizarPrivilegioResultado;
    }

    public function atualizarUnidade(int $id, string $apto, string $bloco): bool
    {
        $this->unidadeAtualizada = [$id, $apto, $bloco];
        return $this->atualizarUnidadeResultado;
    }

    public function atualizarSenha(int $id, string $senhaHash): bool
    {
        $this->idSenhaAtualizada = $id;
        return $this->atualizarSenhaResultado;
    }
}

final class FakeLocalRepository extends LocalRepository
{
    public array $locais = [];
    public array $disponiveis = [];
    public bool $saveResultado = true;
    public bool $updateResultado = true;
    public ?array $dadosSalvos = null;
    public ?array $dadosAtualizados = null;
    public ?int $idAtualizado = null;

    public function __construct()
    {
    }

    public function findById(int $id): ?array
    {
        return $this->locais[$id] ?? null;
    }

    public function findDisponiveis(): array
    {
        return $this->disponiveis;
    }

    public function save(array $data): bool
    {
        $this->dadosSalvos = $data;
        return $this->saveResultado;
    }

    public function update(int $id, array $data): bool
    {
        $this->idAtualizado = $id;
        $this->dadosAtualizados = $data;
        return $this->updateResultado;
    }
}

final class FakeReservaRepository extends ReservaRepository
{
    public bool $conflito = false;
    public bool $pendente = false;
    public bool $saveResultado = true;
    public array $pendentesGeral = [];
    public int $totalPendentesGeral = 0;
    public ?array $dadosSalvos = null;
    public ?array $conflitoConsultado = null;

    public function __construct()
    {
    }

    public function existeConflito(int $idLocal, string $data, string $horaIni, string $horaFim): bool
    {
        $this->conflitoConsultado = [$idLocal, $data, $horaIni, $horaFim];
        return $this->conflito;
    }

    public function existeReservaPendente(int $idUser): bool
    {
        return $this->pendente;
    }

    public function save(array $data): bool
    {
        $this->dadosSalvos = $data;
        return $this->saveResultado;
    }

    public function buscarReservasPendentesGeral(int $offset = 0, int $limite = 10): array
    {
        return $this->pendentesGeral;
    }

    public function countPendentesGeral(): int
    {
        return $this->totalPendentesGeral;
    }
}

final class FakeVeiculoRepository extends VeiculoRepository
{
    public bool $placaExiste = false;
    public int $quantidadeUsuario = 0;
    public int|bool $saveResultado = 1;
    public array $todos = [];
    public array $filtrados = [];
    public array $porUsuario = [];
    public ?array $veiculoPorPlaca = null;
    public ?array $veiculoPorId = null;
    public ?array $dadosSalvos = null;
    public ?array $dadosAtualizados = null;
    public ?array $filtrosRecebidos = null;
    public ?int $limiteRecebido = null;
    public ?int $offsetRecebido = null;
    public ?int $idAtualizado = null;
    public ?int $idExcluido = null;
    public ?int $usuarioDesmarcado = null;
    public ?int $veiculoPrincipal = null;
    public int $totalFiltrado = 0;

    public function __construct()
    {
    }

    public function existePlaca(string $placa): bool
    {
        return $this->placaExiste;
    }

    public function countByUser(int $idUser): int
    {
        return $this->quantidadeUsuario;
    }

    public function save(array $data): int|bool
    {
        $this->dadosSalvos = $data;
        return $this->saveResultado;
    }

    public function findAll(): array
    {
        return $this->todos;
    }

    public function findAllComFiltros(array $filtros, int $limite, int $offset): array
    {
        $this->filtrosRecebidos = $filtros;
        $this->limiteRecebido = $limite;
        $this->offsetRecebido = $offset;
        return $this->filtrados;
    }

    public function countAllComFiltros(array $filtros): int
    {
        $this->filtrosRecebidos = $filtros;
        return $this->totalFiltrado;
    }

    public function findByUsuario(int $idUser): array
    {
        return $this->porUsuario;
    }

    public function findByPlaca(string $placa): ?array
    {
        return $this->veiculoPorPlaca;
    }

    public function findById(int $id): ?array
    {
        return $this->veiculoPorId;
    }

    public function update(int $id, array $data): bool
    {
        $this->idAtualizado = $id;
        $this->dadosAtualizados = $data;
        return true;
    }

    public function delete(int $id): bool
    {
        $this->idExcluido = $id;
        return true;
    }

    public function desmarcarPrincipal(int $idUser): bool
    {
        $this->usuarioDesmarcado = $idUser;
        return true;
    }

    public function marcarPrincipal(int $idVeiculo): bool
    {
        $this->veiculoPrincipal = $idVeiculo;
        return true;
    }
}
