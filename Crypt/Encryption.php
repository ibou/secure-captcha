<?php

declare(strict_types=1);

class Encryption
{
    private string $key;
    private string $hmacKey;

    public function __construct(string $key, string $hmacKey)
    {
        $this->key = $key;
        $this->hmacKey = $hmacKey;
    }

    public function encrypt(string $data): string
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $this->key, 0, $iv);
        $hmac = hash_hmac('sha256', $iv . $encrypted, $this->hmacKey, true);
        return base64_encode($iv . $hmac . $encrypted);
    }

    public function decrypt(string $data): string
    {
        $data = base64_decode($data);
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($data, 0, $ivLength);
        $hmac = substr($data, $ivLength, 32);
        $encrypted = substr($data, $ivLength + 32);
        $calculatedHmac = hash_hmac('sha256', $iv . $encrypted, $this->hmacKey, true);
        if (!hash_equals($hmac, $calculatedHmac)) {
            throw new Exception('Invalid HMAC');
        }
        return openssl_decrypt($encrypted, 'aes-256-cbc', $this->key, 0, $iv);
    }
}
