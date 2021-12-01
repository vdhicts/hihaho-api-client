<?php

namespace Vdhicts\HiHaHo\Endpoints;

use Illuminate\Http\Client\Response;

trait VideoEndpoint
{
    public function allVideos(): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->get('v2/video');
    }

    public function searchVideos(string $search): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->get('v2/video', ['q' => $search]);
    }

    public function getVideo(int $videoId): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->get(sprintf('v2/video/%d', $videoId));
    }

    public function statistics(int $videoId): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->get(sprintf('v2/video/%d/aggregated-statistics', $videoId));
    }

    public function createPersonalAccessUrl(int $videoId, string $viewerUid, array $variables = []): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->post(sprintf('v2/video/%d/allowed_viewer_token', $videoId), [
                'viewer_uid' => $viewerUid,
                'variables' => $variables,
            ]);
    }
}