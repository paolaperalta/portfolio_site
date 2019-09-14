<?php get_header(); ?>
<?php
global $gallery_id, $flo_options;

$retina_ratio = 1;

// if flo_device_pixel_ratio cookie exists and it is >= 2, then we have a retina display,
if (isset($_COOKIE["flo_device_pixel_ratio"]) && $_COOKIE["flo_device_pixel_ratio"] >= 2) {
	$retina_ratio = 2;
}

if (isset($gallery_id) && $gallery_id != '') {
	$post_id = $gallery_id;
} else {
	$post_id = $post->ID;
}
$post = get_post($post_id);

if(isset($flo_options) && isset($flo_options['flo_minimal-gallery_nr_of_columns']) && $flo_options['flo_minimal-gallery_nr_of_columns'] != ''){
	if($flo_options['flo_minimal-gallery_nr_of_columns'] == '3'){
		$gallery_class = ' medium-block-grid-3 large-block-grid-3 ';
	}elseif($flo_options['flo_minimal-gallery_nr_of_columns'] == '4'){
		$gallery_class = ' medium-block-grid-4 large-block-grid-4 ';
	}
}else{
	$gallery_class = ' medium-block-grid-3 large-block-grid-4 ';
}



$available_gal_layouts = array('grid_view','orig-size','thumbs','thumbs-full');
//$gallery_view_type = meta::get_meta($post->ID, '_cmb2_gallery_view_type','fixed_with_thumbs','one_line');

$gallery_view_type = get_post_meta( $post->ID, '_cmb2_minimal_gallery_view_type', true );



if(isset($gallery_view_type) && $gallery_view_type != '' && $gallery_view_type != null && in_array($gallery_view_type, $available_gal_layouts)){
	$gallery_layout = $gallery_view_type;

}else if(isset($flo_options['flo_minimal-single_gallery_layout'])){
	$gallery_layout = $flo_options['flo_minimal-single_gallery_layout'];
}else{
	$gallery_layout = 'grid_view';
}

$gallery_template = 'squares';

if ($gallery_layout == 'thumbs' || $gallery_layout == 'thumbs-full') {
	$gallery_template = "thumbs";
}


?>
<?php if (!post_password_required()): ?>
	<?php while (have_posts()) : the_post();?>
		<?php echo get_template_part('parts/single-gallery/' . $gallery_template); ?>
	<?php endwhile; ?>
<?php else:?>
	<?php the_content(); ?>
<?php endif; ?>


<?php get_footer(); ?>
