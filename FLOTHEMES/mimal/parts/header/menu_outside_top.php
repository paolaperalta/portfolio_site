<?php global $slideshow, $slideshow1, $flo_options,$post;
$portfolio_label = get_post_meta($slideshow1['slideshow_select'],'portfolio_label', true);

if (isset($flo_options['flo_minimal-slideshow_type']) && $flo_options['flo_minimal-slideshow_type'] != '') {
    $s_layout_type = $flo_options['flo_minimal-slideshow_type'];
} else {
    $s_layout_type = 'fullscreen';
}

$noLazy = true;

?>

<?php get_template_part('parts/header/header'); ?>

<div class="hero-block__slider hero-slider menu-outside">
    <div class="slider <?php echo $s_layout_type; ?>">
        <?php
        if (isset($slideshow1['slideshow_select']) && $slideshow1['slideshow_select'] != 0) {
            flo_get_slideshow($slideshow1['slideshow_select']);
        }
        foreach ($slideshow as $slide):
            $class_title = 'title_hover_link_'.rand(0,9999);

            $image = wp_get_attachment_url($slide['meta_id'], 'full'); 
            
            $is_image = isset($image) && isset($image) && $image != '';
            $is_bg_color = isset($slide['background_color']) && $slide['background_color'] != "";

            $bg_style = '';

            if ($is_image) {
                $s_layout_type == 'fullscreen' && $bg_style = 'background-image: url(' . $image . ');';
            } else {
                $bg_color = $is_bg_color ? str_replace('#', '', $slide['background_color']) : 'f4f4f4';

                $bg_style = 'background-image: url(' . get_template_directory_uri() . '/flo-options/ReduxCore/image-generator.php?color=' . $bg_color;
            } 

            if (isset($slide['text_color']) && $slide['text_color'] != '') {
                $text_color = 'style="color:' . $slide['text_color'] . ';"';
            } else {
                $text_color = "";
            }

            $has_video = isset($slide['video']) && $slide['video'] != '';

            ?>
                <div style="<?php echo $bg_style; ?>"<?php if ($has_video): ?><?php endif ?> class="slide <?php echo $has_video ? 'video-slide' : '';?> <?php echo !$is_image ? 'no-image' : ''; ?>">
                    
                    <?php if ($s_layout_type == 'full-width' && $is_image): ?>
                        <figure class="slide-image">
                            <img <?php echo $noLazy  ? 'src' : 'data-lazy'; ?>="<?php echo $image; ?>" alt="">

                            <?php $noLazy && $noLazy = false; ?>
                        </figure>
                    <?php endif ?>

                    <?php 
                        if(isset($slide['title_hover_color']) && $slide['title_hover_color'] != ''){
                            echo '<style type="text/css">';
                            echo '.'.$class_title.':hover{';
                            echo 'color:'. $slide['title_hover_color'].'!important';
                            echo '}';
                            echo '</style>';
                        }
                     ?>
                    
                    <?php if ((isset($slide['logo']) && $slide['logo'] != '') || ($slide['title'] && $slide['title'] != '') || (isset($slide['description']) && $slide['description'] != '') || $has_video): ?>
                        
                        <div class="slide-hover">
                            <?php if(isset($slide['logo']) && isset($slide['content_type_radio']) && $slide['content_type_radio'] == 'title'):?>
                                <?php if (isset($slide['title']) && $slide['title'] != ''):?>
                                    <?php if (isset($slide['title_link']) && $slide['title_link'] != ''): ?>
                                        <h3 class="title <?php echo " ".$class_title;?>" <?php echo $text_color; ?>>
                                            <a href="<?php echo $slide['title_link']; ?>" <?php echo $text_color; ?> class="<?php echo $class_title; ?>">
                                               <?php echo $slide['title'] ?>
                                            </a>
                                        </h3>
                                    <?php else: ?>
                                        <h3 <?php echo $text_color; ?>
                                            class="title <?php echo " ".$class_title;?>"><?php echo $slide['title'] ?>
                                        </h3>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (isset($slide['description']) && $slide['description'] != '') { ?>
                                    <h4 class="sub-title <?php echo " ".$class_title;?>" <?php echo $text_color; ?>>
                                        <?php echo $slide['description']; ?>
                                    </h4>
                                <?php } ?>
                                <?php if ($has_video): ?>
                                    <a href="#" <?php echo $text_color; ?> class="play-button min-icon-play-button"></a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?php if (isset($slide['title_link']) && $slide['title_link'] != ''): echo
                                $slide['title_link'];endif; ?>"><img src="<?php echo $slide['logo'];?>" /></a>
                            <?php endif;?>
                        </div>
                    <?php endif ?>

                    <?php if ($has_video): ?>
                        <a href="#" data-title="close"  class="close-video min-icon-close-button"> </a>

                        <div class="video-block" data-video-url="<?php echo $slide['video']; ?>" autoplay> 
                        </div>
                    <?php endif; ?>
                </div>
        <?php endforeach; ?>

    </div>

    <?php if(isset($portfolio_label) && $portfolio_label != ''): ?>
        <a href="#" <?php echo $text_color; ?> class="slide-btn">
            <?php  echo $portfolio_label;?>
        </a>
    <?php endif; ?>
        
</div>