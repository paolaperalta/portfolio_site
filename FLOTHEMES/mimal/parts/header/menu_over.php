<?php global $slideshow, $slideshow1, $flo_options;
$portfolio_label = get_post_meta($slideshow1['slideshow_select'],'portfolio_label', true);

if (isset($flo_options['flo_minimal-slideshow_type']) && $flo_options['flo_minimal-slideshow_type'] != '') {
    $s_layout_type = $flo_options['flo_minimal-slideshow_type'];
} else {
    $s_layout_type = 'fullscreen';
}

$noLazy = true;

?>
<?php if (isset($slideshow1['slideshow_select']) && $slideshow1['slideshow_select'] != 0) {
    flo_get_slideshow($slideshow1['slideshow_select']);
}?>
<?php if(isset($slideshow) && !empty($slideshow)):?>
    <header class="main-header all-top <?php echo get_logo_position($flo_options['flo_minimal-logo_position']); ?>">

        <?php get_template_part('parts/header/navigation-wrap'); ?>

        <div class="hero-block__slider row">
            <div class="hero_nav">

                <div class="nav-wrapper">
                    <div class="logo">
                        <?php echo flo_slideshow_get_logo()?>
                    </div>

                    <?php get_template_part('parts/header/menu'); ?>
                </div>
            </div>
            <div class="large-12 columns">
                <div class="hero-slider menu-over">
                    <div class="slider <?php echo $s_layout_type; ?>">
                        <?php foreach ($slideshow as  $key => $slide): ?>
                            <?php   
                                    if(isset($slide['meta_id'])){
                                        $image = wp_get_attachment_url($slide['meta_id'], 'full');
                                    }

                                    $is_image = isset($image) && isset($image) && $image != '';
                                    $is_bg_color = isset($slide['background_color']) && $slide['background_color'] != "";

                                    if ($is_image) {
                                        $s_layout_type == 'fullscreen' && $bg_style = 'background-image: url(' . $image . ');';
                                    } else {
                                        $bg_color = $is_bg_color ? str_replace('#', '', $slide['background_color']) : 'f4f4f4';

                                        $bg_style = 'background-image: url(' . get_template_directory_uri() . '/flo-options/ReduxCore/image-generator.php?color=' . $bg_color;
                                    }
                            ?>
                            <div style="<?php echo $bg_style; ?>" class="slide <?php echo $is_image ? '' : 'no-image' ?>">
                                <?php if ($s_layout_type == 'full-width' && $is_image): ?>
                                    <figure>
                                        <img <?php echo $noLazy  ? 'src' : 'data-lazy'; ?>="<?php echo $image; ?>" alt="">

                                        <?php $noLazy && $noLazy = false; ?>
                                    </figure>
                                <?php endif ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php $isPortfolioLabel = isset($portfolio_label) && $portfolio_label !=  ''; ?>
                    <a href="#" <?php // echo $text_color; ?> class="slide-btn">
                        <?php echo $isPortfolioLabel ? $portfolio_label : '';?>
                    </a>
                </div>
            </div>
        </div>
        
    </header>
<?php else:?>
        <?php get_template_part('parts/header/header')?>
<?php endif;?>
