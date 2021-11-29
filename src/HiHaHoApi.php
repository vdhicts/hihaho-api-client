<?php

namespace Vdhicts\HiHaHo;

use Vdhicts\HiHaHo\Endpoints\Video;
use Vdhicts\HiHaHo\Endpoints\VideoContainer;

class HiHaHoApi
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function video(): Video
    {
        return new Video($this->client);
    }

    public function videoContainer(): VideoContainer
    {
        return new VideoContainer($this->client);
    }
}