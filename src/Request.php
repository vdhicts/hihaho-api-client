<?php

namespace Vdhicts\HiHaHo;

use Vdhicts\HiHaHo\Contracts\Request as RequestContract;

class Request implements RequestContract
{
    private string $method;
    private string $url;
    private array $body;
    private bool $requiresAuthentication = true;

    public function __construct(string $method = self::METHOD_GET, string $url = '', array $body = [])
    {
        $this->setMethod($method);
        $this->url = $url;
        $this->body = $body;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $availableMethods = [
            self::METHOD_GET,
            self::METHOD_POST,
            self::METHOD_PATCH,
            self::METHOD_PUT,
            self::METHOD_DELETE
        ];
        if (in_array($method, $availableMethods)) {
            $this->method = $method;
        }

        return $this;
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

    public function getBody(): array
    {
        return $this->body;
    }

    public function setBody(array $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function authenticationRequired(): bool
    {
        return $this->requiresAuthentication;
    }

    public function setAuthenticationRequired(bool $requiresAuthentication): self
    {
        $this->requiresAuthentication = $requiresAuthentication;

        return $this;
    }
}