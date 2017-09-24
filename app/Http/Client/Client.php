<?php

namespace App\Http\Client;

use App\Concerns\GuzzleClientAwareTrait;

class Client implements ClientInterface
{
    use GuzzleClientAwareTrait;

    public function get(string $uri, array $options = [])
    {
        $response = $this->getClient()->get($uri, $options);
        $body = json_decode($response->getBody()->getContents(), true);
        if (isset($body['data'])) {
            return $body['data'];
        }
        return [];
    }
}
