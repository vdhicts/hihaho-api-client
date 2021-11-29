<?php

namespace Vdhicts\HiHaHo\Endpoints;

use Vdhicts\HiHaHo\Contracts\Response;
use Vdhicts\HiHaHo\Request;

class Video extends AbstractEndpoint
{
    public function all(): Response
    {
        $request = (new Request())->setUrl('v2/video');

        return $this
            ->client
            ->perform($request);
    }

    public function search(string $search): Response
    {
        $request = (new Request())->setUrl('v2/video')->setBody(['q' => $search]);

        return $this
            ->client
            ->perform($request);
    }

    public function get(int $videoId): Response
    {
        $request = (new Request())->setUrl(sprintf('v2/video/%d', $videoId));

        return $this
            ->client
            ->perform($request);
    }

    public function statistics(int $videoId): Response
    {
        $request = (new Request())->setUrl(sprintf('v2/video/%d/aggregated-statistics', $videoId));

        return $this
            ->client
            ->perform($request);
    }

    public function createPersonalAccessUrl(int $videoId, string $viewerUid, array $variables = []): Response
    {
        $request = (new Request(Request::METHOD_POST))
            ->setUrl(sprintf('v2/video/%d/allowed_viewer_token', $videoId))
            ->setBody([
                'viewer_uid' => $viewerUid,
                'variables' => $variables,
            ]);

        return $this
            ->client
            ->perform($request);
    }
}