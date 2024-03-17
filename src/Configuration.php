<?php

namespace Vdhicts\HiHaHo;

class Configuration
{
    private string $url = 'https://api.hihaho.com/';

    private string $clientId;

    private string $clientSecret;

    private string $username;

    private string $password;

    private ?string $accessToken = null;

    private ?string $refreshToken = null;

    public function __construct(string $clientId, string $clientSecret, string $username, string $password)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->username = $username;
        $this->password = $password;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function hasAccessToken(): bool
    {
        return ! is_null($this->accessToken);
    }

    public function setAccessToken(?string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function hasRefreshToken(): bool
    {
        return ! is_null($this->refreshToken);
    }

    public function setRefreshToken(?string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }
}
