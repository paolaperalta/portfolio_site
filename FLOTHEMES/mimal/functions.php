<?php
ini_set('max_execution_time', 60);
ini_set('memory_limit', '256M');
/**
 * options_sample functions and definitions
 *
 * @package options_sample
 */

if ( ! isset( $content_width ) ) {
	$content_width = 690;
}
define('_TN_', wp_get_theme());
define('_FLO_DOCS_', 'https://flothemes.zendesk.com/hc/en-us');
define('_FLO_NEWS_', 'https://flothemes.com/blog');
define('_FLO_SUPPORT_', 'https://flothemes.zendesk.com/anonymous_requests/new');

global $dummy_data_folders;
	$dummy_data_folders = array('export' => __('Demo version Mimal', 'flotheme'), 'export-blue' => __('Demo version Mimal blue', 'flotheme'),'export-red' => __('Demo version Mimal red', 'flotheme'));


function flo__autoload($class_name){
	if (substr($class_name, 0, 6) == 'widget') {
		$class_name = str_replace('widget_', '', $class_name);
		if (is_file(get_template_directory() . '/flo-options/ReduxCore/widget/' . $class_name . '.php')) {
			include get_template_directory() . '/flo-options/ReduxCore/widget/' . $class_name . '.php';

		}
	}
	if (is_file(get_template_directory() . '/flo-options/ReduxCore/' . $class_name . '.class.php')) {
		include_once get_template_directory() . '/flo-options/ReduxCore/' . $class_name . '.class.php';
	}

}

spl_autoload_register("flo__autoload");


if (!function_exists('flo_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function flo_setup()
	{

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on options_sample, use a find and replace
		 * to change 'flotheme' to the name of your theme in all the template files
		 */
		load_theme_textdomain('flotheme', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
				'primary' => __('Primary Menu', 'flotheme'),
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
				'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
		));

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support('post-formats', array(
				'aside', 'image', 'video', 'quote', 'link',
		));

		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('flo_custom_background_args', array(
				'default-color' => 'ffffff',
				'default-image' => '',
		)));
	}
endif; // flo_setup
add_action('after_setup_theme', 'flo_setup');

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function flo_widgets_init() {
	register_sidebar(array(
			'name' => __('Sidebar', 'flotheme'),
			'id' => 'sidebar-1',
			'description' => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h1 class="widget-title">',
			'after_title' => '</h1>',
	));
}

//add_action('widgets_init', 'flo_widgets_init');
include_once('floshortcodes/custom-functions.php');
/**
 * Enqueue scripts and styles.
 */

function flo_scripts() {
	$flo_theme = wp_get_theme('mimal');

	if ( defined('FLO_ENVIROMENT') && FLO_ENVIROMENT == 'DEV') {
		wp_register_script('vendor', get_template_directory_uri() . '/js/vendor.js', array('jquery'),$flo_theme->get( 'Version' ), true);
		wp_register_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'),$flo_theme->get( 'Version' ), true);
	} else {
		wp_register_script('vendor', get_template_directory_uri() . '/js/vendor.min.js', array('jquery'),$flo_theme->get( 'Version' ), true);
		wp_register_script('scripts', get_template_directory_uri() . '/js/scripts.min.js', array('jquery'),$flo_theme->get( 'Version' ), true);
	}
 
	wp_enqueue_script('vendor');
	wp_enqueue_script('scripts');

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('wp_enqueue_scripts', 'flo_scripts');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

// Redux framework
if (!class_exists('ReduxFramework') && file_exists(dirname(__FILE__) . '/flo-options/ReduxCore/framework.php')) {
	require_once(dirname(__FILE__) . '/flo-options/ReduxCore/framework.php');
}
if (!isset($redux_demo) && file_exists(dirname(__FILE__) . '/flo-options/config/config.php')) {
	require_once(dirname(__FILE__) . '/flo-options/config/config.php');
}

/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB directory)
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

