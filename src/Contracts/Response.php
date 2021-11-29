<?php

namespace Vdhicts\HiHaHo\Contracts;

interface Response
{
    public const SUCCESS = 'success';
    public const ERROR = 'error';
    public const UNKNOWN = 'unknown';

    public function isSuccess(): bool;
    public function getError(): ?string;
    public function getData(string $key = null);
}