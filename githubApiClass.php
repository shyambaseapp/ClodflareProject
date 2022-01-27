<?php

require_once __DIR__ . '/vendor/autoload.php';

class Github
{
     /**
      * Returns the domain name portion of the email address.
      *
      * @return string|null
      */
     function __construct($githubOwner, $gitAuthKey, $repoName, $repoBranch, $gitComment)
     {
          $this->githubOwner = $githubOwner;
          $this->gitAuthKey = $gitAuthKey;
          $this->repoName = $repoName;
          $this->repoBranch = $repoBranch;
          $this->gitComment = $gitComment;
     }

     /**
      * Create a repository on github using API.
      *
      * @return json
      */
     function gitCreateRepo()
     {
          try {
               $client = new \Github\Client();
               $repos = $client->api('user')->repositories($this->githubOwner);
               $client->authenticate($this->githubOwner, $this->gitAuthKey, "CLIENT_ID");
               $repo = $client->api('repo')->create($this->repoName, 'This is the description of a repo', true);
               return "repo created";
          } catch (Exception $e) {
               $error = 'Message: ' . $e->getMessage();
               return $error;
          }
     }

     /**
      * Push code/file in github repository using API.
      *
      * @return json|null
      */
     function gitRepoPushCode($path)
     {
          try {
               $git = new CzProject\GitPhp\Git;
               $repo = $git->init($path);
               $repo->addAllChanges();
               $repo->commit($this->gitComment);
               $repo->addRemote('origin', 'https://github.com/' . $this->githubOwner . '/' . $this->repoName . '.git');
               $repo->push('-u', ['origin', $this->repoBranch]);
               return "code pushed";
          } catch (Exception $e) {
               $error = 'Message: ' . $e->getMessage();
               return $error;
          }
     } 
}
