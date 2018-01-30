# Dooki-PHP-SDK

[Dooki's](http://www.dooki.com.br) é a segunda versão da plataforma de e-commerce da BUBB.Store e este é o seu SDK.

## Principais Recursos

* [x] Recurso de Login com JWT e Tokens de usuário.
* [x] Recurso de Requests.

## Dependências

* PHP >= 7.0

## Instalando o SDK

Se já possui um arquivo `composer.json`, basta adicionar a seguinte dependência ao seu projeto:

```json
"require": {
    "dooki/dooki-php-sdk": "^1.0"
}
```

Com a dependência adicionada ao `composer.json`, basta executar:

```
composer install
```

Alternativamente, você pode executar diretamente em seu terminal:

```
composer require "dooki/dooki-php-sdk"
```

## Utilizando a SDK

Você pode autenticar sua aplicação utilizando JWT (JSON Web Tokens).

Se você não possuí um JWT ainda, use o método `login` para criar um e guardar-lo.

```php
require 'vendor/autoload.php';

use Dooki\Dooki;
use Dooki\DookiRequest;

// Configure seu ambiente.
$dooki = new Dooki(DookiRequest::sandbox());

// Configure sua loja.
$dooki->setMerchant('IDdasualoja');

try {
	// Faz o login por credenciais.
	$auth = $dooki->login(['email' => 'email@sualoja.com.br', 'password' => 'senha']);

	$type = $auth->getAuthTokenType(); // bearer

	$JWT = $auth->getAuthToken(); //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
} catch (DookiRequestException $e) {
	// Credênciais inválidas.
}
```

Se você já possuí um JWT, autentique-se desta maneira.

```php
require 'vendor/autoload.php';

use Dooki\Dooki;
use Dooki\DookiRequest;
use Dooki\DookiRequestException;

// Busque seu JWT.
$JWT = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...';

// Configure seu JWT, seu ambiente e faz o login por JWT.
$dooki = new Dooki($JWT, DookiRequest::sandbox());

// Configure sua loja...
```

Se você não possuí um JWT porém lhe foi dado um `token de usuário`, credencie-se desta maneira.

```php
require 'vendor/autoload.php';

use Dooki\Dooki;
use Dooki\DookiRequest;

// Configure seu ambiente.
$dooki = new Dooki(DookiRequest::sandbox());

// Configure sua loja.
$dooki->setMerchant('IDdasualoja');

try {
	// Configure seu token de usuário.
	$userToken = 'JlLWFwaS12Mi5sb2NhbC9JlLWFwaS12Mi5sb...';

	// Faz o login por token de usuário.
	$auth = $dooki->userToken($userToken);

	$type = $auth->getAuthTokenType(); // user-token
} catch (DookiRequestException $e) {
	// Token de usuário inválido.
}
```

Uma vez autenticado/credenciado, você já pode consumir a Dooki usufruindo este SDK.

```php
require 'vendor/autoload.php';

use Dooki\Dooki;
use Dooki\DookiRequest;
use Dooki\DookiRequestException;

// Busque seu JWT.
$jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...';

// Configure seu JWT, seu ambiente e sua loja.
$dooki = (new Dooki($jwt, DookiRequest::sandbox()))->setMerchant('IDdasualoja');

// Busca o catalogo de produtos da sua loja no Dooki.
$response = $dooki->request('GET', '/catalog/products');

$response->getData(); // array
```

Criamos métodos para facilitar os recursos de pesquisa avançada e filtros.

```php
require 'vendor/autoload.php';

use Dooki\Dooki;
use Dooki\DookiRequest;
use Dooki\DookiRequestException;

// Busque seu JWT.
$jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...';

// Configure seu JWT, seu ambiente e sua loja.
$dooki = (new Dooki($jwt, DookiRequest::sandbox()))->setMerchant('IDdasualoja');

// Filtra por página.
$dooki->page(2);

// Filtra por nome e formato de busca (LIKE).
$dooki->search(['name' => 'Roupa de Cama']);
$dooki->searchFields(['name' => 'like']);

// Filtra por data de criação (created_at)...
$dooki->period(Carbon\Carbon::now(), Carbon\Carbon::now()->subDays(7));
// ...ou, também, por qualquer campo de data.
$dooki->period('any_date_field', Carbon\Carbon::now(), Carbon\Carbon::now()->subDays(7));

// Ordena por nome e por forma de ordenação.
$dooki->orderBy('name');
$dooki->sortedBy('desc');

// Altera o limite da paginação.
$dooki->limit(20);

// Ignora o cache.
$dooki->skipCache();

// Busca o catalogo de produtos da sua loja no Dooki.
$response = $dooki->request('GET', '/catalog/products');

$response->getData(); // array
```

## Change Log

Consulte [CHANGELOG](.github/CHANGELOG.md) para obter mais informações sobre o que mudou recentemente.

## Contribuições

Consulte [CONTRIBUTING](.github/CONTRIBUTING.md) para obter mais detalhes.

## Segurança

Se você descobrir quaisquer problemas relacionados à segurança, envie um e-mail para contato@bubbstore.com.br em vez de usar as issues.