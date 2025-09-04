<?php

function getTopics($db, $topic_selector_id){
    $sql = "SET SESSION group_concat_max_len = 1000000";
    $db->query($sql);
    $sql = "SELECT 
        o_main.name1
        ,(
            SELECT CONCAT('[', GROUP_CONCAT(
                JSON_OBJECT(
                    'name1', o_sub.name1
                )
                ORDER BY o_sub.rank, o_sub.id
            ), ']')
            FROM objects o_sub
            JOIN wires w_sub 
                ON w_sub.fromid = o_main.id 
                AND w_sub.active = 1  
            WHERE o_sub.id = w_sub.toid AND o_sub.active = 1
        ) AS sub_topics 
        FROM 
            objects o_main 
        JOIN wires w 
            ON w.toid = o_main.id 
            AND w.fromid = $topic_selector_id
            AND w.active = 1 
        WHERE o_main.active = 1 
        ORDER BY o_main.rank, o_main.name1";
    $result = $db->query($sql);
    $output = array();
    while($row = $result->fetch_assoc()) {
        $item = [...$row];
        $item['sub_topics'] = $row['sub_topics'] ? json_decode($row['sub_topics'], true) : [];
        $output[] = $item;
    }
    return $output;
}