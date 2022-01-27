<?php

namespace Wappr\Cloudflare\DataSets\FirewallAnalytics;

use DateTime;
use GraphQL\Query;
use GraphQL\RawObject;
use GraphQL\Exception\ArgumentException;
use GraphQL\Exception\InvalidSelectionException;
use Wappr\Cloudflare\Contracts\DataSetInterface;
use Wappr\Cloudflare\Contracts\SelectionSetInterface;

/**
 * Firewall Analytics.
 *
 * Node: firewallEventsAdaptiveGroups
 *
 * @see https://developers.cloudflare.com/analytics/graphql-api/features/data-sets/
 */
class FirewallEventsAdaptiveGroups implements DataSetInterface
{
    /**
     * An array of SelectionSetInterface.
     *
     * @var array<int, SelectionSetInterface>
     */
    protected $selectionSet = [];

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var int
     */
    protected $limit;

    public function __construct(SelectionSetInterface $selectionSet, DateTime $date, $limit)
    {
        $this->selectionSet[] = $selectionSet->getSelection();

        $this->date  = $date;
        $this->limit = $limit;
    }

    /**
     * @return GraphQL\Query
     *
     * @throws ArgumentException
     * @throws InvalidSelectionException
     */
    public function getDataSet()
    {
        $query = new Query('firewallEventsAdaptiveGroups');
        $query->setArguments([
            'limit'  => $this->limit,
            'filter' => new RawObject('{datetime: "'.$this->date->format(DateTime::ATOM).'"}'),
        ]);

        $query->setSelectionSet($this->selectionSet);

        return $query;
    }

    /**
     * @return $this
     */
    public function addSelectionSet(SelectionSetInterface $selectionSet)
    {
        $this->selectionSet[] = $selectionSet->getSelection();

        return $this;
    }
}
