<?php

class Local
{
    public int    $id;
    public string $local;
    public int    $capacidade;
    public string $disp_uso;
    public int    $id_user_cad;

    public function isDisponivel(): bool
    {
        return $this->disp_uso === 'S';
    }

    public static function fromArray(array $data): self
    {
        $l = new self();
        $l->id          = (int)($data['id_local']    ?? 0);
        $l->local       = $data['local']             ?? '';
        $l->capacidade  = (int)($data['capacidade']  ?? 0);
        $l->disp_uso    = $data['disp_uso']          ?? 'S';
        $l->id_user_cad = (int)($data['id_user_cad'] ?? 0);
        return $l;
    }
}
