<?php 
require_once __DIR__ . '/../static/php/getList.php';
$item_id = $uri[1] ? $item['id'] : 0;
$list_items = getList($db, $item_id);
$page_id = $uri[1] ? $uri[1] : "home";
$root_url = $uri[1] ? '/' . $uri[1] : '';
?>
<div id="<?php echo $page_id; ?>" class="page">
    <?php 
        foreach($list_items as $item) {
            echo "<div class='list-row'><a href='$root_url/$item[url]'>$item[name1]</a></div>";
        }
    ?>
</div>
<style>
    .list-row {
        margin-bottom: .25em;
    }
</style>