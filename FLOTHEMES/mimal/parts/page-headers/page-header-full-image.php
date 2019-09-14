<?php if (has_post_thumbnail($post->ID) && !post_password_required()):
global $title_color, $show_header, $flo_options;
    $retina_ratio = 1;
    if (isset($_COOKIE["flo_device_pixel_ratio"]) && $_COOKIE["flo_device_pixel_ratio"] >= 2) {
        $retina_ratio = 2;
    }
    ?>

    <?php $parallax = meta::get_meta($post->ID, 'flo_post_parallax_enable');  ?>

    <div class="hero-image full-width">
        <?php
        $feat_enabled = true;
        $src = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full'); //get img URL

        $img_url = aq_resize($src, ReduxFramework::get_aqua_size('flo_minimal-featured_image','width')*$retina_ratio,
            ReduxFramework::get_aqua_size('flo_minimal-featured_image','height')*$retina_ratio, true, true,true); //crop
            // img
        $is_featured_image = isset($img_url) && $img_url != '';
        ?>
        <?php if ($is_featured_image): ?>
        <figure><img src="<?php echo $img_url; ?>" alt="Hero Image">
            <?php endif; ?>
            <?php if(isset($show_header) && $show_header == 'yes'):?>
                <div class="figure-hover">
                    <div class="content" <?php echo $title_color;?>>
                        <div class="title-wrapper">
                            <h1 class="title"> <?php echo get_the_title( $post ); ?> </h1>
                        </div>
                        <?php if(flo_subtitle($post->ID) != ""): ?>
                            <h4 class="sub-title"><?php echo flo_subtitle($post->ID);?> </h4>
                        <?php endif;?>
                    </div>
                </div>
            <?php endif;?>
        </figure>
    </div>
<?php endif; ?>
