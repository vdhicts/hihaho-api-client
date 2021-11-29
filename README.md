# HiHaHo API Client

Easy HiHaHo REST API client. 

Not all endpoints are currently implemented, feel free to add them or create an issue when you need help implementing 
the endpoint.

## Requirements

This package requires at least PHP 7.4 and uses Guzzle.

## Installation

This package can be used in any PHP project or with any framework.

You can install the package via composer:

`composer require vdhicts/hihaho-api-client`

## Usage

This package is just an easy client for using the HiHaHo API. Please refer to the
[API documentation](https://api-docs.hihaho.com/) for more information about the requests.

### Getting started

```php
// Initialize the configuration
$configuration = new \Vdhicts\HiHaHo\Configuration();

// Initialize the client
$client = new \Vdhicts\HiHaHo\Client($configuration);

// Get the videos
$response = (new \Vdhicts\HiHaHo\HiHaHoApi($client))
    ->video()
    ->all();

if ($response->isSuccess()) {
    $response->getData('data');
}
```

The `getData` method is able to use the dot notation. For example:

```php
$response = (new \Vdhicts\HiHaHo\HiHaHoApi($client))
    ->video()
    ->get(12345);
$response->getData('data.embed_url');
```

### Authentication

This package will automatically retrieve the access token, so you won't have to store the access token. If you want to 
store the access/refresh token anyway, you can access it in the `Configuration` class with: 
`$configuration->getAccessToken()` or `$configuration->getRefreshToken()`. 

### Handling errors

When an error occurs, a `Response` object is still returned. The error might be provided by HiHaHo or from the 
client but will always be accessible with the `getError` method.

```php
if (!$response->isSuccess()) {
    var_dump($response->getError());
}
```

### Laravel

This package can be easily used in any Laravel application. I would suggest adding your username and password to your
`.env` file:

```
HIHAHO_URL=url
HIHAHO_CLIENT_ID=clientid
HIHAHO_CLIENT_SECRET=secret
HIHAHO_USERNAME=username
HIHAHO_PASSWORD=password
```

Next create a config file `hihaho.php` in `/config`:

```php
<?php

return [
    'url' => env('HIHAHO_URL'),
    'client_id' => env('HIHAHO_CLIENT_ID'),
    'client_secret' => env('HIHAHO_CLIENT_SECRET'),
    'username' => env('HIHAHO_USERNAME'),
    'password' => env('HIHAHO_PASSWORD'),
];
```

And use those files to build the configuration:

```php
$configuration = new Configuration(
    config('hihaho.url'),
    config('hihaho.client_id'),
    config('hihaho.client_secret'),
    config('hihaho.username'),
    config('hihaho.password'),
);
```

In the future I might make a Laravel specific package which uses this package.

## Tests

Unit tests are available in the `tests` folder. Run with:

`composer test`

When you want a code coverage report which will be generated in the `build/report` folder. Run with:

`composer test-coverage`

## Contribution

Any contribution is welcome, but it should meet the PSR-12 standard and please create one pull request per feature/bug.
In exchange, you will be credited as contributor on this page.

## Security

If you discover any security related issues in this or other packages of Vdhicts, please email info@vdhicts.nl instead
of using the issue tracker.

## Support

This package isn't an official package from HiHaHo, so they probably won't offer support for it. If you encounter a
problem with this client or has a question about it, feel free to open an issue on GitHub.

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## About Vdhicts

[Vdhicts](https://www.vdhicts.nl) is the name of my personal company for which I work as freelancer. Vdhicts develops
and implements IT solutions for businesses and educational institutions.
