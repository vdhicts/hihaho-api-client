<?php

namespace Vdhicts\HiHaHo\Endpoints;

use Illuminate\Http\Client\Response;

trait VideoContainerEndpoint
{
    public function transcodingStatuses(int $videoId): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->get(sprintf('v2/video-container/%d/upload-video', $videoId));
    }
}