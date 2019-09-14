<?php
global $nr_of_columns, $flo_options,$post,$gutter,$list_width;
$retina_ratio = 1;
$nr_of_columns = 1;
// if flo_device_pixel_ratio cookie exists and it is >= 2, then we have a retina display,
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

$flo_background_color = meta::get_meta($post->ID, 'flo_posts_background_color');
if(isset($flo_background_color) && $flo_background_color && $flo_background_color != ''){
    $class_bg = 'background_color_class'.rand(0,9999);
    echo '<style type="text/css">';
    echo '.page.blog .all-posts.full-width .post.with-image.'.$class_bg.' .post-header:before, .page.blog .all-posts.with-layout
    .post.with-image.'.$class_bg.':hover .post-header{';
    echo 'background-color:'. $flo_background_color;
    echo '}';
    echo '</style>';
}else{
    $background_color =  $class_bg = '';
}

$post_excerpt = false;
$lenght = $flo_options['flo_minimal-excerpt'];

if (isset($lenght) && $lenght != '') {
    $ln = $lenght;
    if (!empty($post->post_excerpt)) {
        if (trim(strlen(strip_tags(strip_shortcodes($post->post_excerpt)))) > $ln) {
            $post_excerpt = mb_substr(trim(strip_tags(strip_shortcodes($post->post_excerpt))), 0, $ln) . ' ...';
        } else {
            $post_excerpt = trim(strip_tags(strip_shortcodes($post->post_excerpt)));
        }
    } else {

        if (trim(strlen(strip_tags(strip_shortcodes($post->post_content)))) > $ln) {
            $post_excerpt = mb_substr(trim(strip_tags(strip_shortcodes($post->post_content))), 0, $ln) . '  ...';
        } else {
            if (!empty($post->post_content)) {
                $post_excerpt = trim(strip_tags(strip_shortcodes($post->post_content)));
            }
        }
    }
}

$is_excerpt = $post_excerpt != false && strlen($post_excerpt) > 0; 

?>

<?php 
    $stylekit = '';

    if (defined('FLO_STYLEKIT')) {
        $stylekit = FLO_STYLEKIT;
    } else {
        $stylekit = 'style-basic';
    }
?>


<div class="post <?php echo $post_class. ' '. $class_bg . ' ' . $stylekit; ?>">
	<div  class="post-header <?php echo $post_header_class . " ". $class_bg; ?>" style="<?php echo $title_color;?>">
        <div class="inner">
            <div class="line"></div>

            <div class="meta">
                <?php if (flo_show_date($post_type = $post->post_type)): ?>
                <div class="date meta-block">
            		<h6 class="updated" style="<?php echo $title_color;?>" data-date="<?php echo get_the_date('d', $post->ID ); ?>">
                        <?php echo get_the_date('', $post->ID);?>
                    </h6>
                </div>
                <?php endif ?>

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
           
            <article class="excerpt <?php echo !$is_excerpt ? 'no-excerpt' : ''; ?>" style="<?php echo $title_color;?>">
                <p>
                    <?php echo $post_excerpt; ?>
                </p>
                <a href="<?php echo get_the_permalink($post->ID)?>" class="open-post" style="<?php echo $title_color;?>"><?php _e('Open', 'flotheme') ?> <?php echo $post->post_type;?>
                </a>
            </article>
        </div>
	</div>
	<?php if (has_post_thumbnail($post->ID) && !post_password_required()): ?>
    	<figure class="featured"> <img src="<?php echo $img_url;?>" alt=""></figure>
	<?php endif;?>
</div>

