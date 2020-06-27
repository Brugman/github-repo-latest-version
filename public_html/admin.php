<?php

date_default_timezone_set( 'Europe/Amsterdam' );

/**
 * Settings.
 */

$cache_duration = 60 * 60; // 1 hour

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

function cache_dir()
{
    return dirname( __DIR__ ).'/cache/';
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

function display_cached_repos( $cached_repos )
{
    echo '<p>The datetime is now: '.date('Y-m-d H:i').'</p>';
    echo '<ul>';
    foreach ( $cached_repos as $cached_repo )
    {
        echo '<li>';
        echo '<p><strong>'.$cached_repo['repo'].'</strong></p>';
        echo '<p><span>Version:</span> '.$cached_repo['version'].'</p>';
        echo '<p><span>Timestamp:</span> '.date( 'Y-m-d H:i', $cached_repo['timestamp'] ).'</p>';
        echo '<p><span>Fresh:</span>     '.( $cached_repo['fresh'] ? 'Yes' : 'No' ).'</p>';
        echo '</li>';
    }
    echo '</ul>';
}

/**
 * Runtime.
 */

$cached_repos = list_cached_repos();

$cached_repos = get_repo_details( $cached_repos );

display_cached_repos( $cached_repos );

?>
<style>
* {
    box-sizing: border-box;
}
body {
    font-family: Arial;
    background-color: #202020;
    color: #FFF;
    padding: 50px;
}
ul {
    margin-top: 50px;
    list-style-type: none;
    padding: 0;
    display: flex;
}
li {
    margin-right: 50px;
    margin-bottom: 50px;
    border: 1px solid #444;
    padding: 20px 30px;
}
span {
    /*display: inline-block;
    width: 40%;*/
}
</style>