<?php
global $flo_options;


if (!function_exists('flo_render_gallery_container')) {

	function flo_render_gallery_container($gallery_type)
	{
		switch ($gallery_type) {


			case 'grid_view':
				return array(
					'start' => '
						<div class="page portfolio-single opened">
							<div class="squares row">
								<div class="large-12 columns">
					',
					'end' => '
								</div>
							</div>
						</div>

					'
				);
				break;
				case "orig-size":
					return array(
						'start' => '
							<div class="page portfolio-single opened">
								<div class="orig-size row">
									<div class="large-12 columns">
						',
						'end' => '
								</div>
							</div>
						</div>
						'
					);
				break;

			default:
				return array(
					'start' => '
						<div class="page portfolio-single opened">
							<div class="squares row">
								<div class="large-12 columns">
					',
					'end' => '
								</div>
							</div>
						</div>
					'
				);
				break;
		}
	}
}

if (!function_exists('flo_pp_gallery_types')) {
	function flo_pp_gallery_types()
	{
		$img_path = get_template_directory_uri() . '/flo-options/ReduxCore/assets/img/icons/';
		$gallery_types = array(
		 	'grid_view' => $img_path . 'View_type_1.jpg',
            'orig-size' => $img_path . 'Gallery_1.jpg',
		);
		return $gallery_types;
	}
}

/**
 * Function, check brightness of your color
 */
function flo_color_brightness_check($hex) {

	$hex = str_replace('#', '', $hex);

	$r = hexdec(substr($hex, 0,2));
	$g = hexdec(substr($hex, 2,2));
	$b = hexdec(substr($hex, 4,2));

	$brightness = $r + $g + $b;

	if ($brightness > 382) {
		return "light";
	} else {
		return "dark";
	}
}


function flo_get_logo($mobile = false) {

	global $logo_class, $flo_options;
	$logo_type = $flo_options['flo_minimal-logo_type'];

	if ($logo_type == 'image') {

		if(is_array($flo_options['flo_minimal-logo_image_desktop']) && isset($flo_options['flo_minimal-logo_image_desktop']['url'])){
			$desktop_logo_img_url = $flo_options['flo_minimal-logo_image_desktop']['url'];
		}else if(isset($flo_options['flo_minimal-logo_image_desktop']) && is_string($flo_options['flo_minimal-logo_image_desktop']) && strlen($flo_options['flo_minimal-logo_image_desktop'])){
			// this usually happens when the logo is added via the customizer

			$desktop_logo_img_url = $flo_options['flo_minimal-logo_image_desktop'];
		}

		if(isset($desktop_logo_img_url) && strlen($desktop_logo_img_url)){
			$desktop_logo = "<img class='flo-desktop-logo default-logo ' src='" . $desktop_logo_img_url . "' alt='" . get_bloginfo('name') . "' />";
		}else{
			$desktop_logo = '';
		}

		if(is_array($flo_options['flo_minimal-logo_image_mobile']) && isset($flo_options['flo_minimal-logo_image_mobile']['url'])){
			$mobile_logo_img_url = $flo_options['flo_minimal-logo_image_mobile']['url'];
		}else if(isset($flo_options['flo_minimal-logo_image_mobile']) && is_string($flo_options['flo_minimal-logo_image_mobile']) && strlen($flo_options['flo_minimal-logo_image_mobile'])){

			// this usually happens when the logo is added via the customizer
			$mobile_logo_img_url = $flo_options['flo_minimal-logo_image_mobile'];
		}

		if(isset($mobile_logo_img_url) && strlen($mobile_logo_img_url)){
			$mobile_logo = "<img class='flo-mobile-logo default-logo ' src='" . $mobile_logo_img_url . "' alt='" . get_bloginfo('name') . "' />";
		}else{
			if(isset($desktop_logo_img_url) && strlen($desktop_logo_img_url)){
				$mobile_logo = "<img class='flo-mobile-logo default-logo ' src='" . $desktop_logo_img_url . "' alt='" . get_bloginfo('name') . "' />";
			}else{
				$mobile_logo = '';
			}
		}


		if (strlen($desktop_logo) || strlen($mobile_logo) ) {
			$logo_class = ' site-logo ';

			if ($mobile == true) {
				$logo = "<a href='" . home_url() . "' class='small-logo__img '> " . $mobile_logo . "</a>";
			} else {
				$logo = "
				<a href='" . home_url() . "' class='small-logo__img '> " . $desktop_logo . "</a>";
			}
			
		} else {
			$logo_class = '  ';
			$logo       = NULL;
		}
		if (!$logo) {
			$logo .= '<a href="' . home_url() . '" class="logo-text">' . get_bloginfo('name') . '</a>';
			$logo_class = '  ';
		}

	} else {
		$logo_class = '  ';
		$logo       = '<a href="' . home_url() . '" class="logo-text">' . get_bloginfo('name') . '</a>';
	}

	return $logo;
}

function flo_slideshow_get_logo($mobile = false)
{

	global $logo_class, $flo_options;
	$logo_type = $flo_options['flo_minimal-logo_type'];
	$logo_light = isset($flo_options['flo_minimal-slideshow_logo_light']) && $flo_options['flo_minimal-slideshow_logo_light'] ?
	$flo_options['flo_minimal-slideshow_logo_light'] : '';

	$logo_dark = isset($flo_options['flo_minimal-slideshow_logo_dark']) && $flo_options['flo_minimal-slideshow_logo_dark'] ?
	$flo_options['flo_minimal-slideshow_logo_dark'] : '';
	$logo = '';
	if ($logo_type == 'image' && !$mobile) {
		$slideshow_logo = '';
		if (isset($logo_light) && $logo_light!= '' && $logo_light['url'] || isset($logo_dark) && $logo_dark != '' &&
		$logo_dark['url']) {

			if($logo_dark['url']) {
				$logo .= "<img class='flo-desktop-logo default-logo dark_logo' src='" . $logo_dark['url'] . "'
				alt='" . get_bloginfo('name') . "' />";
			}elseif(!$logo_dark['url'] && $logo_light['url']){
				$logo .= "<img class='flo-desktop-logo default-logo dark_logo' src='" . $logo_light['url'] . "'
				alt='" . get_bloginfo('name') . "' />";
			}

			if($logo_light['url']) {
				$logo .= "<img class='flo-desktop-logo default-logo light_logo' src='" . $logo_light['url'] . "'
				alt='" . get_bloginfo('name') . "' />";
			}elseif(!$logo_light['url'] && $logo_dark['url']){
				$logo .= "<img class='flo-desktop-logo default-logo light_logo' src='" . $logo_dark['url'] . "'
				alt='" . get_bloginfo('name') . "' />";
			}
		}else{
			$logo = flo_get_logo();
		}
	}
	else{
		$logo =  flo_get_logo();
	}
	return $logo;
}

