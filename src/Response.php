<?php

namespace Vdhicts\HiHaHo;

use Illuminate\Support\Arr;
use Vdhicts\HiHaHo\Contracts\Response as ResponseContract;

class Response implements ResponseContract
{
    private string $status;
    private ?array $data;
    private ?string $error = null;

    public function __construct(string $status = self::UNKNOWN, array $data = null)
    {
        $this->status = $status;
        $this->data = $data;
    }

    public function isSuccess(): bool
    {
        return $this->status === self::SUCCESS;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function setError(?string $error): self
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData(string $key = null)
    {
        if (is_null($key)) {
            return $this->data;
        }

        return Arr::get($this->data, $key);
    }
}