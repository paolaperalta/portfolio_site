<?php
global $flo_options, $meta, $meta_repeater_show, $sidebar_sharing,$page_about, $page_type_class,$title_color,$show_header;
$post_id = $post->ID;
$layout = meta::get_meta($post_id, 'layout');
$header_page = meta::get_meta($post_id, 'flo_post_header_type');
$flo_title_color = meta::get_meta($post->ID, 'flo_posts_title_color');
if(isset($flo_title_color) && $flo_title_color && $flo_title_color != ''){
	$title_color = 'style="color: '.$flo_title_color.'"';
}else{
	$title_color = '';
}
if (isset($layout['type']) && $layout['type'] != 'full') {
	$content_width_class = tools::primary_class($post_id, 'pages', $return_just_class = true);
} else {
	$content_width_class = tools::primary_class(0, 'pages', $return_just_class = true);
}
//added this code for to get the global $meta_repeater_show
ob_start();
ob_clean();
layout::side('right', $post_id, 'pages');
layout::side('left', $post_id, 'pages');
$side = ob_get_clean();

ob_start();
ob_clean();
get_template_part('parts/comment-block');
$comments = ob_get_clean();

$feat_enabled = false;
$meta = meta::get_meta($post->ID, 'settings');

if(isset($meta['page_title'])){
	$show_header = $meta['page_title'];
}else{
	$show_header = true;
}
// NEW OPTIONS SLIVA
$page_header_type =  $header_page  ? $header_page : $flo_options['flo_minimal-page_header_layout'];

if ($page_header_type == "1") {
	get_template_part('/parts/page-headers/page-header-full-image');
} elseif ($page_header_type == '2') {
	get_template_part('/parts/page-headers/page-header-full-small-image-center');
} elseif ($page_header_type == '3') {
	get_template_part('/parts/page-headers/page-header-only-small-image');
}

if (isset($layout['type']) && $layout['type'] != 'full') {
	$content_width_class = tools::primary_class($post_id, 'pages', $return_just_class = true);
} else {
	$content_width_class = tools::primary_class(0, 'pages', $return_just_class = true);
}

$show_page_header = $show_header == 'yes' && ($header_page == '3' || ( !has_post_thumbnail($post->ID) && !post_password_required() ));

?>

<?php if ($show_page_header || get_the_content()): ?>

<div class="page-content with-sidebar">
	<div class="layout row">
		<div class="<?php echo $content_width_class;?>">
			<article>
				<?php if($show_page_header):?>
					<div class="page-header" <?php echo $title_color;?>>
						<h1 class="entry-title title"><?php echo the_title();?></h1>
						<?php if (flo_subtitle($post->ID)): ?>
							<h4 class="sub-title"><?php echo flo_subtitle($post->ID);?></h4>
						<?php endif ?>
					</div>
				<?php endif; ?>

				<?php if (get_the_content()): ?>
					<div class="article-content the-content">
						<?php the_content();?>
					</div>
				<?php endif; ?>

			</article>

			<?php echo get_template_part('parts/comment-block');?>

		</div>

		<?php
		layout::side('right', $post_id, 'pages');
		layout::side('left', $post_id, 'pages');
		?>
	</div>
	<?php

	if (isset($meta['include_below_page_content_sidebar']) && $meta['include_below_page_content_sidebar'] == 'yes') {
		get_template_part('parts/post/block-below-page-content');
	}
	?>
</div>
<?php endif; ?>
