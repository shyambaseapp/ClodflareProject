<?php

namespace Wappr\Cloudflare\SelectionSets\HttpRequests;

use GraphQL\Query;
use GraphQL\Exception\InvalidSelectionException;
use Wappr\Cloudflare\Contracts\SelectionSetInterface;
use Wappr\Cloudflare\SelectionSets\AbstractSelectionSet;

class HttpRequestsAverage extends AbstractSelectionSet implements SelectionSetInterface
{
    /**
     * Fields to get when running query.
     *
     * @var array<int, string>
     */
    protected $selectionSet = [
        'bytes',
    ];

    /**
     * @return GraphQL\Query
     *
     * @throws InvalidSelectionException
     */
    public function getSelection()
    {
        $query = new Query('avg');
        $query->setSelectionSet($this->selectionSet);

        return $query;
    }
}
