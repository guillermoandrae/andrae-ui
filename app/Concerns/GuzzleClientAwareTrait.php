<?php

namespace App\Concerns;

use GuzzleHttp\Client;

trait GuzzleClientAwareTrait
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * GuzzleClientAwareTrait constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client
     */
    final public function getClient(): Client
    {
        return $this->client;
    }
}
