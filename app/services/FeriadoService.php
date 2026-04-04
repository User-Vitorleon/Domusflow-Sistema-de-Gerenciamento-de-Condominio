<?php
class FeriadoService
{
    public function getFeriadosPorAno(int $ano): array
    {
        $url      = BRASIL_API_FERIADOS . $ano;
        $response = @file_get_contents($url);
        if ($response === false) return [];
        return json_decode($response, true) ?? [];
    }

    public function getProximoFeriado(): ?array
    {
        $hoje    = date('Y-m-d');
        $ano     = (int)date('Y');
        $feriados = $this->getFeriadosPorAno($ano);

        // Filtra feriados a partir de hoje
        $proximos = array_filter($feriados, fn($f) => $f['date'] >= $hoje);

        if (!empty($proximos)) {
            $proximo = array_values($proximos)[0];
            // Calcula dias restantes
            $diff = (new DateTime($proximo['date']))->diff(new DateTime($hoje));
            $proximo['dias_restantes'] = (int)$diff->days;
            // Formata data para pt-BR
            $proximo['data_formatada'] = (new DateTime($proximo['date']))
                ->format('d/m/Y');
            return $proximo;
        }

        // Se não houver mais feriados no ano, busca o primeiro do próximo ano
        $feriados = $this->getFeriadosPorAno($ano + 1);
        if (!empty($feriados)) {
            $proximo = $feriados[0];
            $diff = (new DateTime($proximo['date']))->diff(new DateTime($hoje));
            $proximo['dias_restantes'] = (int)$diff->days;
            $proximo['data_formatada'] = (new DateTime($proximo['date']))
                ->format('d/m/Y');
            return $proximo;
        }

        return null;
    }
}
