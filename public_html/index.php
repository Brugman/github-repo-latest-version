<?php

/**
 * Settings.
 */

$username = 'Brugman';

$repos_enabled = [
    // tags
    'acf-agency-workflow',
    // no tags yet
    'localhost-index',
    'domain-tool',
    'find-junk-html',
    'reset-post-permalink',
    'gist-list',
    'acf-copy-field-names',
];

/**
 * Functions.
 */

function d( $var = false )
{
    echo "<pre style=\"max-height:35vh;z-index:9999;position:relative;overflow-y:scroll;white-space:pre-wrap;word-wrap:break-word;padding:10px 15px;border:1px solid #fff;background-color:#161616;text-align:left;line-height:1.5;font-family:Courier;font-size:16px;color:#fff;\">";
    print_r( $var );
    echo "</pre>";
}

function dd( $var = false )
{
    d( $var );
    exit;
}

function bail( $msg = false )
{
    $data = [];

    if ( $msg )
        $data['error'] = $msg;

    header( 'Content-Type: application/json' );
    echo json_encode( $data );
    exit;
}

function get_valid_repo()
{
    if ( !isset( $_GET['repo'] ) )
        bail('no repo requested');

    $repo = trim( $_GET['repo'] );

    if ( !$repo )
        bail('no repo requested');

    global $repos_enabled;

    if ( !in_array( $repo, $repos_enabled ) )
        bail('requested repo is not whitelisted');

    return $repo;
}

function get_latest_version_details( $api_data )
{
    if ( !$api_data )
        bail('no version data available');

    if ( !isset( $api_data[0]['name'], $api_data[0]['zipball_url'], $api_data[0]['tarball_url'] ) )
        bail('version data in unknown format');

    return [
        'version' => str_replace( 'v', '', $api_data[0]['name'] ),
        'zip' => $api_data[0]['zipball_url'],
        'tar' => $api_data[0]['tarball_url'],
    ];
}

/**
 * Runtime.
 */

$repo = get_valid_repo();

require_once dirname( __DIR__ ).'/vendor/autoload.php';

$client = new \Github\Client();

$api_calls_remaining = $client->api('rate_limit')->getResource('core')->getRemaining();

if ( $api_calls_remaining == 0 )
    bail('external api rate limit reached');

$api_data = $client->api('repo')->tags( $username, $repo );

$details = get_latest_version_details( $api_data );

header( 'Content-Type: application/json' );
echo json_encode( $details );
exit;

// https://github.com/KnpLabs/php-github-api/blob/master/doc/