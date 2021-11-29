<?php

namespace Vdhicts\HiHaHo\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vdhicts\HiHaHo\Request;

class RequestTest extends TestCase
{
    public function testRequestDefaults()
    {
        $request = new Request();

        $this->assertSame(Request::METHOD_GET, $request->getMethod());
        $this->assertTrue($request->authenticationRequired());
    }

    public function testRequest()
    {
        $url = 'https://api.example.com/v1/';
        $requiresAuthentication = false;
        $method = Request::METHOD_POST;

        $request = (new Request())
            ->setUrl($url)
            ->setAuthenticationRequired($requiresAuthentication)
            ->setMethod($method)
            ->setBody(['foo' => 'bar']);

        $this->assertSame($url, $request->getUrl());
        $this->assertSame($requiresAuthentication, $request->authenticationRequired());
        $this->assertSame($method, $request->getMethod());
        $this->assertCount(1, $request->getBody());
    }
}
