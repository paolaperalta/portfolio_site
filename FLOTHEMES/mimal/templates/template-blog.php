<?php
/*
Template Name: Latest post types
*/
global $flo_options, $meta;

$post_id = $post->ID;
$layout = meta::get_meta($post_id, 'layout');

if (isset($layout['type']) && $layout['type'] != 'full') {
	$content_width_class = tools::primary_class($post_id, 'blog_posts', $return_just_class = true);
} else {
	$content_width_class = tools::primary_class(0, 'blog_posts', $return_just_class = true);
}
get_header();
$post_type_c = meta::get_meta($post->ID, '_cmb2_minimal_post_type');
$view_type = meta::get_meta($post->ID, '_cmb2_minimal_view_type');
$meta = meta::get_meta($post->ID, 'settings');
$en_pagination = meta::get_meta($post->ID, '_cmb2_minimal_pagination');
if(isset($meta['page_title'])){
	$show_header = $meta['page_title'];
}else{
	$show_header = true;
}
$flo_title_color = meta::get_meta($post->ID, 'flo_posts_title_color');
if(isset($flo_title_color) && $flo_title_color && $flo_title_color != ''){
	$title_color = 'style="color: '.$flo_title_color.'"';
}else{
	$title_color = '';
}
?>

<?php if ($view_type == 'grid_view' || $view_type == 'orig-size' || is_array($view_type)): ?>
		<div class="page portfolio-page">
	<?php else: ?>
		<div class="page blog">
	<?php endif; ?>



<div class="before-page-content">
	<?php
	if(isset($meta) && isset($meta['include_before_page_content_sidebar']) &&
		$meta['include_before_page_content_sidebar'] == 'yes'):
		dynamic_sidebar($meta['sidebar_before']);
	endif;
	?>
</div>

<?php while (have_posts()): the_post(); ?>

	<?php
		if(isset($flo_options['flo_minimal-show_headers_categories_list']) && $flo_options['flo_minimal-show_headers_categories_list'] == '1'):
			if($post_type_c != 'page'){
				echo get_template_part('parts/categories');
			}
		endif;
	?>

<?php if (($show_header && $show_header == 'yes') || get_the_content()): ?>
	<div class="page-content">
		<?php if($show_header && $show_header == 'yes'):?>
			<div class="page-header" <?php echo $title_color;?>>
				<h1 class="title"><?php the_title();?></h1>
				<?php if (flo_subtitle($post_id)): ?>
					<h4 class="sub-title">	<?php echo flo_subtitle($post_id);?> </h4>
				<?php endif ?>
			</div>
		<?php endif; ?>

		<?php if (get_the_content()): ?>
			<div class="layout">
				<div class="row">
					<div class="article-content the-content">
						<?php the_content();?>
					</div>
				</div>
			</div>
		<?php endif ?>
	</div>
<?php endif; ?>


	<?php
	wp_reset_postdata();
	$view_type = meta::get_meta($post->ID, '_cmb2_minimal_view_type');
	$categories_p = meta::get_meta($post->ID, '_cmb2_minimal_category_p');
	$categories_g = meta::get_meta($post->ID, '_cmb2_minimal_category_g');
	$pages = meta::get_meta($post->ID, '_cmb2_minimal_page_ids');
	$nr_of_columns = meta::get_meta($post->ID, '_cmb2_minimal_nr_of_columns');
	$nr_of_posts = meta::get_meta($post->ID, '_cmb2_minimal_nr_of_posts');

	$gutter = meta::get_meta($post->ID, '_cmb2_minimal_gutter');
	$list_width_option = meta::get_meta($post->ID, '_cmb2_minimal_list_view_width');

	if (isset($post_type_c) && $post_type_c != '' && $post_type_c != NULL) {
		$post_type = $post_type_c;
	} else {
		$post_type = 'post';
	}

	global $post_type_c,$list_width;
	$enable_pagination = meta::get_meta($post->ID, '_cmb2_minimal_pagination');

	if (isset($enable_pagination) && $enable_pagination == 'yes') {
		$pag = 'true';
	} else {
		$pag = 'false';
	}

	$valid_view_types = array(
			'grid_view',
			'list_full_width_view',
			'list_content_width_view',
			'list_full_content_view',
			'orig-size'
	);
	if(!in_array($view_type,$valid_view_types)){
		$view_type = 'grid_view';
	}
	if ($nr_of_columns == '3') {
		$block_class = 'medium-block-grid-3 large-block-grid3';
	} elseif ($nr_of_columns == '4') {
		$block_class = 'medium-block-grid-4 large-block-grid4';
	} else {
		$block_class = 'medium-block-grid-3 large-block-grid3';
	}
    //var_dump($view_type);die;
    global $type;
    $type = $view_type;
    get_template_part('parts/list_view_width');
	?>


	<?php
	if ($view_type == 'grid_view') {
		$grid_class = 'squares';
	} elseif ($view_type == 'orig-size') {
		$grid_class = 'orig-size';
	}
	?>

	<?php if ($view_type == 'grid_view' || $view_type == 'orig-size'): ?>
		<div class="<?php echo $grid_class; ?> row">
				<div class="large-12 columns">
					<ul class="<?php echo $block_class; ?>">
	<?php endif; ?>
					<?php
					if (get_query_var('paged')) {
						$current = get_query_var('paged');
					} elseif (get_query_var('page')) {
						$current = get_query_var('page');
					} else {
						$current = 1;
					}

					$query_args = array(
							'post_type'           => $post_type,
							'paged'               => $current,
							"posts_per_page"      => $nr_of_posts,
							'ignore_sticky_posts' => 1,
					);

					if (isset($post_type_c) && $categories_p &&  $post_type_c && $post_type_c == 'post') {
							$query_args['tax_query'] = array(
									array('taxonomy' => 'category',
									      'field'    => 'id',
									      'terms'    => $categories_p
									)
							);
					} elseif (isset($post_type_c) && $categories_g && $post_type_c && $post_type_c == 'gallery') {

						$query_args['tax_query'] = array(
								array('taxonomy' => 'gallery-category',
								      'field'    => 'id',
								      'terms'    => $categories_g
								)
						);
					} elseif (isset($post_type_c) && $pages && $post_type_c && $post_type_c == 'page') {
						$query_args['post__in'] = $pages;
					}

					$the_query = new WP_Query($query_args);
					$post_ids = array();
					$i = $counter = 1;
					$size_of_array = count($the_query->posts);
					?>
					<?php while ($the_query->have_posts()): $the_query->the_post(); ?>
						<?php
						if ($counter == $size_of_array) {
							$last = true;
						} else {
							$last = false;
						}
						$counter++;
						if ($view_type) {

                            if($view_type == 'list_content_width_view' || $view_type == 'list_full_width_view'):
                                echo get_template_part('floshortcodes/list_view');
                            else:
							    echo get_template_part('floshortcodes/' . $view_type);
                            endif;
						}
						$i++;
						$post_ids[] = $the_query->post->ID;
						?>
					<?php endwhile;
					wp_reset_postdata(); ?>
					<?php if ($view_type == 'grid_view' || $view_type == 'orig-size'): ?>
								</ul>
					<?php endif;?>
		</div>
	</div>
<?php endwhile; ?>

<?php
if($en_pagination && $en_pagination == 'yes'):
	echo get_template_part('templates/template-pagination');
endif;
?>
<?php
	if (isset($meta['include_below_page_content_sidebar']) && $meta['include_below_page_content_sidebar'] == 'yes') {
		get_template_part('parts/post/block-below-page-content');
	}
?>

<?php get_footer(); ?>
