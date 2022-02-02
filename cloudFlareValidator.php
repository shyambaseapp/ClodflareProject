<?php

use DevCoder\DotEnv;
require_once __DIR__ . '/envClass.php';
require_once __DIR__ . '/cloudflareApiClass.php';
require_once __DIR__ . '/githubApiClass.php';
(new DotEnv(__DIR__ . '/.env'))->load();

$githubOwner = getenv('githubOwner');
$gitAuthKey = getenv('gitAuthKey');
$path = getenv('path');
$repoName = getenv('repoName');
$repoBranch = getenv('repoBranch');
$gitComment = getenv('gitComment');
$accountId = getenv('accountId');
$xAuthEmail = getenv('xAuthEmail');
$xAuthKey = getenv('xAuthKey');
$projectName = getenv('projectName');
$domain = getenv('domain');
$zoneId = getenv('zoneId');
$date_gt = getenv('date_gt');
$date_lt = getenv('date_lt');

$gh = new Github($githubOwner, $gitAuthKey, $repoName, $repoBranch, $gitComment);
$cf = new CloudFlare($githubOwner, $gitAuthKey, $repoName, $repoBranch, $gitComment, $xAuthEmail, $xAuthKey, $domain, $accountId, $projectName);
/*
*Create github repositories...
*/

$res = $gh->gitCreateRepo();

echo $res . "\r\n";

/*
* Code push in repositories...
*/

$res = $gh->gitRepoPushCode($path);
echo $res . "\r\n";

/*
* Create peges on cloudflare pages... 
*/

$res = $cf->createCloudFlarePages();
echo $res . "\r\n";

/*
*  Deploy static pages on cloudflare...
*/

$res = $cf->deployCloudFlarePages();
echo $res . "\r\n";

/*
* Add domain on cloudflare....
*/

$res = $cf->addCloudFlareDomain();

echo $res;
echo "\r\n";

$res = $cf->zoneAnalytics($zoneId, $date_gt, $date_lt);
print_r($res);
echo "\r\n";
