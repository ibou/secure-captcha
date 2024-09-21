# secure-captcha

## Required

php 8.2 or higher

## Fonctionnement

1. Si besoin, changer les valeurs dans secrets.php mettre des valeurs aléatoires (les valeurs par défaut fonctionnent aussi)
2. Générer un code crypté avec la commande suivante

```php
$ php encrypt.php
```

> Résultat possible attendu

```php
array(2) {
  'letters' =>
  string(5) "QGRVZ"
  'encryptedData' =>
  string(96) "yyEBQcUxR1tIzjnvzSOJZoPPDWfTQXik2Flu86XUadUYdtQIrJkBY/6O1wlI6OeuUnBzQmJwNWdqdzFwMlhmV3R1WjBOdz09"
}

encryptedData = valeur encryptée de 'letters'
```

> Possibilité de paramétrer le nombre de lettre à générer

```php
$captcha = new Captcha(width: 200, height: 50, numberOfCharacters: 7);
// 7 lettres
```

3. Lancer un serveur web pour afficher le captcha

```php
$ php -S localhost:8000 decrypt.php
```

> Go to you browser :
> http://localhost:8000/decrypt.php?rnd=yyEBQcUxR1tIzjnvzSOJZoPPDWfTQXik2Flu86XUadUYdtQIrJkBY/6O1wlI6OeuUnBzQmJwNWdqdzFwMlhmV3R1WjBOdz09

> decrypt.php?rnd=yyEBQcUxR1tIzjnvzSOJZoPPDWfTQXik2Flu86XUadUYdtQIrJkBY/6O1wlI6OeuUnBzQmJwNWdqdzFwMlhmV3R1WjBOdz09