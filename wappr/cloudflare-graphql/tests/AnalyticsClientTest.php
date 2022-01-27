<?php

declare(strict_types=1);

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use Wappr\Cloudflare\AnalyticsClient;
use Wappr\Cloudflare\Resources\Zones;
use Wappr\Cloudflare\DataSets\HttpRequests\HttpRequests1dGroups;
use Wappr\Cloudflare\SelectionSets\HttpRequests\HttpRequestsAverage;

final class AnalyticsClientTest extends TestCase
{
    public function testAnalyticsClientConstruct(): void
    {
        $this->assertInstanceOf(AnalyticsClient::class, new AnalyticsClient('email', 'key'));
    }

    public function testAnalyticsClientRunQueryWithoutResource(): void
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Must add a resource before calling "runQuery()"');

        (new AnalyticsClient('email', 'key'))->runQuery();
    }

    public function testAnalyticsClientAddResource(): void
    {
        $client = new AnalyticsClient('email', 'key');
        $client->addResource(
            new Zones(
                new HttpRequests1dGroups(
                    new HttpRequestsAverage(),
                    new \DateTime('now'),
                    10
                ), ''
            )
        );

        $this->assertInstanceOf(AnalyticsClient::class, $client);
    }

    public function testAnalyticsClientRunQueryReturnsString(): void
    {
        $mockHandler = new MockHandler();
        $mockHandler->append(new Response(200, [], json_encode([
            'data' => [
                'someData',
            ],
        ])));

        $handler         = HandlerStack::create($mockHandler);
        $mockClient      = new MockClient('', $handler);

        $client = new AnalyticsClient('email', 'key');
        $client->addResource(
            new Zones(
                new HttpRequests1dGroups(
                    new HttpRequestsAverage(),
                    new \DateTime('now'),
                    10
                ), ''
            )
        );
        $client->setClient($mockClient);

        $this->assertIsString($client->runQuery());
    }
}
