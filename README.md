# HiHaHo API Client

Easy HiHaHo REST API client. 

Not all endpoints are currently implemented, feel free to add them or create an issue when you need help implementing 
the endpoint. It's also possible to extend the client.

## Requirements

This package requires at least PHP 7.4.

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
$configuration = new \Vdhicts\HiHaHo\Configuration(
    ..
);

// Initialize the API
$api = new \Vdhicts\HiHaHo\HiHaHo($configuration);

// Get all videos
$response = $api->allVideos();

if ($response->ok()) {
    $response->json('data');
}
```

### Authentication

This package will automatically retrieve the access token, so you won't have to store the access token. If you want to 
store the access/refresh token anyway, you can access it in the `Configuration` class with: 
`$configuration->getAccessToken()` or `$configuration->getRefreshToken()`.

### Extending the client

You can extend the client and implement your own endpoints:

```php
class Video extends HiHaHo 
{
    public function updateVideo(int $videoId): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->put(sprintf('v2/video/%d', $videoId), [
                'status' => 0,
            ]);
    }    
}
```

### Handling errors

A `Response` object will always be returned. See 
[Error handling](https://laravel.com/docs/8.x/http-client#error-handling) of the Http Client.

```php
if ($response->failed()) {
    var_dump($response->serverError());
}
```

### Laravel

This package can be easily used in any Laravel application. I would suggest adding your credentials to the `.env` file 
of the project:

```
HIHAHO_CLIENT_ID=clientid
HIHAHO_CLIENT_SECRET=secret
HIHAHO_USERNAME=username
HIHAHO_PASSWORD=password
```

Next create a config file `hihaho.php` in `/config`:

```php
<?php

return [
    'client_id' => env('HIHAHO_CLIENT_ID'),
    'client_secret' => env('HIHAHO_CLIENT_SECRET'),
    'username' => env('HIHAHO_USERNAME'),
    'password' => env('HIHAHO_PASSWORD'),
];
```

And use those files to build the configuration:

```php
$configuration = new Configuration(
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
