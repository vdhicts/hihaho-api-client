<?php

namespace Vdhicts\HiHaHo\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vdhicts\HiHaHo\Response;

class ResponseTest extends TestCase
{
    public function testSuccessResponse()
    {
        $response = new Response(Response::SUCCESS, ['data' => ['status' => 'ok']]);

        $this->assertTrue($response->isSuccess());
        $this->assertArrayHasKey('data', $response->getData());
        $this->assertArrayHasKey('status', $response->getData('data'));
        $this->assertSame('ok', $response->getData('data.status'));
        $this->assertNull($response->getData('foo'));
    }

    public function testErrorResponse()
    {
        $error = 'This is not OK';
        $response = (new Response(Response::ERROR))->setError($error);

        $this->assertFalse($response->isSuccess());
        $this->assertSame($error, $response->getError());
        $this->assertNull($response->getData());
    }
}
