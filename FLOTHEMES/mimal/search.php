<?php
global $flo_options;

$counter_i = 1;
if (isset($post)) {
	$post_id = $post->ID;
}
$content_width_class = tools::primary_class(0, 'search', $return_just_class = true);

get_header();

$view_type = $flo_options['flo_minimal-archive_listing_layout'];
$valid_view_types = array(
	'grid_view',
	'list_full_width_view',
	'list_content_width_view',
	'orig-size'
);
if(!in_array($view_type,$valid_view_types)){
	$view_type = 'grid_view';
}
?>

		<?php if ($view_type == 'grid_view' || $view_type == 'orig-size'): ?>
			<div class="page portfolio-page">
		<?php else: ?>
			<div class="page blog">
		<?php endif; ?>

		<div class="row">
			<div class="page-header" style="text-align: center">
				<h1 class="entry-title page-title"><?php printf(  strlen($flo_options['flo_minimal-search_page_title']) ? str_replace('%','%s', $flo_options['flo_minimal-search_page_title']) : __('Search Results for: %s', 'flotheme'), '<span>' . get_search_query() . '</span>'); ?></h1>
			</div>

			<?php if ($view_type == 'list_full_width_view' || $view_type == 'list_content_width_view' || $view_type == 'list_full_content_view'): ?>
				<?php
				global $type;
				$type = $view_type;
				get_template_part('parts/list_view_width'); ?>
			<?php endif; ?>
			<?php if ($view_type == 'grid_view' || $view_type == 'orig-size'): ?>
			<?php
			if ($view_type == 'grid_view') {
				$grid_class = 'squares';
			} elseif ($view_type == 'orig-size') {
				$grid_class = 'orig-size';
			}
			?>
			<div class="<?php echo $grid_class; ?> row">
				<div class="large-12 columns">
					<ul class="medium-block-grid-3 large-block-grid3">
						<?php endif; ?>
						<?php
						global $counter_i;
						$i = $counter = 1;
						/* Include the Post-Format-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
						?>
						<?php while (have_posts()) : the_post(); ?>
							<?php
							global $wp_query;
							$size_of_array = count($wp_query->posts);
							?>
							<?php
							if ($counter == $size_of_array) {
								$last = true;
							} else {
								$last = false;
							}
							$counter++;
							if ($view_type) {
								if ($view_type == 'list_content_width_view' || $view_type == 'list_full_width_view'):
									echo get_template_part('floshortcodes/list_view');
								else:
									echo get_template_part('floshortcodes/' . $view_type);
								endif;
							}
							$i++;
							if (isset($the_query)) {
								$post_ids[] = $the_query->post->ID;
							}
							?>
							<?php $counter_i++; ?>
						<?php endwhile; ?>
						<?php if ($view_type == 'grid_view'): ?>
					</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	echo get_template_part('templates/template-pagination');
	?>
</div>
<?php get_footer(); ?>
