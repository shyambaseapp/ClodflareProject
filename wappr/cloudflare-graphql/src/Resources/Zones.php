<?php

namespace Wappr\Cloudflare\Resources;

use GraphQL\Query;
use GraphQL\RawObject;
use GraphQL\Exception\ArgumentException;
use GraphQL\Exception\InvalidSelectionException;
use Wappr\Cloudflare\Contracts\DataSetInterface;
use Wappr\Cloudflare\Contracts\ResourceInterface;

/**
 * @see https://developers.cloudflare.com/analytics/graphql-api/features/filtering/
 */
class Zones implements ResourceInterface
{
    /**
     * @var array<int, DataSetInterface>
     */
    protected $dataset = [];

    /**
     * @var string
     */
    protected $zoneid;

    public function __construct(DataSetInterface $dataset, $zoneid)
    {
        $this->dataset[] = $dataset->getDataSet();
        $this->zoneid    = $zoneid;
    }

    /**
     * Create and return a GraphQL Query.
     *
     * @return GraphQL\Query
     *
     * @throws ArgumentException
     * @throws InvalidSelectionException
     */
    public function getResource()
    {
        $query = new Query('zones');
        $query->setArguments(['filter' => new RawObject('{zoneTag: "'.$this->zoneid.'"}')]);
        $query->setSelectionSet($this->dataset);

        return $query;
    }

    /**
     * @return void
     */
    public function addDataSet(DataSetInterface $dataset)
    {
        $this->dataset[] = $dataset->getDataSet();
    }
}
