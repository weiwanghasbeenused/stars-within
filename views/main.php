<?php
    require_once __DIR__ . '/../open-records-generator/config/config.php';
    require_once __DIR__ . '/../static/php/functions.php';
    $db = db_connect('guest');
    $branch = $uri;
    array_shift($branch);
    $item = getItemByBranch($db, $branch);
    $site_title="Stars Within Demo";
    $page_title=$item ? $item['name1'] . ' | ' . $site_title : $site_title;

    $view = '';
    if(!$uri[1]) {
        $view = 'list';
        // require_once(__DIR__ . '/list.php');
    } else if($uri[1] === 'profiles') {
        if(count($uri) === 2) {
            $view = 'list';
        } else if(count($uri) === 3)
            $view = 'profile';
            // require_once(__DIR__ . '/profile.php');

    } else {
        $view = $uri[1];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $page_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/static/css/main.css">
        <?php if($item) {
            ?><link rel="stylesheet" href="/static/css/<?php echo $view; ?>.css"><?php 
        } ?>
        
    </head>
    <body>
        <div id="app">
        <?php 
            require_once(__DIR__ . '/'.$view.'.php');
        ?>
        </div>
    </body>
</html>