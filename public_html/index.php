<?php

if ( !file_exists('config.php') )
    exit( 'config.php not found' );

include 'config.php';
include 'functions.php';

// autoloader
$composer_autoloader = dirname( __DIR__ ).'/vendor/autoload.php';
if ( !file_exists( $composer_autoloader ) )
    bail('composer autoloader not available');

require_once $composer_autoloader;

$repo = get_valid_repo();

$cache = get_cached_data( $repo );

$is_cache_fresh = is_cache_fresh( $cache );

if ( $is_cache_fresh )
    output_json_exit( $cache );

// prep api (https://github.com/KnpLabs/php-github-api)
$client = new \Github\Client();

// check rate limit is good
$api_calls_remaining = $client->api('rate_limit')->getResource('core')->getRemaining();

if ( $api_calls_remaining == 0 )
    bail('GitHub rate limit reached');

[ $username, $project ] = split_user_project( $repo );

// get data
$api_data = $client->api('repo')->tags( $username, $project );

$details = get_latest_version_details( $api_data );

update_cache_data( $repo, $details );

output_json_exit( $details );

