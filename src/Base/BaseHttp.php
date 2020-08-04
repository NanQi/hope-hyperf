<?php


namespace NanQi\Hope\Base;

use Hyperf\Guzzle\ClientFactory;

class BaseHttp
{
    protected $client;

    public function __construct(ClientFactory $clientFactory)
    {
        $this->client = $clientFactory->create([]);
    }

    public function fallback()
    {
        return 'fallback';
    }
}