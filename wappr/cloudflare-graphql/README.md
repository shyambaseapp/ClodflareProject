# Cloudflare GraphQL Analytics API Client

[![Build Status](https://travis-ci.org/wappr/cloudflare-graphql.svg?branch=master)](https://travis-ci.org/wappr/cloudflare-graphql)
[![codecov](https://codecov.io/gh/wappr/cloudflare-graphql/branch/master/graph/badge.svg)](https://codecov.io/gh/wappr/cloudflare-graphql)
[![GitHub license](https://img.shields.io/github/license/wappr/cloudflare-graphql)](https://github.com/wappr/cloudflare-graphql/blob/master/LICENSE)

## Docs

[https://wappr.net/api/cf-graph/](https://wappr.net/api/cf-graph/).

## Example

### Account

Using an Account request you can get account level aggregated data.

```php
<?php

use Wappr\Cloudflare\AnalyticsClient;
use Wappr\Cloudflare\Resources\Account;
use Wappr\Cloudflare\DataSets\HttpRequests\HttpRequests1dGroups;
use Wappr\Cloudflare\SelectionSets\HttpRequests\HttpRequestsSum;

require 'vendor/autoload.php';

$dataSet = new HttpRequestsSum();
$request = new HttpRequests1dGroups($dataSet, new DateTime('yesterday'), 10);

// Account IDs you can access.
$accounts = [
    'b03c6a7ae48351c6408e00c8159e6e64',
    'b03c6a7ae48351c6408e00c8159e6e64',
    'b03c6a7ae48351c6408e00c8159e6e64',
    'b03c6a7ae48351c6408e00c8159e6e64',
    'b03c6a7ae48351c6408e00c8159e6e64',
    'b03c6a7ae48351c6408e00c8159e6e64',
];

$threats = 0;

foreach ($accounts as $accountId) {
    $client  = new AnalyticsClient('accountemail@yourdomain.com', '03288863723b2ad76ef22646c064e93b');
    $account = new Account($request, $accountId);
    $client->addResource($account);
    $response = json_decode($client->runQuery());

    dump($response);

    $threats = $threats + $response->data->viewer->accounts[0]->httpRequests1dGroups[0]->sum->threats;
}

dump($threats);
```

### Zone

Using an Zone request you can get zone level data.

## Notes

* `vendor/bin/phpunit --coverage-html build`
* `php-cs-fixer fix`
