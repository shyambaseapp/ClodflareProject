<?php

namespace Wappr\Cloudflare\DataSets\FirewallActivityLog;

use DateTime;
use GraphQL\Query;
use GraphQL\RawObject;
use GraphQL\Exception\ArgumentException;
use GraphQL\Exception\InvalidSelectionException;
use Wappr\Cloudflare\Contracts\DataSetInterface;
use Wappr\Cloudflare\Contracts\SelectionSetInterface;

/**
 * Firewall Activity Log.
 *
 * Node: firewallEventsAdaptive
 *
 * @see https://developers.cloudflare.com/analytics/graphql-api/features/data-sets/
 */
class FirewallEventsAdaptive implements DataSetInterface
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

    protected $filter;

    /**
     * FirewallEventsAdaptive DataSet.
     *
     * @todo update the construct parameters.
     */
    public function __construct(SelectionSetInterface $selectionSet, DateTime $date, $filter, $limit)
    {
        $this->addSelectionSet($selectionSet);

        $this->date  = $date;
        $this->limit = $limit;
        $this->filter = $filter;
    }

    /**
     * Creates a GraphQL Query from the properties of this class, and returns it.
     *
     * @return GraphQL\Query
     *
     * @throws ArgumentException
     * @throws InvalidSelectionException
     */
    public function getDataSet()
    {
        $query = new Query('firewallEventsAdaptive');
        $query->setArguments([
            'limit'  => $this->limit,
            // @TODO - need a way to create these raw filters with all the possible variations.
            'filter' => new RawObject($this->filter),
        ]);

        $query->setSelectionSet($this->selectionSet);

        return $query;
    }

    /**
     * Append a SelectionSetInterface to the selectionSet array.
     *
     * @return $this
     */
    public function addSelectionSet(SelectionSetInterface $selectionSet)
    {
        if (is_array($selectionSet->getSelection())) {
            $this->selectionSet = $selectionSet->getSelection();

            return $this;
        }

        $this->selectionSet[] = $selectionSet->getSelection();

        return $this;
    }
}
