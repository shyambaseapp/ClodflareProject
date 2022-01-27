<?php

namespace Wappr\Cloudflare;

use Exception;
use GraphQL\Query;
use GraphQL\Client;
use GraphQL\Exception\InvalidSelectionException;
use Wappr\Cloudflare\Contracts\ResourceInterface;

class AnalyticsClient
{
    /**
     * @var GraphQL\Client;
     */
    protected $client;

    /**
     * @var array<int, ResourceInterface>
     */
    protected $resources = [];

    public function __construct($email, $key)
    {
        $this->client = new Client(
            'https://api.cloudflare.com/client/v4/graphql',
            [],
            [
                'headers' => [
                    'X-AUTH-EMAIL' => $email,
                    'X-AUTH-KEY'   => $key,
                ],
            ]
        );
    }

    /**
     * @return $this
     */
    public function addResource(ResourceInterface $resource)
    {
        $this->resources[] = $resource->getResource();

        return $this;
    }

    /**
     * @return mixed
     *
     * @throws Exception
     * @throws InvalidSelectionException
     */
    public function runQuery()
    {
        // I'm not sure if this is a good idea, or good practice, or if I should
        // handle it another way. I like the idea of being able to add as many
        // resources and run them in the same query.
        if (!$this->resources) {
            throw new \Exception('Must add a resource before calling "runQuery()"');
        }

        $gql = (new Query('viewer'))->setSelectionSet($this->resources);

        return $this->client->runQuery($gql)->getResponseBody();
    }

    /**
     * @return void
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}
