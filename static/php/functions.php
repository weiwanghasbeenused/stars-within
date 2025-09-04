<?php

function getItemByBranch($db, $in){
    global $db;
    $branch = is_array($in) ? $in : (is_array($in) ? explode('/', $in) : '');
    if(empty($branch)) return array();
    $parent_slugs = array_reverse($in);
    $item_slug = array_shift($parent_slugs);
    $level = 0;
    $sql = "SELECT 
        o_0.*,
        (
            SELECT CONCAT('[', GROUP_CONCAT(
                JSON_OBJECT(
                    'id', m.id,
                    'type', m.type,
                    'hasWebFormat', m.weight,
                    'caption', REPLACE(CONVERT(m.caption USING utf8), '\\r\\n', '')
                )
                ORDER BY m.rank, m.id
            ), ']')
            FROM media m
            WHERE m.object = o_0.id AND m.active = 1
        ) AS media
        FROM 
            objects o_0
        JOIN wires w_0 ON w_0.toid = o_0.id AND w_0.active = 1 ";
    if(count($parent_slugs)) {
        foreach($parent_slugs as $key => $p_slug) {
            $prev = $level;
            $level++;
            $sql .= "JOIN objects o_$level ON o_$level.id = w_$prev.fromid AND o_$level.url = '$p_slug' AND o_$level.active = 1 ";
            if($key === count($parent_slugs) - 1) 
                $sql .= "JOIN wires w_$level ON w_$level.toid = o_$level.id AND  w_$level.fromid = 0 AND w_$level.active = 1 ";
            else
                $sql .= "JOIN wires w_$level ON w_$level.toid = o_$level.id AND w_$level.active = 1 ";
        }
    } else {
        $sql .= "AND w_0.fromid = 0 ";
    }
    
    $sql .= "WHERE o_0.url = '$item_slug' AND o_0.active = 1 LIMIT 1";
    $result = $db->query($sql);
    $output = $result->fetch_assoc();
    if($output) {
        $media = array();
        $output['media'] = $output['media'] ? json_decode( $output['media'], true) : [];
        
        foreach($output['media'] as $m){
            $media[] = $m;
        }
        $output['media'] = $media;
    }

    return $output;
}