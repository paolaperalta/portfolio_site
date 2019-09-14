<?php if (has_post_thumbnail($post->ID) && !post_password_required()):
    global $title_color,$show_header;
    $retina_ratio = 1;
    if (isset($_COOKIE["flo_device_pixel_ratio"]) && $_COOKIE["flo_device_pixel_ratio"] >= 2) {
        $retina_ratio = 2;
    }
    ?>
    <div class="hero-image small-photo">
        <div class="inner">
            <?php
            $feat_enabled = true;
            $src = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full'); //get img URL
            $img_url = aq_resize($src,452*$retina_ratio, 522*$retina_ratio, true, true,true); //crop img
            $is_featured_image = isset($img_url) && $img_url != '';
            ?>
            <?php if ($is_featured_image): ?>
                <svg width="452" xmlns="http://www.w3.org/2000/svg" xlink="http://www.w3.org/1999/xlink"
                     version="1.1" viewBox="0 0 452 522" class="svg-grapchic">
                        <clipPath id="hexagonal-mask">
                             <path d="M225.598,520.996 L-0.005,390.744 L-0.005,130.240 L225.598,-0.012 L451.201,130.240 L451.201,390.744 L225.598,520.996 Z" class="cls-1"/>
                        </clipPath>
                    </g>
                    <image clip-path="url(#hexagonal-mask)" height="100%" width="100%"
                           xlink:href="<?php echo $img_url ?>"></image>
                </svg>
            <?php endif; ?>
            <?php if(isset($show_header) && $show_header == 'yes'):?>
                <div class="figure-hover">
                    <div class="content" <?php echo $title_color;?>>
                       <h1 class="title"> <?php echo get_the_title( $post ); ?></h1>
                       <?php if(flo_subtitle($post->ID) != ""): ?>
                           <h4 class="sub-title"><?php echo flo_subtitle($post->ID);?></h4>
                       <?php endif;?>
                    </div>
                </div>
            <?php endif;?>

        </div>
    </div>
<?php endif; ?>
