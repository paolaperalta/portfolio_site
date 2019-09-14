<?php
global $flo_options;
/* post taxonomy */
$tax = $flo_options['flo_minimal-similar_criteria'];
$layout = meta::get_meta($post->ID, 'layout');
$settings = meta::get_meta($post->ID, 'settings');
$label = __('RELATED POSTS', 'flotheme');
$query = similar_query($post->ID, $tax, 2);
if (!empty($query)) {
	$result = $query->posts;
}
$post_type = get_post_type($post->ID);
$related_posts_label = __('RELATED POSTS', 'flotheme');
$retina_ratio = 1;

if(isset($_COOKIE["flo_device_pixel_ratio"]) && $_COOKIE["flo_device_pixel_ratio"] >=2 ){
	$retina_ratio = 2;
}

if (!empty($result)) {
	?>
	<h6 class="title">You might also like</h6>
			<ul>
			<?php foreach ($result as $post): ?>
					<li class="also">
						<figure>
							<?php if (has_post_thumbnail($post->ID) && !post_password_required()):
								$img_url1 = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full'); //get img URL
								if ($img_url1) {
									$img_url = aq_resize($img_url1, 340 * $retina_ratio, 215 * $retina_ratio, true, true,true); //crop img
								}
								if (get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true)) {
									$alt_title = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
								} else {
									$alt_title = $post->post_title;
								}
								?>
								<a href="<?php echo get_the_permalink($post->ID); ?>">
									<img src="<?php echo $img_url; ?>" class="attachment-post-thumbnail wp-post-image" alt="<?php echo $alt_title; ?>"/>
								</a>
							<?php else: ?>
								<?php $img_url_1 = get_template_directory_uri() . '/img/aq_resize/noimage-400x300.jpg';
								if (get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true)) {
									$alt_title = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
								} else {
									$alt_title = $post->post_title;
								}
								?>
								<a href="<?php echo get_the_permalink($post->ID); ?>">
									<img src="<?php echo $img_url_1; ?>" class="attachment-post-thumbnail wp-post-image" alt="<?php echo $alt_title; ?>"/>
								</a>
							<?php endif;?>
						</figure>
						<h6 class="date"><?php echo get_the_date('',$post->ID)?></h6>
						<h4 class="title"><a href="<?php echo get_the_permalink($post->ID); ?>"><?php the_title();?></a></h4>
					</li>
			<?php endforeach; ?>
			</ul>
	<?php
	wp_reset_postdata();
}
?>
