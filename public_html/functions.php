<?php

function d( $var = false )
{
    echo "<pre style=\"z-index:9999;position:relative;overflow-y:scroll;white-space:pre-wrap;word-wrap:break-word;padding:10px 15px;border:1px solid #fff;background-color:#161616;text-align:left;line-height:1.5;font-family:Courier;font-size:16px;color:#fff;\">";
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

function split_user_project( $repo )
{
    return explode( '/', $repo );
}

function get_latest_version_details( $api_data )
{
    if ( !$api_data )
        bail('no version data available');

    if ( !isset( $api_data[0]['name'], $api_data[0]['zipball_url'], $api_data[0]['tarball_url'] ) )
        bail('version data in unknown format');

    return [
        'version'   => str_replace( 'v', '', $api_data[0]['name'] ),
        'zip'       => $api_data[0]['zipball_url'],
        'tar'       => $api_data[0]['tarball_url'],
        'timestamp' => time(),
    ];
}

function cache_dir()
{
    return dirname( __DIR__ ).'/cache/';
}

function remove_slash( $string )
{
    return str_replace( '/', '---', $string );
}

function add_slash( $string )
{
    return str_replace( '---', '/', $string );
}

function cache_file_path( $repo )
{
    return cache_dir().remove_slash( $repo ).'.json';
}

function get_cached_data( $repo )
{
    $cache_file = cache_file_path( $repo );

    if ( file_exists( $cache_file ) )
        return json_decode( file_get_contents( $cache_file ), true );

    return false;
}

function update_cache_data( $repo, $data )
{
    $cache_file = cache_file_path( $repo );

    $fh = fopen( $cache_file, 'w' );
    fwrite( $fh, json_encode( $data ) );
    fclose( $fh );
}

function is_cache_fresh( $cache )
{
    if ( !$cache )
        return false;

    global $cache_duration;

    $age_seconds = time() - $cache['timestamp'];

    if ( $age_seconds < $cache_duration )
        return true;

    return false;
}

function output_json_exit( $data )
{
    header( 'Content-Type: application/json' );
    echo json_encode( $data );
    exit;
}

function list_cached_repos()
{
    return glob( cache_dir().'*.json' );
}

function get_repo_details( $cached_repos )
{
    $data = [];

    foreach ( $cached_repos as $cached_repo )
    {
        $details = json_decode( file_get_contents( $cached_repo ), true );
        $details['repo'] = basename( str_replace( '.json', '', $cached_repo ) );
        $details['fresh'] = is_cache_fresh( $details );

        $data[] = $details;
    }

    return $data;
}

