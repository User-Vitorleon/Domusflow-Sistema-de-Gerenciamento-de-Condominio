<?php

class FeriadoService
{
    public function getFeriadosPorAno(int $ano): array
    {
        $url      = BRASIL_API_FERIADOS . $ano;
        $response = @file_get_contents($url);

        if ($response === false) {
            return [];
        }

        return json_decode($response, true) ?? [];
    }

    public function getProximoFeriado(): ?array
    {
        $proximos = $this->getProximosFeriados(1);
        return $proximos[0] ?? null;
    }

    public function getProximosFeriados(int $limite = 3): array
    {
        $hoje     = date('Y-m-d');
        $anoAtual = (int)date('Y');
        $feriados = array_merge(
            $this->getFeriadosPorAno($anoAtual),
            $this->getFeriadosPorAno($anoAtual + 1)
        );

        $proximos = array_filter($feriados, static function ($feriado) use ($hoje) {
            return isset($feriado['date']) && $feriado['date'] >= $hoje;
        });

        $proximos = array_slice(array_values($proximos), 0, $limite);

        foreach ($proximos as &$feriado) {
            $diff = (new DateTime($feriado['date']))->diff(new DateTime($hoje));
            $feriado['dias_restantes'] = (int)$diff->days;
            $feriado['data_formatada'] = (new DateTime($feriado['date']))->format('d/m/Y');
        }

        return $proximos;
    }
}
