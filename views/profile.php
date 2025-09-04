<?php
function processSectionContent($raw, $section_slug, $extra_class=array()){
    // $content = $raw;
    $class = array_merge(['section-content-container'], $extra_class);
    $class_str = implode(' ', $class);
    $output="<div id='$section_slug-content-container' class='$class_str'>";
    $segment_pattern='/---(<br>)?/s';
    $link_pattern='/\[link\]\((.*?)\)(<br>)?/s';
    $tag_pattern='/\[(.*?)\]/s';
    $segments = preg_split($segment_pattern, $raw);
    $content='';
    foreach($segments as $segment) {
        $content.="<div class='section-content-segment'>";
        preg_match_all($link_pattern, $segment, $matches);
        if(count($matches) && count($matches[1])) { 
            foreach($matches[1] as $key => $url) {
                $segment = str_replace($matches[0][$key], '<a class="external-link" href="'.$url.'"></a>', $segment);
            }
        }
        preg_match_all($tag_pattern, $segment, $matches_tag);
        if(count($matches_tag) && count($matches_tag[1])) { 
            foreach($matches_tag[1] as $key => $tag) {
                $segment = str_replace($matches_tag[0][$key], "<div class='tag'>$tag</div>", $segment);
            }
        }
        
        $content.=$segment."</div>";
    }
    
    $output.=$content . "</div>";
    return $output;
}

function renderSection($data){
    global $item;
    $output='<div class="profile-section">';
    $output.="<div class='profile-section-title medium'>$data[display]</div>";
    if($data['column']) {
        $raw = $item[$data['column']] ?? null;
        if($raw !== null) {
            $output.=processSectionContent($raw, $data['slug'], $data['class']);
        }
        
    } else {
        if($data['slug'] === 'video') {

        }
    }
    $output.='</div>';
    return $output;
}

function renderCarousel($pics){
    $output = '';
    $dots = '';
    $pic_count = count($pics);
    foreach($pics as $key => $m) {
        $output .= "<div class='slide'><img src='$m[src]'></div>";
        $dots .= "<div class='dot'></div>";
    }
    $output = "<div class='carousel-container'>
        <div class='slides-wrapper' style='--slide-count:$pic_count'>
            <div class='slides-spring'>$output</div>
            <div class='prev-button carousel-overlay-button'></div>
            <div class='next-button carousel-overlay-button'></div>
        </div>
        <div class='carousel-dots-wrapper'>$dots</div>
    </div>";
    return $output;
}
function renderHeader($name, $title, $slogan){
    $output = "<div class='profile-header float-container'><div class='profile-name-and-title'><div class='profile-name large bold'>$name</div><div class='profile-title bold'>$title</div></div><div class='profile-slogan medium bold'><span class='profile-slogan-span'>$slogan</span></div></div>";
    return $output;
}

$name = $item['name1'];
$title = $item['name2'];
$slogan = $item['address1'];
$profile_video = null;
$profile_pictures = array();
foreach($item['media'] as $m) {
    if(strpos($m['caption'], '[profile]') !== false) {
	$pic = $m;
	$pic['src'] = m_url($m);
        $profile_pictures[] = $pic;
    } else if (strpos($m['caption'], '[profile-video]') !== false) {
        $profile_video = $m;
	$profile_video['src'] = m_url($m);
    }
}

$sections = array(
    'state' => array(
        'display' => "擅長議題",
        'slug'    => 'topics',
        'column'  => 'state',
        'class'   => array(),
        'content' => ''
    )
    , array(
        'display' => "諮商形式",
        'slug'    => 'format',
        'column'  => 'city',
        'class'   => array(),
        'content' => ''
    )
    , array(
        'display' => "諮商費用",
        'slug'    => 'charge',
        'column'  => 'zip',
        'class'   => array('body'),
        'content' => ''
    )
    , array(
        'display' => "精選文章",
        'slug'    => 'articles',
        'column'  => 'deck',
        'class'   => array('body'),
        'content' => ''
    )
    , array(
        'display' => "自介影片",
        'slug'    => 'video',
        'column'  => '',
        'class'   => array(),
        'content' => ''
    )
    , array(
        'display' => "證照｜經歷｜學歷",
        'slug'    => 'experience',
        'column'  => 'body',
        'class'   => array('body'),
        'content' => ''
    )
    , array(
        'display' => "服務地點",
        'slug'    => 'locations',
        'column'  => 'notes',
        'class'   => array('body'),
        'content' => ''
    )
);

?>
<div id="profile" class="page">
    <?php 
        echo renderCarousel($profile_pictures);
        echo renderHeader($name, $title, $slogan);
        foreach($sections as $section) {
            echo renderSection($section);
        }
    ?>
    <div class='profile-controls-container'>
        <div class='profile-prev-button'></div>
        <div class='contact-button'>聯絡心理師</div>
        <div class='share-button'>分享</div>
        <div class='save-button'>收藏</div>
        <div class='profile-next-button'></div>
    </div>
</div>
<script type="module">
    import Carousel from '/static/js/Carousel.js';
    const carousel_containers = document.getElementsByClassName('carousel-container');
    for(const container of carousel_containers) {
        new Carousel(container);
    }
    
</script>
