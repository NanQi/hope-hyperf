<?php


namespace NanQi\Hope\Base;

use Hyperf\Guzzle\ClientFactory;
use NanQi\Hope\Helper;

class BaseHttp
{
    use Helper;

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