<?php

class Veiculo
{
    public int    $id;
    public string $placa;
    public string $marca;
    public string $modelo;
    public string $cor;
    public int    $id_user;
    public int    $id_user_cad;
    public string $created_at;

    public static function fromArray(array $data): self
    {
        $v              = new self();
        $v->id          = (int)($data['id_veiculo'] ?? 0);
        $v->placa       = $data['placa']            ?? '';
        $v->marca       = $data['marca']            ?? '';
        $v->modelo      = $data['modelo']           ?? '';
        $v->cor         = $data['cor']              ?? '';
        $v->id_user     = (int)($data['id_user']    ?? 0);
        $v->id_user_cad = (int)($data['id_user_cad'] ?? 0);
        $v->created_at  = $data['created_at']       ?? '';
        return $v;
    }
}
