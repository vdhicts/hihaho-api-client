<?php

namespace Vdhicts\HiHaHo\Tests\Unit;

use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Vdhicts\HiHaHo\Configuration;

class ConfigurationTest extends TestCase
{
    public function test_initialisation()
    {
        $clientId = 'ClientId';
        $clientSecret = 'ClientSecret';
        $username = 'test@example.com';
        $password = 'VeryLongButNotSoComplicatedPassword';

        $configuration = new Configuration($clientId, $clientSecret, $username, $password);

        $this->assertSame($clientId, $configuration->getClientId());
        $this->assertSame($clientSecret, $configuration->getClientSecret());
        $this->assertSame($username, $configuration->getUsername());
        $this->assertSame($password, $configuration->getPassword());
        $this->assertFalse($configuration->hasAccessToken());
        $this->assertFalse($configuration->hasRefreshToken());
    }

    public function test_providing_tokens()
    {
        $configuration = new Configuration(
            'ClientId',
            'ClientSecret',
            'test@example.com',
            'VeryLongButNotSoComplicatedPassword'
        );

        $accessToken = Str::random(32);
        $refreshToken = Str::random(32);
        $configuration
            ->setAccessToken($accessToken)
            ->setRefreshToken($refreshToken);

        $this->assertSame($accessToken, $configuration->getAccessToken());
        $this->assertSame($refreshToken, $configuration->getRefreshToken());
    }

    public function test_providing_url()
    {
        $configuration = new Configuration(
            'ClientId',
            'ClientSecret',
            'test@example.com',
            'VeryLongButNotSoComplicatedPassword'
        );

        $url = 'https://api.example.com/v1/';

        $configuration->setUrl($url);

        $this->assertSame($url, $configuration->getUrl());
    }
}
