<?php

declare(strict_types=1);

require_once 'Captcha.php';
require_once 'Crypt/Encryption.php';

// Get chiffrement key and hmac key from secrets.php
require_once 'secrets.php';

$captcha = new Captcha(width: 200, height: 50, numberOfCharacters: 5);

// Créez une instance de Encryption
$encryptionService = new Encryption($key, $hmacKey);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $decryptedData = $encryptionService->decrypt($_POST['encryptedData']);
  $decryptedData = str_replace(' ', '+', $decryptedData);

  $isSubmetted = true;
  var_dump($_POST['captcha']);
  if (
    $_POST['captcha'] === $decryptedData
  ) {
    echo "Captcha correct";
  } else {
    echo "Captcha incorrect";
  }
  die('stop');
}

try {

  $encryptedData = null;
  $encryptedData = isset($_GET['rnd']) ? $_GET['rnd'] : null;

  if (null === $encryptedData) {
    return;
  }
  //replace  espace by +
  $encryptedData = str_replace(' ', '+', $encryptedData);

  $captchaString = $encryptionService->decrypt($encryptedData);
  $imageData = $captcha->generate($captchaString);
} catch (Exception $e) {
  echo "Une erreur s'est produite : " . $e->getMessage() . "\n";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Captcha Test</title>
</head>


<body>
  <form method="post">
    <img src="data:image/png;base64,<?php echo isset($imageData) ? base64_encode($imageData) : ''; ?>" alt="CAPTCHA">
    <br>
    <input type="text" name="captcha" required>
    <input type="hidden" name="encryptedData" value="<?php echo $encryptedData; ?>">
    <input type="submit" value="Vérifier">
  </form>
</body>

</html>