function addhttp($url)
{
	if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
		$url = "http://" . $url;
	}
	return $url;
}
/**
 * gallery shortcode using massonry
 *
 * @param string $output
 * @param array $attr
 *
 * @return string
 */
function flo_post_gallery($output, $attr)
{
	global $post, $wp_locale;

	static $instance = 0;
	$instance++;

	if (isset($attr['orderby'])) {
		$attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
		if (!$attr['orderby'])
			unset($attr['orderby']);
	}

 
	extract(shortcode_atts(array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post->ID,
			'itemtag'    => 'dl',
			'icontag'    => 'dt',
			'captiontag' => 'dd',
			'columns'    => 3,
			'size'       => 'large',
			'include'    => '',
			'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ('RAND' == $order)
		$orderby = 'none';

	if (!empty($include)) {
		$include      = preg_replace('/[^0-9,]+/', '', $include);
		$_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

		$attachments = array();
		foreach ($_attachments as $key => $val) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif (!empty($exclude)) {
		$exclude     = preg_replace('/[^0-9,]+/', '', $exclude);
		$attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
	} else {
		$attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
	}

	if (empty($attachments))
		return '';

	if (is_feed()) {
		$output = "\n";
		foreach ($attachments as $att_id => $attachment)
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

//	$output = '<section class="flo-gallery-shortcode grid-view masonry-grid gallery-' . $columns . '-columns"><div class="gallery-shortcode-wrap row">';
	$output = '<div class="quick-portfolio flo-gallery-shortcode row">
							<div class="large-12 columns">
								<ul class="medium-block-grid-'.$columns.' large-block-grid-'.$columns.'">';


	$i       = 0;
	$rand_id = mt_rand(1, 1000);

	$block_width = ' ' . flo_columns_arabic_to_chars($columns) . ' ';



	foreach ($attachments as $id => $attachment) {
		$image_attributes = wp_get_attachment_image_src($id, $size);

		if (isset($attachment->post_excerpt) && strlen($attachment->post_excerpt)) {
			$image_caption = $attachment->post_excerpt;
		} else {
			$image_caption = '';
		}

		if (isset($attachment->post_content) && strlen($attachment->post_content)) {
			$image_description = $attachment->post_content;
		} else {
			$image_description = '';
		}

		$src = wp_get_attachment_image_src($id, 'full'); // get full attachment source
		if (isset($src[0])) {
			$src = $src[0];
		} else {
			$src = '';
		}

		if (  $size !='full' && $image_attributes ) {
			$img_url = aq_resize($src, $image_attributes[1],  $image_attributes[2], true, true, true); //resize img , height 400px
		} else {
			$img_url = $src;
		}
		$link = '
		<li class="image">
			<a href="' . $src . '" rel="gallery-'. $rand_id . '"  title="' . $image_caption . $image_description . '" class="flo-gallery-shortcode-image fancybox" >
				<img src="' . $img_url . '" alt="' . $attachment->post_title . '">
			</a>
		</li>';
		$output .= $link;
	}

	$output .= "</ul></div></div>\n";
	return $output;
}

/**
 * Description   : this function will return the class name for the blocks depending on the input (number of columns we want to have)
 *
 *
 * @param    int $arabic - number of columns we want to have
 *
 * @return str
 *****/
if (!function_exists('flo_columns_arabic_to_chars')) {
	function flo_columns_arabic_to_chars($arabic)
	{
		$words_full_width = array(0 => 'small-12 medium-12', 1 => 'small-12 medium-12', 2 => 'small-12 medium-6', 3 => 'small-12 medium-4', 4 => 'small-12 medium-3', 5 => 'small-12 medium-3', 6 => 'small-12 medium-2',
		                          7 => 'small-12 medium-2', 8 => 'small-12 medium-12', 9 => 'small-12 medium-12', 10 => 'small-12 medium-12', 11 => 'small-12 medium-12', 12 => 'small-12 medium-12');
		return $words_full_width[$arabic];
	}
}

function cosmo_isValidURL($url)
{
	return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
}

/**
 * @return array - registered social profiles
 */

function flo_get_available_social_services()
{

	$available_social_services = array();
	global $flo_options;

	if(isset($flo_options['flo_minimal-social'])){
		$social_profiles = $flo_options['flo_minimal-social'];

		if (sizeof($social_profiles) && is_array($social_profiles)) {
			foreach ($social_profiles as $key => $s_profile) {
				if (strlen($s_profile['title'])) {
					$available_social_services[$s_profile['title']] = $s_profile['title'];
				}
			}
		}
	}


	return $available_social_services;
}

/**
 * render social icons
 */
if (!function_exists('flo_get_social_icons')) {
	function flo_get_social_icons($enabled_services = array('facebook', 'twitter', 'gplus', 'yahoo', 'dribbble', 'linkedin', 'vimeo', 'youtube', 'tumblr', 'delicious', 'flickr', 'instagram', 'pinterest', 'skype', 'email',
			'rss'), $no_icons = false, $add_search = false)
	{

		if (!(is_array($enabled_services) && sizeof($enabled_services))) {
			$enabled_services = array();
		}

		// the following social profiles have font icons support
		$default_supported_profiles = array('facebook', 'twitter', 'gplus', 'yahoo', 'dribbble', 'linkedin', 'vimeo', 'youtube', 'tumblr', 'delicious', 'flickr', 'instagram', 'pinterest', 'skype', 'email', 'rss');
		global $flo_options;

		if(isset($flo_options['flo_minimal-social'])){
			$social_profiles = $flo_options['flo_minimal-social'];
		}else{
			$social_profiles = '';
		}
		
		//        $social_profiles = get_option('_social');

		ob_start();
		ob_clean();

		$social_icons_content = '';

		if (!$no_icons && sizeof($social_profiles) && is_array($social_profiles)) {


			foreach ($social_profiles as $key => $s_profile) {

				//if(isset($s_profile['title']) && in_array(  trim($s_profile['title']), $enabled_services) ){
				// backwards compatibility

				if(isset($s_profile['url']) && isset($s_profile['title'])){

					$profile_url = $s_profile['url'];
					if (in_array(trim($s_profile['title']), $enabled_services)) {
						if (isset($s_profile['icon']) && $s_profile['icon'] != '') {
							$icon_img_src = $s_profile['icon'];
						} else {
							$icon_img_src = '';
						}

						switch (trim($s_profile['title'])) {
							case 'facebook':
								// backward compatibility: if user entered just FB profile name, we will built the real URL below
								if (!cosmo_isValidURL($profile_url) && strlen($profile_url)) {
									$profile_url = 'http://facebook.com/people/@/' . $profile_url;
								}

								break;

							case 'twitter':
								// backward compatibility: if user entered just Twitter profile name, we will built the real URL below
								if (!cosmo_isValidURL($profile_url) && strlen($profile_url)) {
									$profile_url = 'http://twitter.com/' . $profile_url;
								}

								break;

						}
						$icon_class = '';
						$over_class = '';
						if (isset($s_profile['roll_over']) && $s_profile['roll_over'] != '') {
							$over_class = 'flo-social-hover';
						}
						if (!isset($s_profile['icon']) || (isset($s_profile['icon']) && trim($s_profile['icon']) == '')
								&& isset($s_profile['title']) && in_array(trim(strtolower($s_profile['title'])), $default_supported_profiles)
						) {
							$icon_class = 'min-icon-soc-' . trim(strtolower($s_profile['title']));
							$icon       = '';
						} else if (isset($icon_img_src) && strlen($icon_img_src) && $icon_img_src != '') {
							$icon = '<i class=" "><img src="' . $icon_img_src . '" data-imghover="' . $s_profile['roll_over'] . '" data-imgoriginal="' . $icon_img_src . '"  class="' . $over_class . '" /></i>';
						} else {
							$icon = '<span class="social-text">' . $s_profile["title"] . '</span><i class=""></i>';
						}

						if (strlen(trim($profile_url))) {
							?>
							<li>
								<a href="<?php echo addhttp($profile_url) ?>" target="_blank"
								   class="<?php echo ' social-links_link icon ' . $icon_class . ' '; ?> "><?php if (isset($icon) && $icon != '') {
										echo $icon;
									} ?></a>
							</li>
						<?php
						}

					}

				}  //// EOF if isset $s_profile['url'] 

			}
		} else if(is_array($social_profiles) && sizeof($social_profiles)) {
			foreach ($social_profiles as $key => $s_profile) {

				//if(isset($s_profile['title']) && in_array(  trim($s_profile['title']), $enabled_services) ){
				// backwards compatibility

				if(isset($s_profile['url']) && isset($s_profile['title'])){
					$profile_url = $s_profile['url'];

					if (in_array(trim($s_profile['title']), $enabled_services)) {
						if (isset($s_profile['icon'])) {
							$icon_img_src = $s_profile['icon'];
						} else {
							$icon_img_src = '';
						}

						switch (trim($s_profile['title'])) {
							case 'facebook':
								// backward compatibility: if user entered just FB profile name, we will built the real URL below
								if (!cosmo_isValidURL($profile_url) && strlen($profile_url)) {
									$profile_url = 'http://facebook.com/people/@/' . $profile_url;
								}

								break;

							case 'twitter':
								// backward compatibility: if user entered just Twitter profile name, we will built the real URL below
								if (!cosmo_isValidURL($profile_url) && strlen($profile_url)) {
									$profile_url = 'http://twitter.com/' . $profile_url;
								}

								break;

						}
						$icon_class = '';
						$over_class = '';
						if (isset($s_profile['roll_over']) && $s_profile['roll_over'] != '') {
							$over_class = 'flo-social-hover';
						} else if (isset($icon_img_src) && strlen($icon_img_src)) {
							$icon = '<i class=" "><img src="' . $icon_img_src . '" data-imghover="' . $s_profile['roll_over'] . '" data-imgoriginal="' . $icon_img_src . '"  class="' . $over_class . '" /></i>';
						} else {
							$icon = '<span class="social-text">' . $s_profile["title"] . '</span><i class=""></i>';
						}

						if (strlen(trim($profile_url))) {

							?>
							<li>
								<a href="<?php echo addhttp($profile_url) ?>" target="_blank"
								   class="<?php echo ' social-links_link icon ' . $icon_class . ' '; ?> "><?php if (isset($icon)) {
										echo $icon;
									} ?></a>
							</li>
						<?php
						}

					}

				}

			}
		}

		$social_icons_content = ob_get_clean();

		if ($add_search) { // append search
			$social_icons_content .= '<a href="javascript:void(0);" class="the-header-search"> <i class="icon-search"></i> </a>';
		}
		if (strlen(trim($social_icons_content))) {
			?>
			<?php echo $social_icons_content; ?>
			<?php
			if ($add_search) { // append search
				?>
				<div class="header-serch">
					<form action="<?php echo home_url(); ?>/" method="get" id="searchform-header">
						<fieldset>
							<input class="input" name="s" type="text" id="keywords1" value="" placeholder="search">
							<button><i class="icon-search"></i></button>
							<i class="icon-close"></i>
						</fieldset>
					</form>
				</div>
			<?php
			}
		}
	}
}
if (!function_exists('flo_wpforce_featured')) {
	/* if a post does not have featured image, then we set the first attached image as feat img */
	function flo_wpforce_featured()
	{
		global $flo_options;
		if (isset($flo_options['flo_minimal-set_featured']) && $flo_options['flo_minimal-set_featured'] != '0') {
			global $post;

			$post_types_to_work_with = array('post', 'gallery'); // add more posts here if you want.

			if (isset($post->ID)) {
				$the_post_format = get_post_type($post->ID);
			} else {
				$the_post_format = 'unknown';
			}


			if (in_array($the_post_format, $post_types_to_work_with)) {
				$already_has_thumb = has_post_thumbnail($post->ID);
				if (!$already_has_thumb) {
					$attached_image = get_children("post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1");
					if ($attached_image) {
						foreach ($attached_image as $attachment_id => $attachment) {
							set_post_thumbnail($post->ID, $attachment_id);
						}
					}
				}
			}

		}

	} //end function
}
add_action('the_post', 'flo_wpforce_featured');
add_action('save_post', 'flo_wpforce_featured');
add_action('draft_to_publish', 'flo_wpforce_featured');
add_action('new_to_publish', 'flo_wpforce_featured');
add_action('pending_to_publish', 'flo_wpforce_featured');
add_action('future_to_publish', 'flo_wpforce_featured');


//================= include custom meta boxes =================//

require_once dirname(__FILE__) . '/cmb_config.php';


/**
 * Load Theme Variable Data
 * @param string $var
 * @return string
 */
function theme_data_variable($var)
{
	if (!is_file(STYLESHEETPATH . '/style.css')) {
		return '';
	}

	$theme_data = wp_get_theme();
	return $theme_data->{$var};

}

function flo_add_admin_menu()
{
	if (!FLOTHEME_CUSTOMIZED) {

		add_submenu_page('_flo_options', __('Theme Updater', 'flotheme'), __('Theme Updates', 'flotheme'), 'edit_theme_options', 'flotheme_updater', 'flotheme_updater_page');
	}
}

add_action('admin_menu', 'flo_add_admin_menu', 11);


function additional_mime_types($mimes)
{
	$mimes['ico'] = 'image/x-icon';
	return $mimes;
}

add_filter('upload_mimes', 'additional_mime_types');


function tcx_customizer_live_preview()
{

	wp_enqueue_script(
			'tcx-theme-customizer',
			get_template_directory_uri() . '/js/theme-customizer.js',
			array('jquery'),
			'0.3.0',
			true
	);
	wp_enqueue_style('icons', get_template_directory_uri() . '/flo-options/ReduxCore/assets/css/vendor/elusive-icons/elusive-webfont.css');

}

add_action('customize_controls_enqueue_scripts', 'tcx_customizer_live_preview');

//    require_once get_template_directory() . "/customize-controls/spacing-control.php";

function get__posts($args = array(), $first_label = 'Select item')
{
	$posts  = get_posts($args);
	$result = array();

	if (is_array($first_label)) {
		$result = $first_label;
	} else {
		if (strlen($first_label)) {
			$result[] = $first_label;
		}
	}
	if (is_array($posts) && !empty($posts)) {
		foreach ($posts as $post) {
			$result[$post->ID] = $post->post_title;
		}
	}

	return $result;
}


/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function flo_wp_title($title, $sep)
{
	global $paged, $page;

	if (is_feed()) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo('name');

	// Add the site description for the home/front page.
	$site_description = get_bloginfo('description', 'display');
	if ($site_description && (is_home() || is_front_page())) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ($paged >= 2 || $page >= 2) {
		$title = "$title $sep " . sprintf(__('Page %s', 'flotheme'), max($paged, $page));
	}

	return $title;
}

//add_filter('wp_title', 'flo_wp_title', 10, 2);



/* related posts by herarchical taxonomy */
/* get tax slugs and number of similar posts  */
function similar_query($post_id, $taxonomy, $posts_per_page = 4)
{

	$the_post_type = get_post_type($post_id);
	if ('video' == $the_post_type) {
		if ($taxonomy == 'post_tag') {
			$taxonomy = 'tag';
		}
		$taxonomy = 'video-' . $taxonomy;
	}

	$topics = wp_get_post_terms($post_id, $taxonomy);

	$terms = array();
	if (!empty($topics)) {
		foreach ($topics as $topic) {
			$term = get_term($topic->term_id, $taxonomy);
			if (isset($term->slug)) {
				array_push($terms, $term->slug);
			}

		}
	}

	if (!empty($terms)) {
		$query = new WP_Query(array(
				'post_type'           => $the_post_type,
				'post__not_in'        => array($post_id),
				'posts_per_page'      => $posts_per_page,
				'orderby'             => 'rand',
				'ignore_sticky_posts' => 1,
				'tax_query'           => array(
						array(
								'taxonomy' => $taxonomy,
								'field'    => 'slug',
								'terms'    => $terms,
						)
				)
		));
	} else {
		$query = array();
	}


	return $query;
}

/*Upload image for title decoration */
function include_custom_script_for_admin_panel()
{
global $to_flo_main;
	if (!did_action('wp_enqueue_media')) {
		wp_enqueue_media();
	}
	global $flo_options;
	wp_enqueue_script('myuploadscript', get_template_directory_uri() . '/flo-options/ReduxCore/assets/js/admin.js',
	array('jquery'), '21312', false);

	if(isset($to_flo_main) && $to_flo_main != ''){
		$customizer_fields_array = $to_flo_main;
	}else{
		$customizer_fields_array = array();
	}
	$customizer_config = array();
	foreach($customizer_fields_array as $field){
		if(isset($flo_options) && isset($flo_options[$field]) && is_array($flo_options[$field])){
			$customizer_config[$field] = $flo_options[$field]['url'];
		}else{
			if(isset($flo_options[$field])){
				$customizer_config[$field] = $flo_options[$field];
			}

		}
	}

	wp_localize_script( 'myuploadscript', 'customizerConfig', $customizer_config); // localize visible nearby slideshow img width

}

add_action('admin_enqueue_scripts', 'include_custom_script_for_admin_panel');

function true_image_uploader_field($name, $value = '', $w = 115, $h = 90)
{
	$default = get_template_directory_uri() . '/images/no_img.png';
	if ($value) {
		$image_attributes = wp_get_attachment_image_src($value, array($w, $h));
		$src              = $image_attributes[0];
	} else {
		$src = $default;
	}

	echo '
	<div>
		<img data-src="' . $default . '" src="' . $src . '" width="' . $w . 'px" height="' . $h . 'px" />
		<div>
			<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
			<button type="submit" class="upload_image_button button">Upload</button>
			<button type="submit" class="remove_image_button button">&times;</button>
		</div>
	</div>
	';
}
add_action('save_post', '_save_post');
add_action('admin_head', '_add_admin_styles');
add_action('edit_form_after_title', '_add_after_field');

function _add_subtitle_meta_box()
{
	global $post;
	if ($post->post_type == 'page' || $post->post_type == 'video' || $post->post_type == 'gallery' || $post->post_type == 'post') {
		echo '<input type="hidden" name="wps_noncename" id="wps_noncename" value="' . wp_create_nonce('wp-subtitle') . '" />';
		echo '<input type="text" id="wpsubtitle" name="wps_subtitle" value="" style="width:99%;" />';
		//	echo apply_filters( 'wps_subtitle_field_description', '', $post );
	}
}

function _add_after_field(){
	global $post;
	if ($post->post_type == 'page') {
		echo '<div id="flo-subtitle">';
		echo '<input type="text" id="wpsubtitle" name="wps_after" value="' . get_post_meta($post->ID, 'wps_after', true) . '" autocomplete="off" placeholder="' . __('Subtitle', 'flothemes') . '" />';
		echo '</div>';
	}
}

function _save_post($post_id)
{
	if (isset($_POST['wps_after'])) {
		update_post_meta($post_id, 'wps_after', $_POST['wps_after']);
	}
}

function _add_admin_styles()
{
	?>
	<style>
		#subtitlediv.top
		{
			top: 5px;
			position: relative;
		}

		#subtitlediv.top #subtitlewrap
		{
			border: 0;
			padding: 0;
		}

		.with_bottom_margin
		{
			bottom: 5px;
		}

		#subtitlediv.top #wpsubtitle
		{
			background-color: #fff;
			font-size: 1.4em;
			line-height: 1em;
			margin: 0;
			outline: 0;
			padding: 3px 8px;
			width: 50%;
			height: 1.7em;
			float: left;
		}

		#subtitlediv.top #wpsubtitle::-webkit-input-placeholder
		{
			padding-top: 3px;
		}

		#subtitlediv.top #wpsubtitle:-moz-placeholder
		{
			padding-top: 3px;
		}

		#subtitlediv.top #wpsubtitle::-moz-placeholder
		{
			padding-top: 3px;
		}

		#subtitlediv.top #wpsubtitle:-ms-input-placeholder
		{
			padding-top: 3px;
		}

		#subtitlediv.top .subtitledescription
		{
			margin: 5px 10px 0 10px;
			float: left;
		}
	</style>
<?php
}

function flo_subtitle($post_id)
{
	$after = get_post_meta($post_id, 'wps_after', true);
	$new_title = '';
	if ($after) {
		$new_title = $after;
	}
	return $new_title;
}

/* END : This is the function for show (if exist )custom titles by Sliva */
if (!function_exists('hex2rgb')) {
	function hex2rgb($hex)
	{
		$hex = str_replace("#", "", $hex);

		if (strlen($hex) == 3) {
			$r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
			$g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
			$b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
		} else {
			$r = hexdec(substr($hex, 0, 2));
			$g = hexdec(substr($hex, 2, 2));
			$b = hexdec(substr($hex, 4, 2));
		}
		//$rgb = array($r, $g, $b);
		$rgb = $r . ',' . $g . ',' . $b . ', ';

		//return implode(",", $rgb); // returns the rgb values separated by commas
		return $rgb; // returns an array with the rgb values
	}
}

/**
 * Check if we are on a page and if the page has a slider assigned.
 * If all that is trye, then return an array with the selected slider options
 *
 *
 * @return array containing the selected slider options
 */
if (!function_exists('flo_get_page_slyder_info')) {
	function flo_get_page_slyder_info()
	{
		global $post;

		$response = array('selected_slider_id' => 0,
		                  'slideshow_type'     => 'content_width',
		                  'menu_position'      => 'crowd-header-bottom',
		                  'logo_position'      => 'middle-center'
		);
		if (is_page()) {
			$slideshow_settings = meta::get_meta($post->ID, 'slideshowSettings');
			if (isset($slideshow_settings['slideshow_select']) && $slideshow_settings['slideshow_select'] != 0) {
				$response['selected_slider_id'] = $slideshow_settings['slideshow_select'];

				if (isset($slideshow_settings['slideshow_type'])) {
					$response['slideshow_type'] = $slideshow_settings['slideshow_type'];
				}
				if (isset($slideshow_settings['menu_position'])) {
					$response['menu_position'] = $slideshow_settings['menu_position'];
				}
				if (isset($slideshow_settings['logo_position'])) {
					$response['logo_position'] = $slideshow_settings['logo_position'];
				}
			}

		}

		return $response;
	}
}


if (!function_exists('flo_get_slideshow')) {
	function flo_get_slideshow($slideshow_id)
	{

		global $slideshow;
		$slideshow = meta::get_meta($slideshow_id, '_floslideshow');
		if (!(isset($slideshow) && is_array($slideshow) && count($slideshow))) {
			return;
		}

		if (!empty($slideshow) && is_array($slideshow)) {

			$page_slyder_info = flo_get_page_slyder_info();

			if (isset($page_slyder_info['slideshow_type']) && $page_slyder_info['slideshow_type'] != 'content_width') {
				$slider_type = 'full_width'; // will use full-width.php slidehow template
			} else {
				$slider_type = 'menu_over';
			}
			// use Royal slider
//			get_template_part('parts/slideshow/' . $slider_type);


		}
	}
}

function menu($id, $args = array())
{
	$menu = new menu($args);

	$vargs = array(
			'menu'                => '',
			'container'           => '',
			'container_class'     => '',
			'container_id'        => '',
			'menu_class'          => isset($args['class']) ? $args['class'] : '',
			'menu_id'             => '',
			'echo'                => false,
			'fallback_cb'         => 'flo_page_menu',
			'before'              => '',
			'after'               => '',
			'link_before'         => '',
			'link_after'          => '',
			'depth'               => 0,
			'walker'              => $menu,
			'theme_location'      => $id,
			'nr_items_per_column' => isset($args['nr_items_per_column']) ? $args['nr_items_per_column'] : 9999, /// if you don't want to have several columns in menu, set 9999
	);

	$result = wp_nav_menu($vargs);


	if ($menu->need_more && $id != 'megusta') {
		$result .= "</li></ul>" . $menu->aftersubm;
	}

	return $result;
}

/**
 * adds the logo to the menu object
 *
 * @params:
 * $items - string, the menu items in html format
 * $args - array, menu config arguments
 * @return - string, the modified menu with them logo in the middle
 */
if (!function_exists('flo_add_menu_to_nav')) {
	function flo_add_menu_to_nav($items, $args)
	{

		if (is_object($args->walker)) {
			$number_menu_items = $args->walker->count;

			// now we need to find the index of the menu item where the LOGO will be inserted. i.e. if the menu has 6 menu items, then the logo will be inserted after the 3rd elem.
			$before_logo_index = round($number_menu_items / 2);


			if (!class_exists('simple_html_dom_node')) { // make sure we will not have conflicts with other plugins that are using simple_html_dom class
				require('simple_html_dom.php');
			}

			// now we will parse the menu items dom using simple_html_dom library
			$html = new simple_html_dom();
			$html->load('<ul class="temp-wrapper">' . $items . '</ul>');


			$menu_items = $html->find('.temp-wrapper', 0)->children(); // get just the top level menu items

			$new_menu = ''; // init and empty menu that will be built from the old menu + the logo
			foreach ($menu_items as $key => $value) {
				$original_class = $value->class;


				// update the class
				if ($key < $before_logo_index) {
					$value->class = $original_class . ' left-logo-menu ';
				} else {
					$value->class = $original_class . ' right-logo-menu ';
				}

				$new_menu .= $value->outertext;
				// if we are in the middle of the menu, add the logo
				if ($before_logo_index == $key + 1) {

					$the_logo = flo_get_logo();

					$new_menu .= '<li class="menu-item logo-inside site-logo">' . $the_logo . '</li>';
				}

			}

			return $new_menu;

		} else {
			return $items;
		}

	}
}

/*
	process the ajax request that sends the distance between header 4 menu elements
	Updates the options with the received data
	*/
function flo_header_logo_center_menu_items_margin()
{
	if (isset($_POST['header_logo_center_menu_spacing_nonce']) && isset($_POST['left_spacing']) && strlen($_POST['left_spacing']) && isset($_POST['right_spacing']) && strlen($_POST['right_spacing'])) {
		// check to see if the submitted nonce matches with the
		// generated nonce we created earlier
		if (!wp_verify_nonce($_POST['header_logo_center_menu_spacing_nonce'], 'header_logo_center_menu_spacing_nonce_val')) {
			die ('Busted! Wrong Nonce');
		}

		// update the options with the value we recived
		update_option('header_logo_center_menu_left_spacing', ($_POST['left_spacing']));
		update_option('header_logo_center_menu_right_spacing', ($_POST['right_spacing']));

		echo get_option('header_logo_center_menu_left_spacing', true) . ' & ' . get_option('header_logo_center_menu_right_spacing', true);

	}

	exit();
}

if (!has_action('flo_footer_credits')) {
	add_action('flo_footer_credits', 'flo_get_footer_credits', 10);
}

if (!function_exists('flo_get_footer_credits')) {
	function flo_get_footer_credits()
	{
		echo sprintf(__(' %s Made By Flothemes %s', 'flotheme'), '<a href="http://flothemes.com/"  target="blank" class="flo-logo min-icon-flothemes-logo">', '</a>');
	}

}

/**
 * Cosmo loop
 */
if (!function_exists('cosmo_loop')) {
	function cosmo_loop($template, $column_class = 'nine columns', $side = '')
	{
		global $wp_query, $massonry_class, $flo_options, $post, $i, $gutter, $last,$counter;

		$enable_massonry = false;

		if ($template == 'video-category-archive' || $template == 'gallery-category-archive') {
			$view_type = 'thumb';

			global $number_columns;
			$number_columns = 3;
			$column_class   = ' twelve columns ';
			$template       = 'archive';
			$gutter_class   = 'has-gutter';

		} else if ($template == 'blog_page') {
			$view_type = $flo_options['flo_minimal-blog_listing_layout'];
		} else {
			$view_type = $flo_options['flo_minimal-archive_listing_layout'];
		}
		$content_width_class = tools::primary_class(0, 'blog_posts', $return_just_class = true);
		if (count($wp_query->posts) > 0) {

			?>
					<?php
					$nr_of_columns = '4';
					$nr_of_posts = '10';
					$masonry = 'yes';
					$post_type_c = 'post';
					$featured_post_id = '1';
					$gutter = 'gutter-default';

					if (isset($post_type_c) && $post_type_c != '' && $post_type_c != NULL) {
						$post_type = $post_type_c;
					} else {
						$post_type = 'post';
					}
					$enable_pagination = 'yes';
					if (isset($enable_pagination) && $enable_pagination == 'yes') {
						$pag = 'true';
					} else {
						$pag = 'false';
					}
					$view_type_class = flo_view_type_classes($view_type);
					if (isset($masonry) && $masonry == 'yes') {
						$masonry_class = 'masonry-grid';
					} else {
						$masonry_class = ' ';
					}
					?>
							<?php
							if (get_query_var('paged')) {
								$current = get_query_var('paged');
							} elseif (get_query_var('page')) {
								$current = get_query_var('page');
							} else {
								$current = 1;
							}
							$query_args = array(
									'post_type'           => $post_type,
									'paged'               => $current,
									"posts_per_page"      => $nr_of_posts,
									'ignore_sticky_posts' => 1,
							);

							$the_query = new WP_Query($query_args);
							$post_ids = array();
							$i = $counter = 1;
							$size_of_array = count($the_query->posts);
							?>
							<?php while ($the_query->have_posts()): $the_query->the_post(); ?>
								<?php

								if ($counter == $size_of_array) {
									$last = true;
								} else {
									$last = false;
								}
								$counter++;

								if ($view_type) {
									echo get_template_part('floshortcodes/' . $view_type);
								}
								$i++;
								$post_ids[] = $the_query->post->ID;
								?>
							<?php endwhile;
							wp_reset_postdata(); ?>
						</div>
					</div>
				</div>

<?php
layout::side('right', 0, 'blog_posts');
layout::side('left', 0, 'blog_posts');
?>
			</div>
			<?php            wp_reset_postdata(); /* Restore original Post Data */
		} else {
			get_template_part('loop', '404');
		}
	}



}
/**
 * cosmo_get_post_types_hc
 */
if (!function_exists('cosmo_get_post_types_hc')) {
	/**
	 * Description   : this function will return an array of registered custom post types
	 *
	 * @return array
	 *****/
	function cosmo_get_post_types_hc()
	{
		//of course it can be done via get_post_types, but for some reason it return only posts and pages, and no custom posts, and we have to hardcode this shit


		return array('post'    => __('Post', 'flotheme'), /*'video' => __('Video', 'flotheme'),*/
		             'gallery' => __('Gallery', 'flotheme'));
	}
}

if (!function_exists('floSendContact')) {
	function floSendContact()
	{
		if (isset($_POST['action']) && $_POST['action'] == 'floSendContact') {
			$result = array();

			$tomail   = $_POST['cosmo-contact-email'];
			$frommail = '';

			if (isset($_POST['cosmo-name']) && strlen($_POST['cosmo-name'])) {
				$name = trim($_POST['cosmo-name']);
			} else {
				$result['contact_name'] = '<p class="text-error">' . __('Error, name is required field. ', 'flotheme') . '</p>';
				$name                   = '';
			}

			if (isset($_POST['cosmo-email']) && is_email($_POST['cosmo-email'])) {
				$frommail = trim($_POST['cosmo-email']);
			} else {

				$result['contact_email'] = '<p class="text-error">' . __('Error, please enter a valid email address. ', 'flotheme') . '</p>';

			}

			$message = '';
			if (isset($_POST['cosmo-name'])) {
				$message .= __('Contact name: ', 'flotheme') . trim($_POST['cosmo-name']) . "\n";
			}
			if (isset($_POST['cosmo-email'])) {
				$message .= __('Contact email: ', 'flotheme') . trim($_POST['cosmo-email']) . "\n";
			}
			if (isset($_POST['cosmo-phone'])) {
				$message .= __('Phone: ', 'flotheme') . trim($_POST['cosmo-phone']) . "\n\n";
			}
			$message .= trim($_POST['cosmo-message']);

			if (is_email($tomail) && strlen($tomail) && strlen($frommail) && strlen($name) && strlen($message)) {

				//flo-contact_email_address
				global $flo_options;

				// if this option is enabled, then we will use the visitor email in the Form field
                if( $_POST['use_user_email'] && $_POST['use_user_email'] == '1'){
                    $headers = 'From: ' . trim($_POST['flo-name']) . ' <' . trim($_POST['flo-email']) . '>';
                }else{
                    $headers = '';
                }


				$subject = __('New email from', 'flotheme') . ' ' . get_bloginfo('name') . '.' . __(' Sent via contact form.', 'flotheme');
				wp_mail($tomail, $subject, $message, $headers);

				if (isset($_POST['thx_msg']) && strlen(trim($_POST['thx_msg']))) {
					$thx_msg = urldecode($_POST['thx_msg']);
				} else {
					$thx_msg = __('Email was sent successfully ', 'flotheme');
				}

				$result['message'] = '<span class="text-success" >' . $thx_msg . '</span>';

			}

			echo json_encode($result);
		}


		exit();
	}
}

// add the link to the documentation in the WP dashboard
function flo_dashboard_documentation() {
    return array("<li class='flo-docs' ><a href='"._FLO_DOCS_."' target='_blank' ><img src='".get_template_directory_uri()."/img/documentation_img.jpg' /></a></li>");
}
add_filter( 'dashboard_glance_items', 'flo_dashboard_documentation' );

// remove 'hentry' class 
function flo_remove_hentry( $classes ) {
    global $post;

    $classes = array_diff( $classes, array( 'hentry' ) );

    return $classes;
}
add_filter( 'post_class','flo_remove_hentry' );

add_filter( 'post_row_actions', 'remove_slideshow_view_link', 10, 2 );
function remove_slideshow_view_link( $action ,$post) {
	//check for your post type
	if ($post->post_type =="slideshow"){
		/*do you stuff here
		you can unset to remove actions
		and to add actions ex:
		$actions['in_google'] = '<a href="http://www.google.com/?q='.get_permalink($post->ID).'">check if indexed</a>';
		*/
		unset ($action['view']);
	}
	return $action;
}


function remove_view_button_on_single_slideshow($button){
	global $post;
	if($post && $post->post_type == 'slideshow'){
		return preg_replace("/<span id='view-post-btn'>(.*)<\/span>/",'',$button);
	}else{
		return $button;
	}

}
add_filter('get_sample_permalink_html','remove_view_button_on_single_slideshow');


function get_logo_position($position){
	if(isset($position) && $position != ''){
		switch($position){
			case 1:
				echo "nav__right logo__left";
				break;
			case 2:
				echo "nav__center logo__center";
				break;
			case 3:
				echo "nav__left logo__right";
				break;
		}
	}else{
		echo "nav__right logo__left";
	}
}

if ( ! function_exists( 'flo_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since Generosity 0.1
 */
function flo_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'flotheme' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'flotheme' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

if(!function_exists('flo_create_image_srcset')){
	function flo_create_image_srcset($size_array,$image_meta, $original_img_url, $crop = false){
		$image_width = $image_meta['width'];
		$srcset = ''; 
		$srcset_array = array();
		if(is_array($size_array) && sizeof($size_array)){
			
			foreach ($size_array as $srcset_dimensions) {
				if($image_width > $srcset_dimensions['width']){
					$srcset_img_url = aq_resize($original_img_url, $srcset_dimensions['width'], $srcset_dimensions['height'], $crop, true);
					if(strlen($srcset_img_url)){
						$srcset_array[] = $srcset_img_url .' '.$srcset_dimensions['width'].'w';
					}

				}else if(!in_array($original_img_url .' '.$image_width.'w',$srcset_array) && !$crop){
					$srcset_array[] = $original_img_url .' '.$image_width.'w';
				}
			}
		}

		if(sizeof($srcset_array)){
			$srcset = implode(', ', $srcset_array);
		}

		return $srcset;
	}
}

if (!function_exists('flo_image_srcset')) {
	function flo_image_srcset($image_src, $crop = false) {

	}
}


if (!function_exists('flo_get_custom_css')) {
	function flo_get_custom_css(){
		global $flo_options;

		include_once('custom-css-template.php');
	}

}


// the maximum image width to be included in a srcset attribute will be the image width
// default is 1600
if(!function_exists('flo_custom_max_srcset_image_width')){
	function flo_custom_max_srcset_image_width( $max_width, $size_array ) {
		$width = $size_array[0];

		// set the max image width the value of the this image width
	    return $width;
	}
}

if(!function_exists('flo_disable_max_srcset_image_width')){
	function flo_disable_max_srcset_image_width() {
	    return 1;
	}
}


/**
 *
 * Function that renders the top dashboard link
 * http://i.imgur.com/k7BxRME.png
 */
if(!function_exists('flo_render_dashboard_top_bar')){
	function flo_render_dashboard_top_bar(){
	?>
		<div class="flo-dashboard-top">
		<ul>
			<li class="doc"><a href="<?php echo _FLO_DOCS_; ?>" target="_blank"><?php _e('Documentation','flotheme') ?></a></li>
			<li class="manage"><a href="themes.php?page=flo_quick_setup"><?php _e('Quick Setup','flotheme') ?></a></li>
			<li class="updated"><a href="admin.php?page=flotheme_updater"><?php _e('Updates','flotheme') ?></a></li>
			<li class="news"><a href="<?php echo _FLO_NEWS_; ?>" target="_blank" ><?php _e('News','flotheme') ?></a></li>
			<li class="support"><a href="<?php echo _FLO_SUPPORT_; ?>" target="_blank"><?php _e('Support','flotheme') ?></a></li>
		</ul>
		</div>
	<?php
	}
}

/**
 *
 * Try to retrieve the change log from flothemes.com
 * if that is not possible for some reason, we just read the change log file
 * @params string t_n  theme name
 */
if(!function_exists('flo_get_change_log')){
	function flo_get_change_log($t_n = _TN_){
		$transient_name = $t_n.'_change-remote-log';

		//delete_transient($transient_name );

		if ( FALSE == $response = get_transient( $transient_name ) ) {

			$theme_name = strtolower($t_n);
			$url = 'https://flothemes.com/themes/'.$theme_name.'/?change_log=1';
			$args = array(
					    'sslverify'   => false,
					);

			$response = wp_remote_get( $url, $args );

			set_transient( $transient_name, $response, 60 * 60 * 24 ); // 1 day
		}

		//for debugging purpuses
		if(isset($_GET['flo_debug_change_log']) && $_GET['flo_debug_change_log'] == 1){
			echo '<pre>';
			var_dump($response);
			echo '</pre>';
			die();
		}

		if (is_wp_error($response) || $response['response']['code'] != '200' || !isset($response['body'])) {
			// in case something went wrong retrieving the log from our server,
			// then we just load if from the change log file available in the theme.
			return flo_get_change_log_from_file();
		}

		$result = $response['body'];

		return $result;

	}

}

if(!function_exists('flo_get_change_log_from_file')){
	function flo_get_change_log_from_file(){
		global $wp_filesystem;
		// Initialize the WP filesystem, no more using 'file-put-contents' function
		if (empty($wp_filesystem)) {
		    require_once (ABSPATH . '/wp-admin/includes/file.php');
		    WP_Filesystem();
		}
		$change_log_abs_file_path = get_stylesheet_directory().'/change-log.txt';
		
		// read the change log file;
		$change_log_content = $wp_filesystem->get_contents($change_log_abs_file_path);

		return  nl2br($change_log_content) ;
	}
}

if(!function_exists('flo_show_date')){
	function flo_show_date($post_type){
		global $flo_options;

		if(isset($flo_options['flo_minimal-'.$post_type.'_date'])){
			return $flo_options['flo_minimal-'.$post_type.'_date'];
		}else{
			return true;
		}
	}
}


/*  Documentation Fields for Page templates START*/
add_action( 'post_submitbox_misc_actions', 'flo_doc_fields_box' );
add_action( 'admin_head', 'flo_doc_fields_enque');

function flo_doc_fields_box() {
    global $post;
    if ('page' != get_post_type($post)) return;

    wp_nonce_field( plugin_basename( __FILE__ ), 'flo_doc' );
    ?>
    <div id="info-divider_bg" class=" info-divider_bg_1 info-divider_bg_1_about redux-normal header_info redux-info-field redux-field-info">
        <p class="redux-info-desc"><b>Full Width Page Documentation</b></p>
        <div style="float:right" class="header_icon" title="See how it looks on the site">
            <div class="video_wrap">
                <p class="how_it_works">CHECK HOW IT WORKS</p>
                <a href="http://docs.flothemes.com/mimal-full-width-page-template/" data-fancybox-type="iframe" data-fancybox-group="prettyPhoto_90038123" class="video-lightbox-hint">
                    <span class=" dashicons dashicons-admin-page"></span>
                </a>
            </div>
        </div>
    </div>
    <div id="info-divider_bg" class=" info-divider_bg_1 info-divider_bg_1_contact redux-normal header_info redux-info-field redux-field-info">
        <p class="redux-info-desc"><b>Contact Page Documentation</b></p>
        <div style="float:right" class="header_icon" title="See how it looks on the site">
            <div class="video_wrap">
                <p class="how_it_works">CHECK HOW IT WORKS</p>
                <a href="http://docs.flothemes.com/mimal-contact-page/" data-fancybox-type="iframe" data-fancybox-group="prettyPhoto_90038321" class="video-lightbox-hint">
                    <span class=" dashicons dashicons-admin-page"></span>
                </a>
            </div>
        </div>
    </div>
    <div id="info-divider_bg" class=" info-divider_bg_1 info-divider_bg_1_latest_post_types redux-normal header_info redux-info-field redux-field-info">
        <p class="redux-info-desc"><b>Latest Posts Documentation</b></p>
        <div style="float:right" class="header_icon" title="See how it looks on the site">
            <div class="video_wrap">
                <p class="how_it_works">CHECK HOW IT WORKS</p>
                <a href="http://docs.flothemes.com/mimal-adding-a-blog-page/" data-fancybox-type="iframe" data-fancybox-group="prettyPhoto_90038431" class="video-lightbox-hint">
                    <span class=" dashicons dashicons-admin-page"></span>
                </a>
            </div>
        </div>
    </div>
    <?php
}

function flo_doc_fields_enque(){
    global $current_screen;
    if('page' != $current_screen->id) return;
    echo '<style>';
    echo '.info-divider_bg_1.header_info .redux-info-desc{ left:0px!important; text-align:center}';
    echo '.info-divider_bg_1.header_info .dashicons{ color:#b89569!important}';
    echo '.info-divider_bg_1{ background-size: contain;margin-left:0px!important;display:none;}';
    echo '.info-divider_bg_1 .header_icon { top: 50px;    right: 13px;}';
    echo '</style>';
    echo '<script type="text/javascript">
        jQuery(document).ready( function($) {
            $(".info-divider_bg_1").appendTo("#pageparentdiv");
         });
        </script>';
}
/*  Documentation Fields for Page templates END*/
?>