<?php

declare(strict_types=1);

class Captcha
{


  public function __construct(private int $width = 200, private int $height = 50, private int $numberOfCharacters = 6) {}

  public function generateCaptchaString()
  {
    $possibleLetters = '23456789abcdefghyzABCDEFGHJKLMNPQRSTUVWXYZ';

    $captchaString = '';
    for ($i = 0; $i < $this->numberOfCharacters; $i++) {
      $captchaString .= $possibleLetters[rand(0, strlen($possibleLetters) - 1)];
    }

    return $captchaString;
  }


  public function generate(string $captchaString)
  {

    $image = imagecreatetruecolor($this->width, $this->height);
    $bgColor = imagecolorallocate($image, 255, 255, 255); // Blanc
    $textColor = imagecolorallocate($image, 0, 0, 0); // Noir

    imagefilledrectangle($image, 0, 0, $this->width, $this->height, $bgColor);

    // Ajouter du bruit
    for ($i = 0; $i < 500; $i++) {
      imagesetpixel(
        $image,
        rand(0, $this->width),
        rand(0, $this->height),
        imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255))
      );
    }

    // Ajouter des lignes
    for ($i = 0; $i < 10; $i++) {
      $lineColor = imagecolorallocate($image, rand(200, 255), rand(200, 255), rand(200, 255));
      imageline($image, 0, rand(0, $this->height), $this->width, rand(0, $this->height), $lineColor);
    }

    $font = 5; // Utiliser la plus grande police intégrée
    $fontWidth = imagefontwidth($font);
    $fontHeight = imagefontheight($font);
    $length = strlen($captchaString);

    // Calculer l'espacement entre les caractères
    $spacing = ($this->width - $fontWidth * $length) / ($length + 1);

    for ($i = 0; $i < $length; $i++) {
      $x = intval(($i + 1) * $spacing + $i * $fontWidth);
      $y = intval(($this->height - $fontHeight) / 2 + rand(-5, 5));

      $textColor = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(0, 100));

      // Ajouter une ombre légère pour plus de contraste
      $shadowColor = imagecolorallocate($image, 200, 200, 200);
      imagechar($image, $font, $x + 1, $y + 1, $captchaString[$i], $shadowColor);

      imagechar($image, $font, $x, $y, $captchaString[$i], $textColor);
    }

    ob_start();
    imagepng($image);
    $imageData = ob_get_clean();
    imagedestroy($image);

    return $imageData;
  }
}
