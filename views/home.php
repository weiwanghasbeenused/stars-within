<?php 
require_once __DIR__ . '/../static/php/getList.php';

$list_items = getList($db, 0);
?>
<div id="home" class="page">
    <?php 
        foreach($list_items as $item) {
            echo "<div><a href='$item[url]'>$item[name1]</a></div>";
        }
    ?>
</div>