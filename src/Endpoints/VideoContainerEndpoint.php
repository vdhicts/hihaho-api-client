<?php

namespace Vdhicts\HiHaHo\Endpoints;

use Illuminate\Http\Client\Response;

trait VideoContainerEndpoint
{
    public function transcodingStatuses(int $videoId): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->withUrlParameters([
                'video_id' => $videoId,
            ])
            ->get('v2/video-container/{video_id}/upload-video');
    }
}
