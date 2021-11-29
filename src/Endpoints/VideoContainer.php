<?php

namespace Vdhicts\HiHaHo\Endpoints;

use Vdhicts\HiHaHo\Contracts\Response;
use Vdhicts\HiHaHo\Request;

class VideoContainer extends AbstractEndpoint
{
    public function transcodingStatuses(int $videoId): Response
    {
        $request = (new Request())->setUrl(sprintf('v2/video-container/%d/upload-video', $videoId));

        return $this
            ->client
            ->perform($request);
    }
}