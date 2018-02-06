# Dooki-PHP-SDK

SDK oficial da plataforma de e-commerce [BUBB.Store](https://www.bubbstore.com.br)

[![StyleCI](https://styleci.io/repos/118114699/shield?branch=master)](https://styleci.io/repos/118114699) <a href="https://codeclimate.com/github/bubbstore/dooki-php-sdk/maintainability"><img src="https://api.codeclimate.com/v1/badges/8103a9eeee26e720c90b/maintainability" /></a>

## Principais Recursos

* [x] Recurso de Login com JWT e Tokens de usuário.
* [x] Recurso de Requests.

## Dependências

* PHP >= 7.0

## Instalação via Composer

```bash
$ composer require dooki/dooki-php-sdk
```

## Utilizando a SDK

Você pode autenticar sua aplicação utilizando JWT (JSON Web Tokens).

```php
require 'vendor/autoload.php';

use Dooki\Dooki;
use Dooki\DookiRequest;
use Dooki\Exceptions\DookiValidationException;
use Dooki\Exceptions\DookiRequestException;

// Configure seu ambiente.
$dooki = new Dooki(DookiRequest::sandbox());

// Configure sua loja.
$dooki->setMerchant('aliasDeSuaLoja');

try {
	// Faz o login por credenciais.
	$auth = $dooki->login(['email' => 'email@sualoja.com.br', 'password' => 'senha']);

	$type = $auth->getAuthTokenType(); // bearer

	$JWT = $auth->getAuthToken(); //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
} catch (DookiValidationException $e) {
    // Erro de validação dos inputs
    
    // Mensagens de erros
    $errors = $e->getErrors();

} catch (DookiRequestException $e) {
	// Credenciais inválidas.
}
```

Caso você você já possua um JWT.

```php
require 'vendor/autoload.php';

use Dooki\Dooki;
use Dooki\DookiRequest;
use Dooki\DookiRequestException;

// Seu JWT.
$JWT = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...';

// Configure seu JWT, seu ambiente e faz o login por JWT.
$dooki = new Dooki($JWT, DookiRequest::sandbox());

// Configure sua loja...
```

Outra maneira de autenticação é pelo `token de usuário`:

```php
require 'vendor/autoload.php';

use Dooki\Dooki;
use Dooki\DookiRequest;

// Configure seu ambiente.
$dooki = new Dooki(DookiRequest::sandbox());

// Configure sua loja.
$dooki->setMerchant('aliasDeSuaLoja');

// Configure seu token de usuário.
$dooki->userToken('seuTokenDeUsuário');

try {
	// Requests...
} catch (DookiRequestException $e) {
	// Token de usuário inválido.
}
```

Uma vez autenticado, você já pode consumir a Dooki utilizando este SDK.

```php
require 'vendor/autoload.php';

use Dooki\Dooki;
use Dooki\DookiRequest;
use Dooki\Exceptions\DookiRequestException;
use Dooki\Exceptions\DookiValidationException;

// Busque seu JWT.
$jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...';

// Configure seu JWT, seu ambiente e sua loja.
$dooki = (new Dooki($jwt, DookiRequest::sandbox()))->setMerchant('aliasDeSuaLoja');

// Busca o catalogo de produtos da sua loja no Dooki.
$response = $dooki->request('GET', '/catalog/products');

$response->getData(); // array
```

Métodos que facilitam os recursos de pesquisa e filtros.

```php
require 'vendor/autoload.php';

use Dooki\Dooki;
use Dooki\DookiRequest;
use Dooki\DookiRequestException;

// Busque seu JWT.
$jwt = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...';

// Configure seu JWT, seu ambiente e sua loja.
$dooki = (new Dooki($jwt, DookiRequest::sandbox()))->setMerchant('aliasDeSuaLoja');

// Filtra por página.
$dooki->page(2);

// Filtra por qualquer campo e altera o formato de busca dos campos sendo filtrados (LIKE).
$dooki->search(['name' => 'Roupa de Cama']);
$dooki->searchFields(['name' => 'like']);

// Filtra por data de criação (created_at)...
$dooki->period('2018-01-01', '2018-01-31');
// ...ou por qualquer campo de data.
$dooki->period('any_date_field', '2018-01-01', '2018-01-31');

// Ordena por qualquer campos e altera a direção de orderação dos campos sendo ordenados.
$dooki->orderBy('name');
$dooki->sortedBy('desc');

// Altera o limite da paginação (máximo é 100).
$dooki->limit(20);

// Ignora o cache.
$dooki->skipCache();

// Retorna os produtos do catálogo com os filtros aplicados
$response = $dooki->request('GET', '/catalog/products');

$response->getData(); // array
```

### Paginação

```php
<?php

use Dooki\Dooki;

// ...

$response = $response->getData();
$pagination = $response->pagination();

$pagination->getTotal(); // Retorna o total de registros
$pagination->getPerPage(); // Retorna o total de registros por página
$pagination->getCurrentPage(); // Retorna a página atual
$pagination->getTotalPages(); // Retorna a quantidade total de páginas
$pagination->getNextLink(); // Retorna a URL da próxima página
$pagination->getPreviousLink(); // Retorna a URL da página anterior

```

## Change Log

Consulte [CHANGELOG](.github/CHANGELOG.md) para obter mais informações sobre o que mudou recentemente.

## Contribuições

Consulte [CONTRIBUTING](.github/CONTRIBUTING.md) para obter mais detalhes.

## Segurança

Se você descobrir quaisquer problemas relacionados à segurança, envie um e-mail para contato@bubbstore.com.br em vez de usar as issues.