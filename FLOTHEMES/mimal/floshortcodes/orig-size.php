<?php
global $flo_options,$post,$gutter,$nr_col_c;
$retina_ratio = 1;
$has_image = true;


// if flo_device_pixel_ratio cookie exists and it is >= 2, then we have a retina display,
if(isset($_COOKIE["flo_device_pixel_ratio"]) && $_COOKIE["flo_device_pixel_ratio"] >=2 ){
    $retina_ratio = 2;
}
if (has_post_thumbnail($post->ID) && !post_password_required()) {
    $img_url1 = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full'); //get img URL
    $img_url = aq_resize($img_url1, 9999*$retina_ratio, 9999*$retina_ratio, false, false, false); //crop img
    if ($img_url[1] > $img_url[2]) {
        $img_url = aq_resize($img_url1, 9999, 450*$retina_ratio, false, false, true); //resize img
    } else {
        $img_url = aq_resize($img_url1, 600*$retina_ratio, 9999, false, false, true); //resize img
    }
}

if (!isset($img_url)) {
    $img_url[0] = get_template_directory_uri().'/img/aq_resize/noimage-600x600.jpg';
    $has_image = false;
} elseif ($img_url == '') {
    $img_url[0] = $img_url1;
}
?>

<li class="image <?php if( isset($img_url[1]) && isset($img_url[2]) && $img_url[1]>$img_url[2]): echo 'horizontal'; else: echo 'vertical';endif; echo ' '.$gutter.' ';?> <?php echo !$has_image ? 'no-image' : '';  ?>">
    

    <figure>
        <a href="<?php echo get_permalink( $post->ID ); ?>">
            <img src="<?php echo $img_url[0];?>" alt="">
        </a>

        <div class="figure-hover">
            <div class="content">
                <?php if (flo_show_date($post_type = $post->post_type)): ?>
                    <h5 class="date updated"><?php echo get_the_date('', $post->ID);?></h5>
                <?php endif; ?>
                <h3 class="entry-title title"><a href="<?php echo get_permalink($post->ID) ?>"><?php echo
                        get_the_title( $post ); ?></a>
                </h3>
                <a href="<?php echo get_permalink($post->ID) ?>" class="open-gallery"><?php _e('Open', 'flotheme') ?> <?php echo $post->post_type;?></a>
            </div>
        </div>

        <a href="<?php echo get_permalink($post->ID); ?>" class="fullblock-permalink"></a>
        
    </figure>
</li>
