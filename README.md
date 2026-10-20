# Packagist API

[![Build status](https://github.com/KnpLabs/packagist-api/actions/workflows/test.yml/badge.svg)](https://github.com/KnpLabs/packagist-api/actions/workflows/test.yml)
[![Latest Stable Version](https://poser.pugx.org/knplabs/packagist-api/v/stable.svg)](https://packagist.org/packages/knplabs/packagist-api)
[![Total Downloads](https://poser.pugx.org/knplabs/packagist-api/downloads.svg)](https://packagist.org/packages/knplabs/packagist-api)

A simple, object oriented wrapper for the [Packagist API](https://packagist.org/apidoc).

## Requirements

- PHP 8.2 or later
- A [PSR-18](https://www.php-fig.org/psr/psr-18/) HTTP client and [PSR-17](https://www.php-fig.org/psr/psr-17/) factories

This package doesn't depend on a specific HTTP client. If your project doesn't have one yet,
[php-http/discovery](https://github.com/php-http/discovery) installs a well-known implementation
(such as `guzzlehttp/guzzle`) for you. To use a specific client, install it before this package:

```bash
composer require guzzlehttp/guzzle
```

### Older PHP versions

| PHP version | Package version |
| ----------- | --------------- |
| 8.2+        | `^3.0`          |
| 8.0, 8.1    | `~2.2.0`        |
| 7.4         | `~2.1.0`        |

## Installation

```bash
composer require knplabs/packagist-api
```

## Usage

```php
use Packagist\Api\Client;

$client = new Client();
```

### Search for packages

```php
foreach ($client->search('sylius') as $result) {
    echo $result->getName() . PHP_EOL;
}

// sylius/sylius
// sylius/resource-bundle
// sylius/grid-bundle
// ...
```

Each result is a `Packagist\Api\Result\Result`, with `getName()`, `getDescription()`, `getUrl()`,
`getRepository()`, `getDownloads()` and `getFavers()`.

Results can be filtered by `vendor`, `type` or `tags`:

```php
$client->search('cart', ['type' => 'symfony-bundle']);
```

By default all pages of results are fetched. Use `limit` to cap the number of pages:

```php
$client->search('sylius', limit: 2);
```

### Get package details

`get()` returns full package details, generated dynamically by the Packagist API. If you don't
need all the metadata, use [`getComposer()`](#get-composer-metadata) instead. It is cheaper for
Packagist to serve.

```php
$package = $client->get('sylius/sylius');

echo "{$package->getName()}: {$package->getDescription()}";

// sylius/sylius: E-Commerce platform for PHP, based on Symfony framework.
```

### Get Composer metadata

`getComposer()` uses Composer metadata, which is Packagist's preferred way of serving package
details, since responses are cached as static files. It lacks some of the metadata that `get()`
provides. See the [Packagist API documentation](https://packagist.org/apidoc) for details.

It returns an array of packages keyed by name, so select the one you asked for:

```php
$package = $client->getComposer('sylius/sylius')['sylius/sylius'];
$latest = $package->getVersions()[0];

echo "{$latest->getName()} {$latest->getVersion()}";

// sylius/sylius v2.3.1
```

`getComposer()` returns both tagged releases and dev branches. To fetch only one of them, use
`getComposerReleases()` or `getComposerBranches()`:

```php
$releases = $client->getComposerReleases('sylius/sylius');
$branches = $client->getComposerBranches('sylius/sylius');
```

### List all packages

```php
foreach ($client->all() as $name) {
    echo $name . PHP_EOL;
}

// 0.0.0/composer-include-files
// 0.0.0/laravel-env-shim
// ...
```

The list can be filtered by `type` or `vendor`:

```php
$client->all(['type' => 'library']);
$client->all(['vendor' => 'sylius']);
```

Request extra `fields` to get an array keyed by package name, instead of a list of names:

```php
$client->all([
    'vendor' => 'sylius',
    'fields' => ['abandoned', 'repository', 'type'],
]);

// [
//     'sylius/addressing' => [
//         'abandoned' => false,
//         'repository' => 'https://github.com/Sylius/Addressing',
//         'type' => 'library',
//     ],
//     ...
// ]
```

### Popular packages

```php
foreach ($client->popular(3) as $result) {
    echo $result->getName() . PHP_EOL;
}

// symfony/deprecation-contracts
// symfony/polyfill-mbstring
// psr/log
```

### Security advisories

Pass a list of package names to get known security advisories, keyed by package name:

```php
$advisories = $client->advisories(['monolog/monolog']);

foreach ($advisories['monolog/monolog'] ?? [] as $advisory) {
    echo "{$advisory->getTitle()} ({$advisory->getAffectedVersions()})" . PHP_EOL;
}
```

To only get advisories that affect the versions you use, pass versions as values and set
`filterByVersion`:

```php
$client->advisories(['monolog/monolog' => '1.8.1'], filterByVersion: true);

// Header injection in NativeMailerHandler (>=1.8.0,<1.12.0)
```

You can also only return advisories updated after a given Unix timestamp:

```php
$client->advisories(['monolog/monolog'], updatedSince: strtotime('2024-01-01'));
```

### Custom Packagist repository

```php
$client->setPackagistUrl('https://custom.packagist.site.org');

// Or in the constructor:
$client = new Client(packagistUrl: 'https://custom.packagist.site.org');
```

### Custom HTTP client

By default, `Client` auto-discovers whichever PSR-18 HTTP client and PSR-17 factories are
installed, via [php-http/discovery](https://github.com/php-http/discovery). To configure the
client yourself (middleware, timeouts, auth, etc.), pass your own PSR-18 client:

```php
use GuzzleHttp\Client as GuzzleClient;
use Packagist\Api\Client;

$client = new Client(new GuzzleClient(['timeout' => 5]));
```

Any PSR-18 implementation works, not only Guzzle.

More runnable examples are in the [`examples`](examples) directory.

## Errors

- `Packagist\Api\PackageNotFoundException` is thrown when the Packagist API returns a 404 response.
- `InvalidArgumentException` is thrown when the response from Packagist can't be parsed.

## License

`packagist-api` is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Maintainers

KNPLabs is looking for maintainers ([see why](https://knplabs.com/en/blog/news-for-our-foss-projects-maintenance)).

If you are interested, feel free to open a PR to ask to be added as a maintainer. We'll be glad
to hear from you!

This library is maintained by the following people (alphabetically sorted):

- [@robbieaverill](https://github.com/robbieaverill)
