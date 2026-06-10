<?php

class CryptoHelper
{
    private const CIPHER = 'AES-256-CBC';

    private static function key(): string
    {
        $salt = (defined('HASH_SALT') && HASH_SALT !== '') ? HASH_SALT : 'domusflow_dev_key';
        return hash('sha256', $salt, true);
    }

    public static function encrypt(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        $iv = random_bytes(openssl_cipher_iv_length(self::CIPHER));
        $cipher = openssl_encrypt($value, self::CIPHER, self::key(), OPENSSL_RAW_DATA, $iv);

        return base64_encode($iv . $cipher);
    }

    public static function decrypt(?string $payload): ?string
    {
        if ($payload === null || $payload === '') {
            return $payload;
        }

        $raw = base64_decode($payload, true);
        $ivLength = openssl_cipher_iv_length(self::CIPHER);

        if ($raw === false || strlen($raw) <= $ivLength) {
            return $payload;
        }

        $iv = substr($raw, 0, $ivLength);
        $cipher = substr($raw, $ivLength);
        $plain = openssl_decrypt($cipher, self::CIPHER, self::key(), OPENSSL_RAW_DATA, $iv);

        return $plain === false ? $payload : $plain;
    }

    public static function hashLookup(string $value): string
    {
        return hash_hmac('sha256', strtolower(trim($value)), self::key());
    }

    public static function hashCpf(string $cpf): string
    {
        return self::hashLookup(preg_replace('/\D/', '', $cpf));
    }

    public static function hashEmail(string $email): string
    {
        return self::hashLookup($email);
    }
}
