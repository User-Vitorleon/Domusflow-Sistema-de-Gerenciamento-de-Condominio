<?php

class ParametrosService
{
    private const DEFAULTS = [
        'limite_moradores_ativos' => 1000,
        'permitir_apenas_uma_reserva_pendente' => true,
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
        $limite = (int)($dados['limite_moradores_ativos'] ?? 0);
        if ($limite < 1) {
            return ['sucesso' => false, 'mensagem' => 'Informe um limite de moradores maior que zero.'];
        }

        $parametros = [
            'limite_moradores_ativos' => $limite,
            'permitir_apenas_uma_reserva_pendente' => isset($dados['permitir_apenas_uma_reserva_pendente']),
        ];

        $conteudo = "<?php\n\nreturn " . var_export($parametros, true) . ";\n";
        $salvo = file_put_contents($this->arquivo, $conteudo, LOCK_EX);

        return $salvo === false
            ? ['sucesso' => false, 'mensagem' => 'Nao foi possivel salvar os parametros.']
            : ['sucesso' => true];
    }

    public function limiteMoradoresAtivos(): int
    {
        return (int)$this->listar()['limite_moradores_ativos'];
    }

    public function permitirApenasUmaReservaPendente(): bool
    {
        return (bool)$this->listar()['permitir_apenas_uma_reserva_pendente'];
    }
}
