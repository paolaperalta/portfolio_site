<?php global $flo_options, $gallery_layout, $retina_ratio, $gallery_class; 

$post_image_gallery = get_post_meta($post->ID, '_post_image_gallery', true); 
$img_id_array = array_filter(explode(',', $post_image_gallery));
$images = array();
$image_srcset = '';
$image_orientation = '';

foreach ($img_id_array as $image_id) {
	$image_src = wp_get_attachment_url($image_id);
	$image_info = get_post($image_id);
	$image_meta = wp_get_attachment_metadata($image_id);

	$image = array(
		"id" 		=> $image_id,
		"src"		=> $image_src,
		"meta" 	=> $image_meta
	);

	$images[] = $image;
}
?>

<div class="page portfolio-single opened l-<?php echo $gallery_layout; ?>">

	<div class="layout">
		<div class="page-header">
			<h2 class="title text-center"><?php the_title(); ?></h2>
		</div>

		<?php if (count($images)): ?>
			<div class="main-slider">
				<?php foreach ($images as $key => $image): ?>
					<?php 
						$size_array = array(
							array('width' => 768, 'height' => 9999),
							array('width' => 1600, 'height' => 9999)
						);

						if ($image['meta'] != '') {
							$image_srcset = flo_create_image_srcset($size_array, $image['meta'], $image['src']);
							$image_orientation = $image['meta']['height'] > $image['meta']['width'] ? 'vertical' : '';
						}

						$alt_title = get_post_meta($image['id'], '_wp_attachment_image_alt', true);
					?>

					<div class="slide <?php echo $image_orientation?>">
						<figure>
						<?php if ($key == 0): ?>
							<img src="<?php echo $image['src']; ?>" srcset="<?php echo $image_srcset; ?>" alt="<?php echo $alt_title; ?>" />

						<?php else: ?>
							<img class="lazyload" data-src="<?php echo $image['src']; ?>" data-srcset="<?php echo $image_srcset; ?>" alt="<?php echo $alt_title; ?>" />
						<?php endif ?>
						</figure>
					</div>
				<?php endforeach ?>
			</div>

			<div class="thumbnails">
				<?php foreach ($images as $key => $image): ?>
					<div class="thumbnail">
						<?php $thumbnail = aq_resize($image['src'], 9999, 182, false, true, true ) ?>
						<img src="<?php echo $thumbnail; ?>" alt="" class="lazyload">
					</div>
				<?php endforeach ?>
			</div>
		<?php endif ?>
		
		<div class="info">
			
			<?php if (get_the_content()): ?>
				<div class="description">
					<?php the_content(); ?>
				</div>
			<?php endif ?>

			<?php if (isset($flo_options) && isset($flo_options['flo_minimal-social_for_galleries']) && $flo_options['flo_minimal-social_for_galleries'] == '1'): ?>
				<?php echo get_template_part('/parts/gallery-social-sharing'); ?>
			<?php endif ?>
		</div>
	</div>
</div>