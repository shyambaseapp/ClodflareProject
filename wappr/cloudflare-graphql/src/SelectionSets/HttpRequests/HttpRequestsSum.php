<?php

namespace Wappr\Cloudflare\SelectionSets\HttpRequests;

use GraphQL\Query;
use GraphQL\Exception\InvalidSelectionException;
use Wappr\Cloudflare\Contracts\SelectionSetInterface;
use Wappr\Cloudflare\SelectionSets\AbstractSelectionSet;

class HttpRequestsSum extends AbstractSelectionSet implements SelectionSetInterface
{
    /**
     * Fields to get when running query.
     *
     * @var array<int, string>
     */
    protected $selectionSet = [
        'pageViews',
        'requests',
        'threats',
        'bytes',
        'cachedBytes',
        'cachedRequests',
        'encryptedBytes',
        'encryptedRequests',
        'countryMap {
             bytes
             requests
             threats
             clientCountryName
        }',
        'ipClassMap {
             requests
             ipType
        }',
        'contentTypeMap {
             bytes
             requests
             edgeResponseContentTypeName
        }',
        'browserMap {
             pageViews
             uaBrowserFamily
        }',
        'threatPathingMap {
            requests
            threatPathingName
        }',
        ' responseStatusMap {
            requests
            edgeResponseStatus
        }',
        ' clientSSLMap {
            requests
            clientSSLProtocol
        }',
      
    ];

    /**
     * @return GraphQL\Query
     *
     * @throws InvalidSelectionException
     */
    public function getSelection()
    {
        $query = new Query('sum');
        $query->setSelectionSet($this->selectionSet);

        return $query;
    }
}
