<?php

if ( !file_exists('config.php') )
    exit( 'config.php not found' );

include 'config.php';
include 'functions.php';

$cached_repos = list_cached_repos();

$cached_repos = get_repo_details( $cached_repos );

?>
<!DOCTYPE html>
<html>
<head>

    <!-- meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <!-- title -->
    <title>GitHub Repo Latest Version - Admin</title>

    <!-- link css -->
    <link rel="stylesheet" href="admin.css">

</head>
<body>

    <p>The datetime is now: <?=date('Y-m-d H:i');?></p>

<?php if ( !empty( $cached_repos ) ): ?>
    <ul>
<?php foreach ( $cached_repos as $repo ): ?>
        <li>
            <p><strong><?=$repo['repo'];?></strong></p>
            <p>Version: <?=$repo['version'];?></p>
            <p>Timestamp: <?=date( 'Y-m-d H:i', $repo['timestamp'] );?></p>
            <p>Fresh: <?=( $repo['fresh'] ? 'Yes' : 'No' );?></p>
        </li>
<?php endforeach; // $cached_repos ?>
    </ul>
<?php else: // $cached_repos is empty ?>
    <p>No repos cached.</p>
<?php endif; // $cached_repos ?>

</body>
</html>