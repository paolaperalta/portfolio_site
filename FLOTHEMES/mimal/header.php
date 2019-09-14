<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <?php if (isset($flo_options['flo_minimal-fb_id']) && strlen($flo_options['flo_minimal-fb_id']) ): ?>
        <meta property="fb:app_id" content="<?php echo $flo_options['flo_minimal-fb_id']; ?>">
    <?php endif ?>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php
    global $flo_options, $slideshow1;
    if (isset($post)) {
        $slideshow1 = meta::get_meta($post->ID, 'slideshowSettings');
    }
     ?>
    <?php if (isset($flo_options['flo_minimal-favicon']) && isset($flo_options['flo_minimal-favicon']['url']) && strlen
        ($flo_options['flo_minimal-favicon']['url'])): ?>

        <?php $path_parts = pathinfo($flo_options['flo_minimal-favicon']['url']); ?>
        <?php if ($path_parts['extension'] == 'ico'):?>
            <link rel="shortcut icon" href="<?php echo $flo_options['flo_minimal-favicon']['url']; ?>"/>

        <?php else: ?>
            <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico"/>
        <?php endif; ?>
    <?php else:  ?>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico"/>
    <?php endif;?>

    <?php if (isset($flo_options['flo_minimal-comments']['Enabled']['facebook'])): ?>
            
        <?php $appId = $flo_options['flo_minimal-fb_id'] ? $flo_options['flo_minimal-fb_id'] : '867056080076948'; ?>

        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : <?php echo $appId; ?>,
              xfbml      : true,
              version    : 'v2.5'
            });
          };

          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "//connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
        </script>
    <?php endif ?>


    <?php wp_head(); ?>
</head>

<div id="fb-root"></div>


<?php
if (isset($post) && $post->post_type == 'gallery' && is_single()) {
    $body_class = 'portfolio-open';
} elseif (is_home()) {
    $body_class = 'home';
} elseif (is_page()) {
    $body_class = 'about';
} else {
    $body_class = 'home';
}

?>
<body <?php body_class($body_class); ?>>
    <?php if (isset($slideshow1['slideshow_select']) && $slideshow1['slideshow_select'] != 0): ?>
        <?php
        $menu_block_class = 'hero-block__image';
        $down_button_show = true;
        $header_class = ' hero-image ';
        ?>
    <?php else: ?>
        <?php
        $menu_block_class = ' ';
        $down_button_show = false;
        $header_class = '  ';
        ?>
    <?php endif; ?>
    <div id="wrapper">
        <?php if(isset($flo_options['flo_minimal-enable_search_in_header']) && $flo_options['flo_minimal-enable_search_in_header'] == '1'):?>
            <?php get_template_part('parts/flo-search-form') ?>
        <?php endif; ?>

        <?php $valid_slideshow_types = array('menu_outside_top','menu_over'); ?>

        <?php if (isset($slideshow1['slideshow_select']) && $slideshow1['slideshow_select'] != 0 && isset($slideshow1['slideshow_type']) && in_array($slideshow1['slideshow_type'],$valid_slideshow_types) && $slideshow1['slideshow_type'] == 'menu_outside_top'): ?>
            <?php get_template_part('parts/header/menu_outside_top'); ?>
        <?php elseif (isset($slideshow1['slideshow_select']) && $slideshow1['slideshow_select'] != 0 && isset($slideshow1['slideshow_type']) && in_array($slideshow1['slideshow_type'],$valid_slideshow_types) && $slideshow1['slideshow_type'] != 'menu_outside_top'): ?>
            <?php get_template_part('parts/header/menu_over'); ?>
        <?php elseif(isset($slideshow1['slideshow_select']) && $slideshow1['slideshow_select'] != 0 && isset($slideshow1['slideshow_type']) && !in_array($slideshow1['slideshow_type'], $valid_slideshow_types)): ?>
            <?php get_template_part('parts/header/menu_over'); ?>
        <?php elseif(isset($slideshow1['slideshow_select']) && $slideshow1['slideshow_select'] != 0 && !isset($slideshow1['slideshow_type'])): ?>
            <?php get_template_part('parts/header/menu_over'); ?>
        <?php else: ?>
            <?php get_template_part('parts/header/header'); ?>
        <?php endif; ?>



