<?php

require_once __DIR__ . '/CloudFlareApiClass.php';

$github_owner = 'shyambaseapp';
$git_auth_key =  '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';
$path = '/home/shyam/Documents/WFH/alpha-master/';
$repo_name = 'alpha';
$repo_branch = 'master';
$git_comment = 'first';
$account_id = '8114ba045157bde928fececeea54e20a';
$X_Auth_Email = 'shyam.baseapp@gmail.com';
$X_Auth_Key = '44f3e5d3f277d7c73ccd4ea64c5c78358b367';
$project_name = 'betaalpha';
$domain = 'dzzled.com';

$cf = new CloudFlare();
// Create github repositories...
try {
    $cf->gitCreateRpo($github_owner, $git_auth_key, $repo_name);
    echo "repo created---";
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}

// Code push in repositories...
try {
    $cf->gitRepoPushCode($path, $github_owner, $repo_name, $repo_branch, $git_comment);
    echo "code pused---";
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}

// Create peges on cloudflare pages...
try {
    $cf->createCloudFlarePages($account_id, $X_Auth_Email, $X_Auth_Key, $repo_name, $github_owner, $domain, $project_name, $repo_branch);
    echo "page created----";
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}

// Deploy static pages on cloudflare...
try {
    $cf->deployCloudFlarePages($account_id, $X_Auth_Email, $X_Auth_Key, $project_name);
    echo "page deployed---";
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}

// Add domain on cloudflare...
try {
    $cf->addCloudFlareDomain($account_id, $X_Auth_Email, $X_Auth_Key, $domain);
    echo "domain added---";
} catch (Exception $e) {
    echo 'Message: ' . $e->getMessage();
}
