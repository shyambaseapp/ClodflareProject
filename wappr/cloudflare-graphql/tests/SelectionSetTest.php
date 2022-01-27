<?php

declare(strict_types=1);

use GraphQL\Query;
use PHPUnit\Framework\TestCase;
use Wappr\Cloudflare\Contracts\SelectionSetInterface;
use Wappr\Cloudflare\SelectionSets\AbstractSelectionSet;
use Wappr\Cloudflare\SelectionSets\HttpRequests\HttpRequestsAverage;
use Wappr\Cloudflare\SelectionSets\FirewallActivityLog\FirewallActivityLog;
use Wappr\Cloudflare\SelectionSets\FirewallAnalytics\FirewallAnalyticsCount;
use Wappr\Cloudflare\SelectionSets\FirewallAnalytics\FirewallAnalyticsAverage;

final class SelectionSetTest extends TestCase
{
    //
    // HttpRequests
    //

    // Average - getSelection returns Query
    public function testHttpRequestsAverageGetSelectionReturnsQuery(): void
    {
        $this->assertInstanceOf(Query::class, (new HttpRequestsAverage())->getSelection());
    }

    // Average - implements SelectionSetInterface
    public function testHttpRequestsAverageImplementsSelectionSetInterface(): void
    {
        $this->assertInstanceOf(SelectionSetInterface::class, new HttpRequestsAverage());
    }

    // Average - extends AbstractSelectionSet
    public function testHttpRequestsAverageExtendsAbstractSelectionSet(): void
    {
        $this->assertInstanceOf(AbstractSelectionSet::class, new HttpRequestsAverage());
    }

    //
    // FirewallAnalytics
    //

    // Count - getSelection returns Query
    public function testFirewallAnalyticsGetSelectionReturnsQuery(): void
    {
        $this->assertInstanceOf(Query::class, (new FirewallAnalyticsCount())->getSelection());
    }

    // Count - implements SelectionSetInterface
    public function testFirewallAnalyticsGetSelectionSelectionSetInterface(): void
    {
        $this->assertInstanceOf(SelectionSetInterface::class, new FirewallAnalyticsCount());
    }

    // Count - extends AbstractSelectionSet
    public function testFirewallAnalyticsCountExtendsAbstractSelectionSet(): void
    {
        $this->assertInstanceOf(AbstractSelectionSet::class, new FirewallAnalyticsCount());
    }

    // Average
    public function testFirewallAnalyticsAverageGetSelectionReturnsQuery(): void
    {
        $this->assertInstanceOf(Query::class, (new FirewallAnalyticsAverage())->getSelection());
    }

    //
    // FirewallActivityLog
    //

    // FirewallActivityLog
    public function testFirewallActivityLogGetSelectionReturnsQuery(): void
    {
        $this->assertIsArray((new FirewallActivityLog())->getSelection());
    }
}
