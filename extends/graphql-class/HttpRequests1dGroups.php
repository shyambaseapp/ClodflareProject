<?php 

use GraphQL\Query;
use GraphQL\RawObject;
use Wappr\Cloudflare\Contracts\DataSetInterface;
use Wappr\Cloudflare\Contracts\SelectionSetInterface;
use Wappr\Cloudflare\DataSets\HttpRequests\HttpRequests1dGroups;
/**
 * HTTP Requests.
 *
 * Node: httpRequests1dGroups
 *
 * @see https://developers.cloudflare.com/analytics/graphql-api/features/data-sets/
 */
class HttpRequests1dGroup extends HttpRequests1dGroups implements DataSetInterface
{
    protected $selectionSet = [];
    /**
     * @var \DateTime
     */
    protected $date_gt;
    protected $date_lt;

    /**
     * @var int
     */
    protected $limit;

    public function __construct(SelectionSetInterface $selectionSet, DateTime $date_gt, DateTime $date_lt, $limit)
    {
        $this->selectionSet[] = $selectionSet->getSelection();
        $this->date_gt = $date_gt;
        $this->date_lt = $date_lt;
        $this->limit = $limit;
    }

    public function getDataSet()
    {
        $query = new Query('httpRequests1dGroups');
        $query->setArguments([
            'limit'  => $this->limit,
            'filter' => new RawObject('{date_gt: "'.$this->date_gt->format('Y-m-d').'", date_lt: "'.$this->date_lt->format('Y-m-d').'"}'),
        ]);
        $query->setSelectionSet($this->selectionSet);
        return $query;
    }
     
   

}
