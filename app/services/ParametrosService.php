<?php

class ParametrosService
{
    private const DEFAULTS = [
        'limite_moradores_ativos' => 1000,
        'permitir_apenas_uma_reserva_pendente' => true,
        'limite_veiculos_por_morador' => 2,
    ];

    private string $arquivo;

    public function __construct(?string $arquivo = null)
    {
        $this->arquivo = $arquivo ?? __DIR__ . '/../../config/parametros.php';
    }

    public function listar(): array
    {
        $parametros = file_exists($this->arquivo) ? require $this->arquivo : [];
        if (!is_array($parametros)) {
            $parametros = [];
        }

        return array_merge(self::DEFAULTS, $parametros);
    }

    public function salvar(array $dados): array
    {
        $parametros = [
            'limite_moradores_ativos' => (int)($dados['limite_moradores_ativos'] ?? 0),
            'permitir_apenas_uma_reserva_pendente' => isset($dados['permitir_apenas_uma_reserva_pendente']),
            'limite_veiculos_por_morador' => (int)($dados['limite_veiculos_por_morador'] ?? 0),
        ];

        foreach ($parametros as $chave => $valor) {
            $validacao = $this->validarParametro($chave, $valor);
            if (!$validacao['sucesso']) {
                return $validacao;
            }
        }

        return $this->gravar($parametros);
    }

    public function salvarParametro(string $chave, mixed $valor): array
    {
        $parametros = $this->listar();

        if (!array_key_exists($chave, self::DEFAULTS)) {
            return ['sucesso' => false, 'mensagem' => 'Parametro invalido.'];
        }

        $parametros[$chave] = $this->normalizarValor($chave, $valor);
        $validacao = $this->validarParametro($chave, $parametros[$chave]);
        if (!$validacao['sucesso']) {
            return $validacao;
        }

        return $this->gravar($parametros);
    }

    private function gravar(array $parametros): array
    {
        $conteudo = "<?php\n\nreturn " . var_export($parametros, true) . ";\n";
        $salvo = file_put_contents($this->arquivo, $conteudo, LOCK_EX);

        return $salvo === false
            ? ['sucesso' => false, 'mensagem' => 'Nao foi possivel salvar os parametros.']
            : ['sucesso' => true];
    }

    private function normalizarValor(string $chave, mixed $valor): int|bool
    {
        if ($chave === 'permitir_apenas_uma_reserva_pendente') {
            return (string)$valor === '1';
        }

        return (int)$valor;
    }

    private function validarParametro(string $chave, mixed $valor): array
    {
        if ($chave === 'limite_moradores_ativos' && (int)$valor < 1) {
            return ['sucesso' => false, 'mensagem' => 'Informe um limite de moradores maior que zero.'];
        }

        if ($chave === 'limite_veiculos_por_morador' && (int)$valor < 1) {
            return ['sucesso' => false, 'mensagem' => 'Informe um limite de veiculos maior que zero.'];
        }

        return ['sucesso' => true];
    }

    public function limiteMoradoresAtivos(): int
    {
        return (int)$this->listar()['limite_moradores_ativos'];
    }

    public function permitirApenasUmaReservaPendente(): bool
    {
        return (bool)$this->listar()['permitir_apenas_uma_reserva_pendente'];
    }

    public function limiteVeiculosPorMorador(): int
    {
        return (int)$this->listar()['limite_veiculos_por_morador'];
    }
}
