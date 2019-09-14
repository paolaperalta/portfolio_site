<?php
/**
 * The template for displaying all single posts.
 *
 * @package options_sample
 */
get_header();
?>
<div class="page post-page">
	<div class="layout">
		<?php while (have_posts()) : the_post(); ?>
			<?php
				get_template_part('content', 'single');
			?>
		<?php endwhile; // end of the loop. ?>
	</div>
</div>
<?php get_footer(); ?>
