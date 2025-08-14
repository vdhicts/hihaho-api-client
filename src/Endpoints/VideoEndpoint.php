<?php

namespace Vdhicts\HiHaHo\Endpoints;

use Illuminate\Http\Client\Response;

trait VideoEndpoint
{
    public function allVideos(int $page = 1, ?int $videoContainerId = null, ?string $status = null): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->get('v2/video', array_filter([
                'page' => $page,
                'video_container_id' => $videoContainerId,
                'status' => $status,
            ]));
    }

    public function searchVideos(string $search, ?int $videoContainerId = null, ?string $status = null, int $page = 1): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->get('v2/video', array_filter([
                'q' => $search,
                'page' => $page,
                'video_container_id' => $videoContainerId,
                'status' => $status,
            ]));
    }

    public function getVideo(int $videoId): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->withUrlParameters([
                'video_id' => $videoId,
            ])
            ->get('v2/video/{video_id}');
    }

    public function getSubtitles(int $videoId): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->withUrlParameters([
                'video_id' => $videoId,
            ])
            ->get('v2/video/{video_id}/subtitles');
    }

    public function statistics(int $videoId): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->withUrlParameters([
                'video_id' => $videoId,
            ])
            ->get('v2/video/{video_id}/aggregated-statistics');
    }

    public function createPersonalAccessUrl(int $videoId, string $viewerUid, array $variables = []): Response
    {
        return $this
            ->withToken($this->getAccessToken())
            ->withUrlParameters([
                'video_id' => $videoId,
            ])
            ->post('v2/video/{video_id}/allowed_viewer_token', [
                'viewer_uid' => $viewerUid,
                'variables' => $variables,
            ]);
    }
}
