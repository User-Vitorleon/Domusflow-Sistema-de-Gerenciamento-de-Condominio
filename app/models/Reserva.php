<?php

class Reserva
{
    public int    $id;
    public int    $id_local;
    public int    $id_user;
    public string $data_reserva;
    public string $hora_ini;
    public string $hora_fim;
    public string $status;

    public static function fromArray(array $data): self
    {
        $r = new self();
        $r->id           = (int)($data['id_reserva'] ?? 0);
        $r->id_local     = (int)($data['id_local']   ?? 0);
        $r->id_user      = (int)($data['id_user']    ?? 0);
        $r->data_reserva = $data['data_reserva']     ?? '';
        $r->hora_ini     = $data['hora_ini']         ?? '';
        $r->hora_fim     = $data['hora_fim']         ?? '';
        $r->status       = $data['status']           ?? 'P';
        return $r;
    }
}
