<?php

namespace Wappr\Cloudflare\SelectionSets\HttpRequests;

use GraphQL\Query;
use GraphQL\Exception\InvalidSelectionException;
use Wappr\Cloudflare\Contracts\SelectionSetInterface;
use Wappr\Cloudflare\SelectionSets\AbstractSelectionSet;

class HttpRequestsDimensions extends AbstractSelectionSet implements SelectionSetInterface
{
    /**
     * Fields to get when running query.
     *
     * @var array<int, string>
     */
    protected $selectionSet = [
        'date',
    ];

    /**
     * @return GraphQL\Query
     *
     * @throws InvalidSelectionException
     */
    public function getSelection()
    {
        $query = new Query('dimensions');
        $query->setSelectionSet($this->selectionSet);

        return $query;
    }
}
