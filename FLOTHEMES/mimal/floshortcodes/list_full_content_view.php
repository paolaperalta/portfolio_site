<?php
global $nr_of_columns, $flo_options,$post,$gutter,$list_width;
$retina_ratio = 1;
$nr_of_columns = 1;

if(isset($_COOKIE["flo_device_pixel_ratio"]) && $_COOKIE["flo_device_pixel_ratio"] >=2 ){
    $retina_ratio = 2;
}
if (has_post_thumbnail($post->ID) && !post_password_required()) {
    $img_url1 = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full'); //get img URL
    if($list_width == ' full-width '){
        $img_url = aq_resize($img_url1, ReduxFramework::get_aqua_size('flo_minimal-list_view_full','width')*$retina_ratio,
            ReduxFramework::get_aqua_size('flo_minimal-list_view_full','height')*$retina_ratio, true, true,true); //crop img
    }else{
        $img_url = aq_resize($img_url1, ReduxFramework::get_aqua_size('flo_minimal-list_view','width')*$retina_ratio,
            ReduxFramework::get_aqua_size('flo_minimal-list_view','height')*$retina_ratio, true, true,true); //crop img
    }
}

if($post->post_type == 'post'){
    $category = wp_get_post_terms($post->ID, 'category');
}else{
    $category = wp_get_post_terms($post->ID, 'gallery-category');
}

if ($category) {
    $cat_name = $category[0]->name;
    $cat_link = get_category_link($category[0]);
}

$is_featured_image = has_post_thumbnail($post->ID) && !post_password_required();

if ($is_featured_image) {
    $post_class = 'with-image';
    $post_header_class = 'with-image';
} else {
    $post_class = 'without-image';
    $post_header_class = '';
}

$flo_title_color = meta::get_meta($post->ID, 'flo_posts_title_color');
if(isset($flo_title_color) && $flo_title_color && $flo_title_color != ''){
    $title_color = "color: ".$flo_title_color;
}else{
    $title_color =  '';
}
?>

<?php
$stylekit = '';

if (defined('FLO_STYLEKIT')) {
    $stylekit = FLO_STYLEKIT;
} else {
    $stylekit = 'style-basic';
}
?>


<div class="post full_content_view <?php echo $post_class. ' ' . $stylekit; ?>">
    <div  class="post-header <?php echo $post_header_class;?>" style="<?php echo $title_color;?>">
        <div class="inner">
            <div class="line"></div>

            <div class="meta">
                <div class="date meta-block">
                    <h6 class="updated" style="<?php echo $title_color;?>" data-date="<?php echo get_the_date('d', $post->ID ); ?>">
                        <?php echo get_the_date('', $post->ID);?>
                    </h6>
                </div>

                <div class="categories meta-block" >
                    <h6>
                        <?php foreach ($category as $cat): ?>
                            <span class="cat" style="<?php echo $title_color ?>"><?php echo $cat->name ?></span>
                        <?php endforeach ?>
                    </h6>
                </div>
            </div>

            <h2 class="entry-title title">
                <a  href="<?php echo get_the_permalink($post); ?>" style="<?php echo $title_color;?>">
                    <?php echo get_the_title($post); ?>
                </a>
            </h2>
            <?php if (has_post_thumbnail($post->ID) && !post_password_required()): ?>
                <figure class="featured"> <img src="<?php echo $img_url;?>" alt=""></figure>
            <?php endif;?>
            <article class="excerpt_full" style="<?php echo $title_color;?>">
                <p>
                    <?php echo the_content(); ?>
                </p>
            </article>
        </div>
    </div>

</div>

