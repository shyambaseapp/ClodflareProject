<?php

use GraphQL\Client;

/**
 * Class MockClient.
 */
class MockClient extends Client
{
    /**
     * MockClient constructor.
     *
     * @param object $handler
     */
    public function __construct(string $endpointUrl, $handler, array $authorizationHeaders = [], array $httpOptions = [])
    {
        parent::__construct($endpointUrl, $authorizationHeaders, $httpOptions);
        $this->httpClient = new \GuzzleHttp\Client(['handler' => $handler]);
    }
}
