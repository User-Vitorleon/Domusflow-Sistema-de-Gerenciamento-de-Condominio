<?php
<<<<<<< HEAD
=======

>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
class FeriadoService
{
    public function getFeriadosPorAno(int $ano): array
    {
<<<<<<< HEAD
        $url = BRASIL_API_FERIADOS . $ano;
=======
        $url      = BRASIL_API_FERIADOS . $ano;
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
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
<<<<<<< HEAD
        $hoje = date('Y-m-d');
        $anoAtual = (int) date('Y');
=======
        $hoje     = date('Y-m-d');
        $anoAtual = (int)date('Y');
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
        $feriados = array_merge(
            $this->getFeriadosPorAno($anoAtual),
            $this->getFeriadosPorAno($anoAtual + 1)
        );

<<<<<<< HEAD
        $proximos = array_filter($feriados, function ($feriado) use ($hoje) {
            return isset($feriado['date']) && $feriado['date'] >= $hoje;
        });

        $proximos = array_values($proximos);
        $proximos = array_slice($proximos, 0, $limite);

        foreach ($proximos as &$feriado) {
            $diff = (new DateTime($feriado['date']))->diff(new DateTime($hoje));
            $feriado['dias_restantes'] = (int) $diff->days;
=======
        $proximos = array_filter($feriados, static function ($feriado) use ($hoje) {
            return isset($feriado['date']) && $feriado['date'] >= $hoje;
        });

        $proximos = array_slice(array_values($proximos), 0, $limite);

        foreach ($proximos as &$feriado) {
            $diff = (new DateTime($feriado['date']))->diff(new DateTime($hoje));
            $feriado['dias_restantes'] = (int)$diff->days;
>>>>>>> e213854 (feat: testes unitarios 30% e realizado o clean code no projeto)
            $feriado['data_formatada'] = (new DateTime($feriado['date']))->format('d/m/Y');
        }

        return $proximos;
    }
}
