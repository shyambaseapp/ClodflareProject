<?php

class CloudFlare
{

     function gitCreateRpo($github_owner, $git_auth_key, $repo_name)
     {
          require_once __DIR__ . '/vendor/autoload.php';
          // Creat a repositories....
          $client = new \Github\Client();
          $repos = $client->api('user')->repositories($github_owner);
          $client->authenticate($github_owner, $git_auth_key, "CLIENT_ID");
          $repo = $client->api('repo')->create($repo_name, 'This is the description of a repo', true);
     }

     function gitRepoPushCode($path, $github_owner, $repo_name, $repo_branch, $git_comment)
     {
          require_once __DIR__ . '/vendor/autoload.php';
          // code push in repositories...
          $git = new CzProject\GitPhp\Git;
          $repo = $git->init($path);
          $repo->addAllChanges();
          $repo->commit($git_comment);
          $repo->addRemote('origin', 'https://github.com/' . $github_owner . '/' . $repo_name . '.git');
          $repo->push('-u', ['origin', $repo_branch]);
     }

     function createCloudFlarePages($account_id, $X_Auth_Email, $X_Auth_Key, $repo_name, $github_owner, $domain, $project_name, $repo_branch)
     {
          $url = "https://api.cloudflare.com/client/v4/accounts/$account_id/pages/projects";
          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          $headers = array(
               "X-Auth-Email: $X_Auth_Email",
               "X-Auth-Key: $X_Auth_Key",
               "Content-Type: application/json",
          );
          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
          $data = '{   
                    "name":"' . $project_name . '",
                    "id":"7b162ea7-7367-4d67-bcde-1160995d5",
                    "created_on":"2017-01-01T00:00:00Z",
                    "subdomain":"' . $project_name . '.pages.dev",
                    "domains":["' . $domain . '"],
                    "source":{
                         "type":"github",
                         "config":{
                              "owner":"' . $github_owner . '",
                              "repo_name":"' . $repo_name . '",
                              "production_branch":"' . $repo_branch . '",
                              "pr_comments_enabled":true,
                              "deployments_enabled":true
                         }
                    }      
          }';
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          $resp = curl_exec($curl);
          curl_close($curl);
     }

     function deployCloudFlarePages($account_id, $X_Auth_Email, $X_Auth_Key, $project_name)
     {
          $url = "https://api.cloudflare.com/client/v4/accounts/$account_id/pages/projects/$project_name/deployments";
          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          $headers = array(
               "X-Auth-Email: $X_Auth_Email",
               "X-Auth-Key: $X_Auth_Key",
          );
          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
          $resp = curl_exec($curl);
          curl_close($curl);
     }

     function addCloudFlareDomain($account_id, $X_Auth_Email, $X_Auth_Key, $domain)
     {
          $url = "https://api.cloudflare.com/client/v4/zones";

          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          $headers = array(
               "X-Auth-Email: $X_Auth_Email",
               "X-Auth-Key: $X_Auth_Key",
               "Content-Type: application/json",
          );
          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
          $data = '{
                    "account": {
                          "id": "' . $account_id . '"
                    }, 
                    "name":"' . $domain . '",
                    "jump_start":true
          }';
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          $resp = curl_exec($curl);
          curl_close($curl);
     }

     function zoneAnalytics($X_Auth_Email, $X_Auth_Key, $zone_id)
     {
          $url = "https://api.cloudflare.com/client/v4/graphql-api";

          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_URL, $url);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          $headers = array(
               "X-Auth-Email: $X_Auth_Email",
               "X-Auth-Key: $X_Auth_Key",
               "Content-Type: application/json",
          );
          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
          $d = '{
               viewer {
                   zones(filter: { zoneTag:"'.$zone_id.'" }) {
                       httpRequests1dGroups(
                           orderBy: [date_ASC]
                           limit: 1000
                           filter: { date_gt: "2022-01-15" }
                       ) {
                           date: dimensions {
                               date
                           }
                          sum {
                     browserMap {
                       pageViews
                       uaBrowserFamily
                     }
                     bytes
                     cachedBytes
                     cachedRequests
                     contentTypeMap {
                       bytes
                       requests
                       edgeResponseContentTypeName
                     }
                     clientSSLMap {
                       requests
                       clientSSLProtocol
                     }
                     countryMap {
                       bytes
                       requests
                       threats
                       clientCountryName
                     }
                     encryptedBytes
                     encryptedRequests
                     ipClassMap {
                       requests
                       ipType
                     }
                     pageViews
                     requests
                     responseStatusMap {
                       requests
                       edgeResponseStatus
                     }
                     threats
                     threatPathingMap {
                       requests
                       threatPathingName
                     }
                   }
                   uniq {
                     uniques
                   }
                       }
                   }
               }
           }';
           $data = json_encode(['query' => $d]);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          $resp = curl_exec($curl);
          echo $resp;
          curl_close($curl);
     }
}


