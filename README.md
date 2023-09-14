# PHP CloudflareProject Library

## The PHP cloudflare library will used to create the following using cloudflare API :

> 1. To create github repository.
> 2. To push static site project on github repositories.
> 3. To create a cloudflare static page project on cloudflare account.
> 4. To deploy cloudflare static pages projects .
> 5. To add domains on cloudflare accounts.
> 6. To analyze the all function of zones/domains.

## Requirements :

> * PHP 7.2 or newer

## Installation :

> 1. source code : git clone https://github.com/shyambaseapp/ClodflareProject.git.
> 2. update composer to install all dependency and library.
> 3. command : composer update

## Create .env file :

### Create .env file on project root directory.

```ruby
 githubOwner = ownerName
 gitAuthKey  = 
 path        = PathToStaticSite
 repoName    = alpha
 repoBranch  = master
 gitComment  = comments
 accountId   = 
 xAuthEmail  = example@gmail.com
 xAuthKey    = 
 projectName = xyz
 domain      = xyz.com
 zoneId      = 
 date_gt = 2022-01-04
 date_lt = 2022-01-21
                      
```

##  Store git credential on local computer :
###  1. store credentials to Git Credential Storage fallow the given link:

###   *  https://help.github.com/articles/caching-your-github-password-in-git/


## Example :

 ```ruby
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
 $gh->gitCreateRepo();
 $gh->gitRepoPushCode($path);
 $cf->createCloudFlarePages();
 $cf->deployCloudFlarePages();
 $cf->addCloudFlareDomain();
 $cf->zoneAnalytics($zoneId, $limit, $date_gt, $date_lt);

 ?>
```
