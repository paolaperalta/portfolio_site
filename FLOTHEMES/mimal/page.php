<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package options_sample
 */
$post_id = $post->ID;
$meta = meta::get_meta($post->ID, 'settings');
get_header();?>
        <div style="clear: both"></div>
		<div class="page">

			<div class="before-page-content">
				<?php
				if(isset($meta) && isset($meta['include_before_page_content_sidebar']) &&
					$meta['include_before_page_content_sidebar'] == 'yes'):
					dynamic_sidebar($meta['sidebar_before']);
				endif;
				?>
			</div>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; // end of the loop. ?>
		</div>
<?php get_footer(); ?>
