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
class Account implements ResourceInterface
{
    /**
     * @var array<int, DataSetInterface>
     */
    protected $dataset = [];

    /**
     * @var string
     */
    protected $accountTag;

    public function __construct(DataSetInterface $dataset, $accountTag)
    {
        $this->dataset[]     = $dataset->getDataSet();
        $this->accountTag    = $accountTag;
    }

    /**
     * @return GraphQL\Query
     *
     * @throws ArgumentException
     * @throws InvalidSelectionException
     */
    public function getResource()
    {
        $query = new Query('accounts');
        $query->setArguments(['filter' => new RawObject('{accountTag: "'.$this->accountTag.'"}')]);
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
