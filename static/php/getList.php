<?php

function getList($db, $parent_id){
    $sql = "SELECT 
        o.name1,
        o.url
        FROM 
            objects o 
        JOIN wires w 
            ON w.toid = o.id 
            AND w.fromid = $parent_id
            AND w.active = 1 
        WHERE o.active = 1 AND o.name1 NOT LIKE '\.%'
        ORDER BY o.rank, o.name1";
    $result = $db->query($sql);
    $output = array();
    while($row = $result->fetch_assoc()) {
        $output[] = $row;
    }
    return $output;
}