<?php

namespace Test\Http\Controllers;

class PostControllerTest extends \TestCase
{
    public function testIndex()
    {
        $this->setMockGuzzleClient('single-post');
        $response = $this->call('GET', '/post/1');
        self::assertContains('environment variables', $response->content());
    }

    public function test404()
    {
        $this->setMockGuzzleClient('empty');
        $response = $this->call('GET', '/post/1');
        self::assertEquals(404, $response->status());
    }
}
