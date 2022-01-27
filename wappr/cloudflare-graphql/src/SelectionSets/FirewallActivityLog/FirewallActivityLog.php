<?php

namespace Wappr\Cloudflare\SelectionSets\FirewallActivityLog;

use Wappr\Cloudflare\Contracts\SelectionSetInterface;
use Wappr\Cloudflare\SelectionSets\AbstractSelectionSet;

class FirewallActivityLog extends AbstractSelectionSet implements SelectionSetInterface
{
    /**
     * Fields to get when running query.
     *
     * @var array<int, string>
     */
    protected $selectionSet = [
        'action',
        'clientASNDescription',
        'clientAsn',
        'clientCountryName',
        'clientIP',
        'clientIPClass',
        'clientRefererHost',
        'clientRefererPath',
        'clientRefererQuery',
        'clientRefererScheme',
        'clientRequestHTTPHost',
        'clientRequestHTTPMethodName',
        'clientRequestHTTPProtocol',
        'clientRequestPath',
        'clientRequestQuery',
        'clientRequestScheme',
        'datetime',

        /* Can't have more than 30 fields, so I commented these out. */
        // 'datetimeFifteenMinutes',
        // 'datetimeFiveMinutes',
        // 'datetimeHour',
        // 'datetimeMinute',

        'edgeColoName',
        'edgeResponseStatus',
        'kind',
        'matchIndex',

        /* metadata is an object and requires further dev. */
        // 'metadata',

        'originResponseStatus',
        'originatorRayName',
        'rayName',
        'ruleId',
        'sampleInterval',
        'source',
        'userAgent',
    ];

    /**
     * This selection returns an array.
     *
     * Most other selectionSets are a query, but this one isn't due to how the
     * Firewall Activity Log - Firewall Events Adaptive query is structured.
     * This data set doesn't group the results. So we don't need a query.
     *
     * @return array
     */
    public function getSelection()
    {
        return $this->selectionSet;
    }
}
