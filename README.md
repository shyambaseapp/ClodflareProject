# PHP CloudflareProject Library

## The PHP cloudflare library will used to create the following using cloudflare API :

### 1. To create github repository.
### 2. To push static site project on github repositories.
### 3. To create a cloudflare static page project on cloudflare account.
### 4. To deploy cloudflare static pages projects .
### 5. To add domains on cloudflare accounts.
### 6. To analyse the all function of zones/domains.

## Requirements :

### * PHP 7.2 or newer

## Installation :

### git clone https://github.com/shyambaseapp/ClodflareProject.git

## Create .env file :

### Create .env file on project root directory.

```ruby
 githubOwner = ownerName
 gitAuthKey  = ghp_UKCafhaifghafgk4byuTP4Cs
 path        = PathToStaticSite
 repoName    = alpha
 repoBranch  = master
 gitComment  = comments
 accountId   = 343d45646sd5646a5s4d54da6sd46
 xAuthEmail  = example@gmail.com
 xAuthKey    = 56465sa4fsaf564asf654fas645afa
 projectName = xyz
 domain      = xyz.com
 zoneId      = 54gawe4g4w6eg4654rewg4654564rg65
 date        = 2022-01-04                       
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
 $date = getenv('date');

 $gh = new Github($githubOwner, $gitAuthKey, $repoName, $repoBranch, $gitComment);
 $cf = new CloudFlare($githubOwner, $gitAuthKey, $repoName, $repoBranch, $gitComment, $xAuthEmail, $xAuthKey, $domain, $accountId, $projectName);
 $gh->gitCreateRepo();
 $gh->gitRepoPushCode($path);
 $cf->createCloudFlarePages();
 $cf->deployCloudFlarePages();
 $cf->addCloudFlareDomain();
 $cf->zoneAnalytics($zoneId, $limit, $date);

 ?>```
