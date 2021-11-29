<?php

namespace Vdhicts\HiHaHo\Contracts;

interface Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_PUT = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    public function getMethod(): string;
    public function getUrl(): string;
    public function getBody(): array;
    public function authenticationRequired(): bool;
}