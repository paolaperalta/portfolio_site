<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package options_sample
 */
get_header();

global $flo_options;

$content_style = '';

$retina_ratio = 1;

if (isset($_COOKIE["flo_device_pixel_ratio"]) && $_COOKIE["flo_device_pixel_ratio"] >= 2) {
	$retina_ratio = 2;
}

if (isset($flo_options) && isset($flo_options['flo_minimal-404_layout']) && $flo_options['flo_minimal-404_layout'] != '') {
	$page_layout = $flo_options['flo_minimal-404_layout'];
}

if (isset($flo_options) && isset($flo_options['flo_minimal-404_image']) && (isset($flo_options['flo_minimal-404_image']['url']) && $flo_options['flo_minimal-404_image']['url'] != '')) {
	$not_found_image = $flo_options['flo_minimal-404_image'];

	if ($page_layout == 'content-50') {
		$not_found_image = aq_resize($not_found_image['url'],700*$retina_ratio,718*$retina_ratio,true,true,true);
	} elseif ($page_layout == 'content-full') {
		$not_found_image = aq_resize($not_found_image['url'],1400*$retina_ratio,720*$retina_ratio,true,true,true);
	}

} else {
	$not_found_image = false;
}

if (isset($flo_options) && isset($flo_options['flo_minimal-404_content']) && $flo_options['flo_minimal-404_content'] != '') {
	$not_found_content = wpautop($flo_options['flo_minimal-404_content']);
}

?>

<div class="page info-page">
	<div class="page-container <?php echo $page_layout; echo $not_found_image ? '' : ' no-image'; ?>">

      <figure>
	      <?php if (isset($not_found_image)): ?>
		      <img src="<?php echo $not_found_image;?>">
	      <?php endif; ?>
      </figure>

      <div class="content">
        <?php if ($not_found_content): ?>
        	<?php echo $not_found_content; ?>
        <?php endif ?>
      </div>

    </div>
</div>
<?php get_footer(); ?>