global $flo_options, $view_type_c;
if (!empty($flo_options['flo_minimal-sidebars'])) {
	$sidebars = $flo_options['flo_minimal-sidebars'];
	/* register dinamic sidebar */
	if (function_exists('register_sidebar')) {
		if (is_array($sidebars) && !empty($sidebars)) {
			foreach ($sidebars as $sidebar) {
				if (isset($sidebar['title']) && !empty($sidebar['title'])) {
					register_sidebar(array(
							'name' => $sidebar['title'],
							'id' => trim(strtolower(str_replace(' ', '-', $sidebar['title']))),
							'before_widget' => '<aside id="%1$s" class="widget"><div class="%2$s">',
							'after_widget' => '</div></aside>',
							'before_title' => '<h5 class="widget-title">',
							'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
					));
				}
			}
		}
	}

}
$admin_bar_show = $flo_options['flo_minimal-show_admin_bar'];

if($admin_bar_show == '1' && is_user_logged_in()  ){
	add_filter('show_admin_bar', '__return_true');
}else{
	add_filter('show_admin_bar', '__return_false');
}

define('FLOTHEME_CUSTOMIZED', false); // set to TRUE if you changed something in the source code.
define('FLOTHEME_THEME_VERSION', theme_data_variable('Version'));

require_once('flo-options/ReduxCore/update.php');
require_once('flo-options/ReduxCore/resources.register.php');

/**********************************************/
/************ Plugin recommendations **********/
/**********************************************/
require_once('flo-options/ReduxCore/plugin-recommendations.php');


