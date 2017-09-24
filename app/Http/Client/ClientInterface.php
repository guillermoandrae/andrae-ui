<?php

namespace App\Http\Client;

use GuzzleHttp\Client as GuzzleClient;

interface ClientInterface
{
    public function get(string $uri, array $options = []);

    public function getClient(): GuzzleClient;
}
