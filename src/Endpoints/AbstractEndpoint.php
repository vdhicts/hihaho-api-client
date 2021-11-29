<?php

namespace Vdhicts\HiHaHo\Endpoints;

use Vdhicts\HiHaHo\Client;

abstract class AbstractEndpoint
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}