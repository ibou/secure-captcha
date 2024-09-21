<?php

declare(strict_types=1);

require_once 'Crypt/Encryption.php';
require_once 'Captcha.php';

// $key = bin2hex(random_bytes(32)); // 256 bits pour AES-256
// $hmacKey = bin2hex(random_bytes(32)); // 256 bits pour HMAC-SHA256

// get chiffrement key and hmac key from secrets.php
require_once 'secrets.php';

// Créez une instance de Encryption
$encryptionService = new Encryption($key, $hmacKey);

$captcha = new Captcha(width: 200, height: 50, numberOfCharacters: 5);

$captchaTemp = $captcha->generateCaptchaString();
$encryptedData = $encryptionService->encrypt($captchaTemp);

var_dump([
  'letters' => $captchaTemp,
  'encryptedData' => $encryptedData,
]);
