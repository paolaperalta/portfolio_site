<?php
global $flo_options, $meta_repeater_show;
$retina_ratio = 1;
if (isset($flo_options) && isset($flo_options['flo-blog_post_tags'])) {
	if ($flo_options['flo-blog_post_tags'] == '1') {
		$flo_blog_post_tags = true;
	}
} else {
	$flo_blog_post_tags = false;
}
$flo_featured_image_show = $flo_options['flo_minimal-featured_on_single'];
 
if (isset($_COOKIE["flo_device_pixel_ratio"]) && $_COOKIE["flo_device_pixel_ratio"] >= 2) {
	$retina_ratio = 2;
}


if (has_post_thumbnail($post->ID) && !post_password_required() && $flo_featured_image_show == '1') {
	
	if(isset($flo_options['flo_minimal-content_width']) && is_numeric($flo_options['flo_minimal-content_width']) ){
		$feat_image_width = $flo_options['flo_minimal-content_width'];
	}else{
		$feat_image_width = 690;
	}
	$img_url1 = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full'); //get img URL
	$img_url = aq_resize($img_url1, $feat_image_width* $retina_ratio , 9999, false, true,true); //crop img


	if($img_url1 != '' && $img_url1 && !$img_url){
		$img_url = $img_url1;
	}
}


$post_id = $post->ID;
$layout = meta::get_meta($post_id, 'layout');

if (isset($layout['type']) && $layout['type'] != 'full') {
	$content_width_class = tools::primary_class($post->ID, 'single_posts', $return_just_class = true);
} else {
	$content_width_class = tools::primary_class(0, 'single_posts', $return_just_class = true);
} ?>

<?php

$enable_pagination = meta::get_meta($post->ID, '_cmb2_minimal_pagination');
if (isset($enable_pagination) && $enable_pagination == 'yes') {
	$pag = 'true';
} else {
	$pag = 'false';
}
$flo_title_color = meta::get_meta($post->ID, 'flo_posts_title_color');
if(isset($flo_title_color) && $flo_title_color && $flo_title_color != ''){
	$title_color = 'style="color: '.$flo_title_color.'"';
}else{
	$title_color = '';
}
?>
<?php
	if(isset($flo_options['flo_minimal-show_headers_categories_list']) && $flo_options['flo_minimal-show_headers_categories_list']
		== '1'):
		echo get_template_part('parts/categories');
	endif;
	echo get_template_part('parts/post_pagination');
?>
<article class="post">
	<header>
		<?php if (flo_show_date($post_type = 'post')): ?>
		<h6 class="date"><?php echo get_the_date('', $post->ID); ?></h6>	
		<?php endif ?>

		<h1 class="title" <?php echo $title_color;?>><?php the_title(); ?></h1>
		<?php echo flo_subtitle($post->ID);?>
	</header>
		
	<div class="content">

		<?php if ( isset($img_url) ): ?><p><img src="<?php echo $img_url; ?>" alt=""></p><?php endif; ?>

		<div class="article-content">
			<?php the_content(); ?>
		</div>
		<?php $tags = wp_get_post_tags($post->ID); ?>
		<?php $categories = wp_get_post_categories($post->ID); ?>
		<?php if(isset($flo_options['flo_minimal-show_categories']) && $flo_options['flo_minimal-show_categories'] == '1'):?>
			<?php if($categories || $tags):?>

				<div class="sub-content">
					<?php if($categories):?>
						<div class="category block">
							<label><?php echo __('Category:','flotheme');?></label>
							<ul>
								<?php foreach ($categories as $category):
									$cat = get_category( $category );?>
									<li>
										<a href="<?php echo get_category_link( $cat->term_id );  ?>">
											<?php echo $cat->name; ?>
										</a>
									</li>
								<?php endforeach ?>
							</ul>
						</div>
					<?php endif;?>

					<?php if($tags):?>
						<div class="tags block">
							<label><?php echo __('Tags:','flotheme');?></label>
							<ul>
								<?php foreach ($tags as $tag): ?>
								<li class="tag">
									<a href="<?php echo get_tag_link($tag->term_id); ?>">
										<?php echo $tag->name; ?>
									</a>
								</li>
								<?php endforeach ?>
							</ul>
						</div>
					<?php endif;?>

				</div>
			<?php endif;?>
		<?php endif;?>
	</div>
	<div class="actions">
		<?php echo get_template_part('parts/social-sharing'); ?>

		<?php echo get_template_part('parts/comment-block');?>
		<!-- Alse like — это realated posts-->
		<?php if ($flo_options['flo_minimal-similar']) { ?>
			<div class="also-like">
				<?php echo get_template_part('related-posts'); ?>
			</div>
		<?php } ?>
	</div>
</article>
