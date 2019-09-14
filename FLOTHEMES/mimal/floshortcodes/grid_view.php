<?php
global $flo_options,$post,$gutter,$nr_col_c, $view_type_c;

/*
* Variables
*/
$img_url = '';
$flo_srcset = '';
$has_image = false; 
$image_meta = wp_get_attachment_metadata(get_post_thumbnail_id($post->ID));

$size_array = array(
	array('width' => ReduxFramework::get_aqua_size('flo_minimal-grid_view','width')*0.5, 'height' => ReduxFramework::get_aqua_size('flo_minimal-grid_view','height')*0.5),
	array('width' => ReduxFramework::get_aqua_size('flo_minimal-grid_view','width')*0.7, 'height' => ReduxFramework::get_aqua_size('flo_minimal-grid_view','height')*0.7),
	array('width' => ReduxFramework::get_aqua_size('flo_minimal-grid_view','width'), 'height' => ReduxFramework::get_aqua_size('flo_minimal-grid_view','height')),
	array('width' => ReduxFramework::get_aqua_size('flo_minimal-grid_view','width')*2, 'height' => ReduxFramework::get_aqua_size('flo_minimal-grid_view','height')*2),
);

if (has_post_thumbnail($post->ID) && !post_password_required()) {
		$img_src = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full'); //get img URL
		$img_url = aq_resize($img_src, ReduxFramework::get_aqua_size('flo_minimal-grid_view','width'), ReduxFramework::get_aqua_size('flo_minimal-grid_view','height'), true, true, true); //crop img

		$flo_srcset = flo_create_image_srcset($size_array, $image_meta, $img_src, $crop = true);
		$has_image = true;
} else {
		$img_url = get_template_directory_uri().'/img/aq_resize/noimage-600x600.jpg';
		$flo_srcset = '';
}

if (!isset($img_url) || $img_url == '') {
	$has_image = false;
}
if(is_array($gutter)){
	$gutter = ' gutter-default ';
}

?>

<li class="image <?php echo ' '.$gutter.' ';?> <?php echo !$has_image ? 'no-image' : '';  ?>">
	<figure>
		<a href="<?php echo get_permalink($post->ID );?>">
			<img src="<?php echo $img_url;?>" srcset="<?php echo $flo_srcset; ?>" sizes="(max-width: 640px) 100vw, 33vw" alt="">
		</a>
		<div class="figure-hover">
			<div class="content">
				<?php if (flo_show_date($post_type = $post->post_type)): ?>
					<h5 class="date updated"><?php echo get_the_date('', $post->ID);?></h5>
				<?php endif ?>
				<h3 class="entry-title title">
					<a href="<?php echo get_permalink($post->ID) ?>">
						<?php echo get_the_title( $post ); ?>
					</a>
				</h3>
				<a href="<?php echo get_permalink($post->ID) ?>" class="open-gallery"><?php _e('Open', 'flotheme') ?>
					<?php echo $post->post_type;?>
				</a>
			</div>
		</div>
			<a href="<?php echo get_permalink($post->ID); ?>" class="fullblock-permalink"></a>
	</figure>
</li>



<!--http://mimal.local/wp-content/uploads/2015/12/GL300415003690-8-300x300.jpg 300w,-->
<!--http://mimal.local/wp-content/uploads/2015/12/GL300415003690-8-420x420.jpg 420w,-->
<!--http://mimal.local/wp-content/uploads/2015/12/GL300415003690-8.jpg 791w-->
<!---->
<!---->
<!---->
<!--http://mimal.local/wp-content/uploads/2015/12/Portrait-300x300.jpg 300w,-->
<!--http://mimal.local/wp-content/uploads/2015/12/Portrait-420x420.jpg 420w,-->
<!--http://mimal.local/wp-content/uploads/2015/12/Portrait-600x600.jpg 600w,-->
<!--http://mimal.local/wp-content/uploads/2015/12/Portrait-1200x1200.jpg 1200w-->