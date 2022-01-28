<?php

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use Wappr\Cloudflare\AnalyticsClient;
use Wappr\Cloudflare\DataSets\HttpRequests\HttpRequests1dGroups;
use Wappr\Cloudflare\Resources\Zones;
use Wappr\Cloudflare\SelectionSets\HttpRequests\HttpRequestsSum;
use Wappr\Cloudflare\SelectionSets\HttpRequests\HttpRequestsAverage;
use Wappr\Cloudflare\SelectionSets\HttpRequests\HttpRequestsUnique;
use Wappr\Cloudflare\SelectionSets\HttpRequests\HttpRequestsDimensions;

class CloudFlare
{
     /**
      * Returns the domain name portion of the email address.
      *
      * @return string|null
      */
     function __construct($githubOwner, $gitAuthKey, $repoName, $repoBranch, $gitComment, $xAuthEmail, $xAuthKey, $domain, $accountId, $projectName)
     {
          $this->githubOwner = $githubOwner;
          $this->gitAuthKey = $gitAuthKey;
          $this->repoName = $repoName;
          $this->repoBranch = $repoBranch;
          $this->gitComment = $gitComment;
          $this->xAuthEmail = $xAuthEmail;
          $this->xAuthKey = $xAuthKey;
          $this->domain = $domain;
          $this->accountId = $accountId;
          $this->projectName = $projectName;
     }

     /**
      * Create clooudflare page on cloudflare using API.
      *
      * @return json|null
      */
     function createCloudFlarePages()
     {
          try {
               $url = "https://api.cloudflare.com/client/v4/accounts/$this->accountId/pages/projects";
               $data = array(
                    "name" => "$this->projectName",
                    "id" => "7b162ea7-7367-4d67-bcde-1160995d5",
                    "created_on" => "2017-01-01T00=>00=>00Z",
                    "subdomain" => "$this->projectName.pages.dev",
                    "domains" => "[$this->domain]",
                    "source" => array(
                         "type" => "github",
                         "config" => array(
                              "owner" => "$this->githubOwner",
                              "repo_name" => "$this->repoName",
                              "production_branch" => "$this->repoBranch",
                              "pr_comments_enabled" => true,
                              "deployments_enabled" => true
                         ),
                    ),
               );
               $client = new Client();
               $response = $client->request(
                    "POST",
                    $url,
                    array(
                         "headers" => [
                              "X-Auth-Email" => "$this->xAuthEmail",
                              "X-Auth-Key" => "$this->xAuthKey",
                              "Content-type" => "application/json"
                         ],
                         'json' => $data
                    )
               );
               return "page created";
          } catch (Exception $e) {
               $error =  'Message: ' . $e->getMessage();
               return $error;
          }
     }

     /**
      * Deploy cloudflare page(projects) on cloudflare.
      *
      * @return json|null
      */
     function deployCloudFlarePages()
     {
          try {
               $url = "https://api.cloudflare.com/client/v4/accounts/$this->accountId/pages/projects/$this->projectName/deployments";
               $client = new Client();
               $response = $client->request(
                    "POST",
                    $url,
                    array(
                         "headers" => [
                              "X-Auth-Email" => "$this->xAuthEmail",
                              "X-Auth-Key" => "$this->xAuthKey",
                         ]
                    )
               );

               return "page deployed";
          } catch (Exception $e) {
               $error = 'Message: ' . $e->getMessage();
               return $error;
          }
     }

     /**
      * Add domain on cloudflare.
      *
      * @return json|null
      */
     function addCloudFlareDomain()
     {
          try {
               $url = "https://api.cloudflare.com/client/v4/zones";
               $data = array(
                    "account" => array("id" => "$this->accountId"),
                    "name" => "$this->domain",
                    "jump_start" => true
               );
               $client = new Client();
               $response = $client->request(
                    "POST",
                    $url,
                    array(
                         "headers" => [
                              "X-Auth-Email" => "$this->xAuthEmail",
                              "X-Auth-Key" => "$this->xAuthKey",
                              "Content-type" => "application/json"
                         ],
                         'json' => $data
                    )
               );
               return "domain added";
          } catch (Exception $e) {
               $error = 'Message: ' . $e->getMessage();
               return $error;
          }
     }

     /**
      * Analyse cloudflare domain .
      *
      * @return object|true
      */
     function zoneAnalytics($zoneId, $limit, $date)
     {
          try {
               $dataSetSum = new HttpRequestsSum();
               $dataSetAverage = new HttpRequestsAverage();
               $dataSetUnique = new HttpRequestsUnique();
               $dataSetDimensions = new HttpRequestsDimensions();
               $dataSet = array($dataSetSum, $dataSetDimensions, $dataSetAverage, $dataSetUnique);
               foreach ($dataSet as $data) {
                    $request = new HttpRequests1dGroups($data, new DateTime($date), 100);
                    $client  = new AnalyticsClient($this->xAuthEmail, $this->xAuthKey);
                    $zone = new Zones($request, $zoneId);
                    $client->addResource($zone);
                    $response = json_decode($client->runQuery());

                    switch ($data) {
                         case $dataSetSum:
                              $result1 = $response->data->viewer->zones[0]->httpRequests1dGroups[0];
                              break;
                         case $dataSetAverage:
                              $result2 = $response->data->viewer->zones[0]->httpRequests1dGroups[0];
                              break;
                         case $dataSetUnique:
                              $result3 = $response->data->viewer->zones[0]->httpRequests1dGroups[0];
                              break;
                         case $dataSetDimensions:
                              $result4 = $response->data->viewer->zones[0]->httpRequests1dGroups[0];
                              break;
                         default:
                              echo "Invalid Conditions";
                    }
               }
               $result = (object) array_merge((array) $result1, (array) $result2, (array) $result3, (array) $result4);
               return $result;
          } catch (Exception $e) {
               $error = 'Message: ' . $e->getMessage();
               return $error;
          }
     }
}
