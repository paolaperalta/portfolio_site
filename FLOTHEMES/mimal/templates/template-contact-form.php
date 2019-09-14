<?php
/**
 * Template Name: Contact Page
 */
global $flo_options;

$post_id = $post->ID;
$layout = meta::get_meta($post_id, 'layout');
$page_type_class = '';

$thx_msg = get_post_meta( $post_id, 'flo_contacts_thx_msg', true );

get_header();?>

<div class="page contact-page">

	<div class="flo-modal">
        <div class="thx-msg">
            <div class="icon-close"></div>
            <div class="content">
                <?php echo sanitize_text_field($thx_msg); ?>
            </div>
        </div>
    </div>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'content', 'contact' ); ?>
	<?php endwhile;?>
	</div>
<?php get_footer(); ?>
