<?php

namespace Vdhicts\HiHaHo\Tests\Unit;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use Vdhicts\HiHaHo\Configuration;
use Vdhicts\HiHaHo\HiHaHo;

class HiHaHoTest extends TestCase
{
    public function testRequest()
    {
        $videoId = rand(1000, 9999);
        $accessToken = Str::random();

        $configuration = new Configuration(
            Str::random(),
            Str::random(),
            Str::random(),
            Str::random()
        );
        $configuration->setAccessToken($accessToken);
        $client = new HiHaHo($configuration);
        $client->fake();
        $response = $client->getVideo($videoId);

        $this->assertTrue($response->ok());
        $client->assertSent(function (Request $request) use ($accessToken, $videoId) {
            return
                $request->hasHeader('Authorization', 'Bearer '.$accessToken) &&
                $request->hasHeader('Accept', 'application/json') &&
                $request->url() == 'https://api.hihaho.com/v2/video/'.$videoId;
        });
    }
}