function flo_load_scripts(){
	global $post;
	global $flo_options;

	$flo_theme = wp_get_theme('mimal');
	
	/*NEW STYLES*/
	wp_register_style('vendor', get_template_directory_uri() . '/css/vendor.min.css',false,$flo_theme->get( 'Version' ));
	wp_enqueue_style('vendor');
	/* bxSlider CSS file */

	if ( defined('FLO_ENVIROMENT') && FLO_ENVIROMENT == 'DEV') {
		wp_register_style('theme_stylesheet', get_template_directory_uri(). '/css/style.css',false,$flo_theme->get( 'Version' ));
	} else {
		wp_register_style('theme_stylesheet', get_template_directory_uri() . '/css/style.min.css',false,$flo_theme->get( 'Version' ));
	}
	wp_enqueue_style('theme_stylesheet');

	


	/*END NEW STYLES*/
	if(isset($post)):
		$parallax = meta::get_meta($post->ID, 'flo_post_parallax_enable');
	else:
		$parallax = false;
	endif;
	if(isset($parallax) && $parallax != '' && $parallax && $parallax == 'yes'){
		$flo_config['parallaxHero'] = '1';
	}

	if (isset($flo_options['flo_minimal-slideshow_type'])) {
		$flo_config['sliderLayoutType'] = $flo_options['flo_minimal-slideshow_type'];
	} else {
		$flo_config['sliderLayoutType'] = 'fullscreen';
	}

	// we need this for comment-reply
	if (is_singular()) {
		wp_enqueue_script("comment-reply");
	}

	$siteurl = get_option('siteurl');
	if (!empty($siteurl)) {
		$siteurl = rtrim($siteurl, '/') . '/wp-admin/admin-ajax.php';
	} else {
		$siteurl = home_url('/wp-admin/admin-ajax.php');
	}

	$flo_config['heroSlider'] = true;
	if(isset($flo_options) && isset($flo_options['flo-header_type']) && $flo_options['flo-header_type'] != ''){
		$header_type = $flo_options['flo-header_type'];
		if($header_type == 'header_hamburger'){
			$flo_config['headerSlideDown'] = true;
		}
	}
	if(isset($flo_options) && isset($flo_options['flo_minimal-main_slideshow_autoplay']) && $flo_options['flo_minimal-main_slideshow_autoplay'] != ''){
		if($flo_options['flo_minimal-main_slideshow_autoplay'] == '1'){
			$flo_config['autoplay'] = true;
		}else{
			$flo_config['autoplay'] = false;
		}
	}

	if(isset($flo_options) && isset($flo_options['flo_minimal-main_slideshow_effect']) && $flo_options['flo_minimal-main_slideshow_effect'] != ''){
		$flo_config['slideshowEffect'] = $flo_options['flo_minimal-main_slideshow_effect'];
	}

	if(isset($flo_options) && isset($flo_options['flo_minimal-main_slideshow_effect_speed']) && $flo_options['flo_minimal-main_slideshow_effect_speed'] != ''){
		$flo_config['slideshowEffectSpeed'] = $flo_options['flo_minimal-main_slideshow_effect_speed'];
	}

	if(isset($flo_options) && isset($flo_options['flo_minimal-gallery_slideshow_effect']) && $flo_options['flo_minimal-gallery_slideshow_effect'] != ''){
		$flo_config['gallerySlideshowEffect'] = $flo_options['flo_minimal-gallery_slideshow_effect'];
	}

	if(isset($flo_options) && isset($flo_options['flo_minimal-gallery_slideshow_effect_speed']) && $flo_options['flo_minimal-gallery_slideshow_effect_speed'] != ''){
		$flo_config['gallerySlideshowEffectSpeed'] = $flo_options['flo_minimal-gallery_slideshow_effect_speed'];
	}


	if(isset($flo_options) && isset($flo_options['flo_minimal-autoplay_speed']) && $flo_options['flo_minimal-autoplay_speed'] != ''){
		$flo_config['autoplay_speed'] = $flo_options['flo_minimal-autoplay_speed'];
	}
	if(isset($flo_options) && isset($flo_options['flo_minimal-enable_sticky_header']) && $flo_options['flo_minimal-enable_sticky_header'] != ''){
		$flo_config['stickyHeader'] = $flo_options['flo_minimal-enable_sticky_header'];
	}
	$flo_config['automatically_text_color'] = $flo_options['flo_minimal-automatically_text_color'];

	add_action('wp_enqueue_scripts', 'flo_load_scripts');
	if (!is_admin()) {
		add_action('wp_head', 'flo_get_custom_css');
	}
	wp_localize_script( 'scripts', 'floConfig', $flo_config); // localize visible nearby slideshow img width
	wp_localize_script( 'scripts', 'ajaxurl', $siteurl );


	if( isset($flo_options['flo-style_sheet']) && $flo_options['flo-style_sheet'] != '' && $flo_options['flo-style_sheet'] != 'default'){
			$stylekit_name = $flo_options['flo-style_sheet'];
			$stylekit_name = str_replace('.css', '', $stylekit_name);
			define('FLO_STYLEKIT', $stylekit_name);

			if(file_exists(get_template_directory() . '/css/'. $flo_options['flo-style_sheet'])){
				wp_register_style( 'predefined_stylesheet',get_template_directory_uri() . '/css/'. $flo_options['flo-style_sheet'],false,$flo_theme->get( 'Version' ) );
      			wp_enqueue_style( 'predefined_stylesheet' );
			}
  	}

  	wp_register_style( 'default_stylesheet',get_stylesheet_directory_uri() . '/style.css',false,$flo_theme->get( 'Version' ) );
	wp_enqueue_style( 'default_stylesheet' );
}

add_action('wp_enqueue_scripts', 'flo_load_scripts');

function flo_comment($comment, $args, $depth) {
	global $comment_data;

	$comment_data = array(
			"args" => $args,
			"depth" => $depth,
			"comment" => $comment
	);

	echo get_template_part('parts/comment', '');
}

