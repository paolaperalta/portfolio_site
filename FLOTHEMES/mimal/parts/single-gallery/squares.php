<?php global $flo_options, $gallery_layout, $retina_ratio, $gallery_class ?>

<div class="page portfolio-single opened l-<?php echo $gallery_layout; ?>">
	<div class=" <?php echo $gallery_layout == "orig-size" ? "orig-size" : "squares"; ?> row">

		<div class="page-header">
			<h2 class="title text-center"><?php the_title(); ?></h2>
		</div>

		<div class="large-12 columns">
			<?php $post_image_gallery = get_post_meta($post->ID, '_post_image_gallery', true); ?>

			<?php if (strlen(trim($post_image_gallery))):?>
				<?php $img_id_array = array_filter(explode(',', $post_image_gallery)); ?>
				<ul class="<?php echo $gallery_class;?>">
					<?php if (isset($img_id_array) && count($img_id_array) > 0): ?>

						<?php $counter = 0; ?>

						<?php foreach ($img_id_array as $key => $value): ?>

							<?php
								$img_url = wp_get_attachment_url($value, 'full');

								if($gallery_layout && $gallery_layout == 'orig-size'){
									$image = aq_resize($img_url, 9999, 9999, false, false, true);
								}else{
									$image = aq_resize($img_url, 400, 400, true, false, true);
								}

								if($gallery_layout == 'orig-size') {
									if ($image[1] > $image[2]) {
										$image = aq_resize($img_url, 9999, 400*$retina_ratio, false, false, true);
									} else {
										$image = aq_resize($img_url, 400*$retina_ratio, 9999, false, false, true);
									}
								}

								$attachment_info = get_post($value);

								if (isset($attachment_info)) {
									$caption           = $attachment_info->post_excerpt;
									$image_description = $attachment_info->post_content;

								} else {
									$caption           = '';
									$image_description = '';
								}
								$src       = $image[0]; // use original img src    for the first image
								$img_class = '';
								$alt_title = get_post_meta($value, '_wp_attachment_image_alt', true);

								if ($gallery_layout == 'orig-size') {
									$image_position = $image[1] > $image[2] ? 'horizontal' : 'vertical';
								}
							?>

								<li class="image <?php echo $gallery_layout == 'orig-size' ? $image_position : '' ?>" >
								<figure>
									<a href="#" rel="gallery" data-position='<?php echo $counter; ?>' class="flobox">
										<?php if ($counter < 12): ?>
											<img src="<?php echo $src; ?>" alt="">
										<?php else: ?>
											<img src="<?php echo get_template_directory_uri() ?>/img/blank.gif" data-original="<?php echo $src; ?>" alt="" class="lazy-image">
										<?php endif ?>
									</a>
								</figure>
							</li>
							<?php $counter++;?>
						<?php endforeach;?>
					<?php endif;?>
				</ul>
			<?php endif;?>
		</div>
	</div>
</div>

<div class="flobox-wrapper">

	<div class="flobox-bg">
		<a href="#" class="close min-icon-close-button"></a>
	</div>
	<div class="flobox-loader"></div>
	<div class="flobox-layer">
		<?php $post_image_gallery = get_post_meta($post->ID, '_post_image_gallery', true); ?>

		<?php if (strlen(trim($post_image_gallery))){ ?>

			<?php $img_id_array = array_filter(explode(',', $post_image_gallery));

			if (isset($img_id_array) && count($img_id_array) > 0) {

				foreach ($img_id_array as $key => $value) {
					$image_orientation = '';
					$image_srcset = "";

					$src = wp_get_attachment_url($value, 'full'); //get img URL
					$attachment_info = get_post($value);
					$image_meta = wp_get_attachment_metadata($value);

					$size_array = array(
						array('width' => 768, 'height' => 9999),
						array('width' => 1600, 'height' => 9999)
					);

					if ($image_meta != '') {
						$image_orientation =  $image_meta['height'] > $image_meta['width'] ? 'vertical' : '';
						$image_srcset = flo_create_image_srcset($size_array, $image_meta, $src);
					}

					$alt_title = get_post_meta($value, '_wp_attachment_image_alt', true);
					?>
						<div class="<?php echo $image_orientation; ?>">
							<figure>
								<img class="lazyload"  data-srcset="<?php echo $image_srcset; ?>" alt="<?php echo $alt_title; ?>" />
							</figure>
						</div>
					<?php
				}
			}?>
			</ul>
		<?php } ?>
	</div>
	<div class="options-side">
		<div class="icons">
			<a href="#" data-option="info" class="option-select info min-icon-gallery-about"></a>
			<?php if(isset($flo_options) && isset($flo_options['flo_minimal-social_for_galleries']) && $flo_options['flo_minimal-social_for_galleries'] == '1'):?>
				<a href="#" data-option="share" class="option-select share min-icon-share"></a>
			<?php endif;?>
		</div>
		<div class="options">
			<div data-option="info" class="option info">
				<h4 class="date"><?php echo get_the_date('', $post->ID); ?></h4>
				<h2 class="title"><?php the_title(); ?></h2>
				<div class="content">
					<?php the_content(); ?>
				</div>
			</div>
			<?php
			if(isset($flo_options) && isset($flo_options['flo_minimal-social_for_galleries']) && $flo_options['flo_minimal-social_for_galleries'] == '1'){
				echo get_template_part('/parts/gallery-social-sharing');
			}
			?>
		</div>
	</div>
</div>