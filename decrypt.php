<?php

declare(strict_types=1);

require_once 'Captcha.php';
require_once 'Crypt/Encryption.php';

// Get chiffrement key and hmac key from secrets.php
require_once 'secrets.php';

$captcha = new Captcha(width: 200, height: 50, numberOfCharacters: 5);

// Créez une instance de Encryption
$encryptionService = new Encryption($key, $hmacKey);

try {

  $encryptedData = null;
  $encryptedData = isset($_GET['rnd']) ? $_GET['rnd'] : null;

  if (null === $encryptedData) {
    header("HTTP/1.0 400 Bad Request");
    exit("Paramètre 'rnd' manquant");
  }
  //replace  espace by +
  $encryptedData = str_replace(' ', '+', $encryptedData);

  $captchaString = $encryptionService->decrypt($encryptedData);
  $imageData = $captcha->generate($captchaString);
  // Définir l'en-tête Content-Type pour une image PNG
  header("Content-Type: image/png");

  echo $imageData;
} catch (Exception $e) {
  echo "Une erreur s'est produite : " . $e->getMessage() . "\n";
}