function pagination($first=1,$last=1,$middle=5,$baseURL=false,$wp_query=false ) {
	if(!$wp_query)global $wp_query;
	$page = $wp_query->query_vars["paged"];
	if ( !$page ) $page = 1;
	$qs = $_SERVER["QUERY_STRING"] ? "?".$_SERVER["QUERY_STRING"] : "";
	if ( $wp_query->found_posts > $wp_query->query_vars["posts_per_page"] ) {// Only necessary if there's more posts than posts-per-page
		$dots=false;
		for ( $i=1; $i <= $wp_query->max_num_pages; $i++ ){ // Loop through pages
			if($i<=$first || $i<=$middle && $page<$middle || $i>$wp_query->max_num_pages-$last || $i>$wp_query->max_num_pages-$middle && $page>$wp_query->max_num_pages-$middle+1 || $i>$page-ceil($middle/2) && $i<=$page+floor($middle/2)){
				if ( $i == $page ) { // Current page or linked page?
					echo '<li class="active">'.$i.'</li>';
				} else {
					echo '<li><a href="'.$baseURL.(($i!=1)?('page/'.$i.'/'):'').$qs.'">'.$i.'</a></li>';
				}
				$dots=false;
			}elseif(!$dots){
				echo '<li class="delim">...</li>';
				$dots=true;
			}
		}
	}
}
function new_excerpt_more( $more ) {
	return ' ...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/* editor-style CSS*/
add_editor_style(
		array(
				get_template_directory_uri() .'/editor-style.css'
		)
);
// add container around the videos to make them responsive
add_filter( 'embed_oembed_html', 'custom_oembed_filter', 10, 4 ) ;

function custom_oembed_filter($html, $url, $attr, $post_ID) {

	if(strstr($url,'youtube') || strstr($url,'vimeo')){
		$return = '<div class="video-container-embeded">'.$html.'</div>';
	}else{
		$return = $html;
	}
	return $return;
}

if (!function_exists('flo_get_categories_cmb')) {
function flo_get_categories_cmb($type,$tax){
	return  array(
		'type'                     => $type,
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 1,
		'hierarchical'             => 1,
		'taxonomy'                 => $tax,
		'pad_counts'               => false

	);
	}
}

// Flo Quick setup
if (is_file(get_template_directory() . '/flo-options/ReduxCore/quick-setup/flo-quick-setup.php')) {
    include get_template_directory() . '/flo-options/ReduxCore/quick-setup/flo-quick-setup.php';
}

if ( ! function_exists( 'flo_lightroom_gallery' ) ) :
    /**
     * This function is ment for the compatibility with FloLightroom plugin
     *
     * It returns the available gallery types and the meta name where the gallery type should be saved
     *
     */
    function flo_lightroom_gallery(){
        $img_path_start = get_template_directory_uri() . '/lib/images/pattern/';
        $gallery_layouts = array(
            'grid_view' => 'thumbnails-under.png',
            'orig-size'=> 'massonry1.png',
        );
        $gallery_type_meta = "_cmb2_vivi_gallery_view_type";
        return array('gallery_layouts' => $gallery_layouts,
            'gallery_type_meta' => $gallery_type_meta
        );
    }
endif;


/**
 * Wordpress, becuase of redirect_canonical feature, will try to redirect the 
 * broken links to tho most appropriate parents. This is the case for
 * Blog template, when it has pagination enabled, and the page is set as Front Page, in Reading
 * So we want this feature disable for this scenario.
 */
add_filter('redirect_canonical','flo_disable_redirect_canonical');
function flo_disable_redirect_canonical($redirect_url) {
    if ( is_front_page() && is_page_template( 'templates/template-blog.php' )  ) $redirect_url = false;
    return $redirect_url;
}


// handle responsive images flor the blog post
if(isset($flo_options['flo_minimal-blog_post_responsive_images'])){
	$flo_responsive_img_option = $flo_options['flo_minimal-blog_post_responsive_images'];
}else{
	// by default responsive images are disabled
	$flo_responsive_img_option = 'no_responsive';
}

switch ($flo_responsive_img_option) {
	case 'no_responsive':
			add_filter( 'max_srcset_image_width', 'flo_disable_max_srcset_image_width' );
		break;
	case 'mobile_only':
			add_filter( 'max_srcset_image_width', 'flo_custom_max_srcset_image_width', 9, 2 );
		break;
	
	
	default: // all_devices
		// we do nothing, let WP to handle this
		break;
}


/**
*
* Funtion used for debuging
*
**/

if(!function_exists('deb_e')){
	function deb_e( $data ){
		print '<pre style="margin:10px; border:1px dashed #999999; padding:10px; color:#333; background:#ffffff;">';
        $bt = debug_backtrace();
        $caller = array_shift($bt);
        //print "[ File : " . self::short( $caller['file'] ) . " ][ Line : " . $caller['line'] . " ]\n";
        print "--------------------------------------------------------------\n";
		print_r( $data );
		print "</pre>";
	}
}