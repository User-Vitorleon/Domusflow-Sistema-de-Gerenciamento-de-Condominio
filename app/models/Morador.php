<?php
class Morador {
    public int    $id;
    public string $nome;
    public string $cpf;
    public string $apto;
    public string $bloco;
    public string $email;
    public string $telefone;
    public ?string $telefone_recado;
    public string $status;    // P=Pendente, L=Liberado, B=Bloqueado
    public int    $privilegio; // 1=Morador, 2=Síndico

    public function getPrimeiroNome(): string {
        return explode(' ', $this->nome)[0];
    }

    public function isSindico(): bool {
        return $this->privilegio === 2;
    }

    public function isAtivo(): bool {
        return $this->status === 'L';
    }

    public static function fromArray(array $data): self {
        $m = new self();
        $m->id              = (int)($data['id_user']    ?? 0);
        $m->nome            = $data['nome']              ?? '';
        $m->cpf             = $data['cpf']               ?? '';
        $m->apto            = $data['apto']              ?? '';
        $m->bloco           = $data['bloco']             ?? '';
        $m->email           = $data['email']             ?? '';
        $m->telefone        = $data['telefone']          ?? '';
        $m->telefone_recado = $data['tell_recado']       ?? null;
        $m->status          = $data['status']            ?? 'P';
        $m->privilegio      = (int)($data['privilegio'] ?? 1);
        return $m;
    }
}