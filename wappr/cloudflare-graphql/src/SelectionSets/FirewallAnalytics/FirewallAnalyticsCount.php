<?php

namespace Wappr\Cloudflare\SelectionSets\FirewallAnalytics;

use GraphQL\Query;
use GraphQL\Exception\InvalidSelectionException;
use Wappr\Cloudflare\Contracts\SelectionSetInterface;
use Wappr\Cloudflare\SelectionSets\AbstractSelectionSet;

class FirewallAnalyticsCount extends AbstractSelectionSet implements SelectionSetInterface
{
    /**
     * Fields to get when running query.
     *
     * @var array<int, string>
     */
    protected $selectionSet = [
        'count',
    ];

    /**
     * @return GraphQL\Query
     *
     * @throws InvalidSelectionException
     */
    public function getSelection()
    {
        $query = new Query('count');
        $query->setSelectionSet($this->selectionSet);

        return $query;
    }
}
