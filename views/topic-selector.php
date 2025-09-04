<?php 
require_once __DIR__ . '/../static/php/getTopics.php';
$topics = getTopics($db, $item['id']);
?>
<div id="<?php echo $item['url']; ?>" class="page">
    <ul>
    <?php 
        foreach($topics as $topic) {
            echo "<li class='main-topic-container'><div class='main-topic topic medium'>$topic[name1]</div><ul class='sub-topics-container'>";
            foreach($topic['sub_topics'] as $subtopic) {
                echo "<li class='sub-topic-wrapper'><div class='sub-topic topic'>$subtopic[name1]</div></li>";
            }
            echo "</ul></li>";
        }
    ?>
    </ul>
</div>