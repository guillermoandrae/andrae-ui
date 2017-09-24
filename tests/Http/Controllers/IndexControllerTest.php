<?php

namespace Test\Http\Controllers;

class IndexControllerTest extends \TestCase
{
    public function testIndex()
    {
        $this->setMockGuzzleClient('latest-post');
        $response = $this->call('GET', '/');
        self::assertContains('following places', $response->content());
    }
}
