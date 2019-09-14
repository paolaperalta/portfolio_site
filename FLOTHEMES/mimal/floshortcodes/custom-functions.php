<?php

define('FLO_TEMPLATE_PATH', 'floshortcodes');

	/**
	 * Get other templates (e.g. product attributes) passing attributes and including the file.
	 *
	 * @access public
	 * @param mixed $template_name
	 * @param array $args (default: array())
	 * @param string $template_path (default: '')
	 * @param string $default_path (default: '')
	 * @return void
	 */
	function flo_get_template( $template_name, $template_path = '', $default_path = '', $args = array() ) {
		
		if ( $args && is_array($args) )
			extract( $args );

		$located = flo_locate_template( $template_name, $template_path, $default_path );

		//do_action( 'flo_before_template_part', $template_name, $template_path, $located, $args );

		include( $located );

		//do_action( 'flo_after_template_part', $template_name, $template_path, $located, $args );
	}

	/**
	 * Locate a template and return the path for inclusion.
	 *
	 * This is the load order:
	 *
	 *		yourtheme		/	$template_path	/	$template_name
	 *		yourtheme		/	$template_name
	 *		$default_path	/	$template_name
	 *
	 * @access public
	 * @param mixed $template_name
	 * @param string $template_path (default: '')
	 * @param string $default_path (default: '')
	 * @return string
	 */
	function flo_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		global $woocommerce;

		if ( ! $template_path ) $template_path = FLO_TEMPLATE_PATH;
		if ( ! $default_path ) $default_path = plugin_dir_path( __FILE__ ) . 'templates/';

		// Look within passed path within the theme - this is priority
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name
			)
		);

		// Get default template
		if ( ! $template )
			$template = $default_path . $template_name;

		// Return what we found
		return apply_filters('flo_locate_template', $template, $template_name, $template_path);
	}	
// add here the custom functions for cosmoShortcodes plugin

function cosmo_list_posts_custom($atts, $content = NULL)
{
	global $title_over_shc, $view_type_c, $post, $nr_col_c, $column_class, $nr_of_posts_c, $aditional_classes,
		   $masonry_class, $query, $last, $gutter, $masonry, $number_columns, $i, $post_id, $nr_cols, $counter_i;
	
	if(isset($post->ID)){
		$post_id  = $post->ID;
	}else{
		$post_id  = 0;
	}

	$sh_builder = true;
	
	$defaults = array(
			'post_type'                  => 'post',
			'taxonomy'                   => '',
			'term_name'                  => '',
			'view_type'                  => 'thumb_view',
			'number_posts'               => get_option('posts_per_page'),
			'number_columns'             => 3,
		    'pagination' => 'none',
			'orderby'                    => 'date',
			'order'                      => 'DESC',
			'gutter'                     => '',
			'post_in'                    => '',
			'category_p'                 => array(),
			'category_g'                 => array(),
			'masonry'                   => 'no',
			'page_ids'                   => array(),
	);


	extract(shortcode_atts($defaults, $atts));
	$view_type_c = $view_type;

	$valid_view_types = array(
			'grid_view',
			'list_full_width_view',
			'list_content_width_view',
			'list_full_content_view',
			'orig-size'
	);
	if(!in_array($view_type,$valid_view_types)){
		$view_type = 'grid_view';
	}

	$nr_col_c = $number_columns;
	$aditional_classes = ' ';
	$massonry_class    = ' ';
	


if($post_type == 'post'){

		if ( $sh_builder ) {
			$taxonomy = $taxonomy == 'post_tag' ? 'post_tag' : 'category';
			if ( strlen(trim($term_name) ) ) {
				$term_name  = explode(',', $term_name );
				$term_name = array_map('trim', $term_name);
			}

		} else {
			$taxonomy = 'category';
			if( ! is_array($category_p) && strlen(trim($category_p))){
				$term_name = explode(',',substr($category_p, 0, -1));
			}else{
				$term_name = $category_p;
			}

		}
		
	}
	if($post_type == 'gallery'){

		if ( $sh_builder ) {
			$taxonomy = $taxonomy == 'gallery-tag' ? 'gallery-tag' : 'gallery-category';
			if ( strlen(trim($term_name) ) ) {
				$term_name  = explode(',', $term_name );
				$term_name = array_map('trim', $term_name);
			}

		} else {

			$taxonomy = 'gallery-category';
			if(!is_array($category_g) && strlen(trim($category_g))){
				$term_name = explode(',',substr($category_g, 0, -1));
			}else{
				$term_name = $category_g;
			}
		}

	}
 
 
	if($post_type == 'page' && $page_ids){
		$page_arr = explode(',',substr($page_ids, 0, -1));
	}
	$enable_massonry = false;
	if($pagination == 'none'){
		$current = 1;
	}else{
		$current = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}
	$query_args = array('post_type' => $post_type, 'orderby' => $orderby, 'paged' => $current, 'order' => $order);

	if (strlen($number_posts)) {
		$query_args['posts_per_page'] = $number_posts;
	}
	if(isset($page_arr) && $page_arr != '' && is_array($page_arr)){
		$query_args['post__in'] = $page_arr;
	}
	if (strlen($taxonomy) && $term_name) {
		$query_args['tax_query'] = array(
				array(
						'taxonomy' => $taxonomy,
						'field'    => 'slug',
						'terms'    => $term_name
				)
		);
	}
	if (isset($post_in) && strlen(trim($post_in))) {
		//post__in
		$post_in_array = explode(',', $post_in);
		$post_in_args  = array();
		foreach ($post_in_array as $key => $value) {
			if (is_numeric($value)) {
				$post_in_args[] = $value;
			}
		}
 
		if (sizeof($post_in_args)) {
			$query_args['post__in'] = $post_in_args;
		}

		$query_args['tax_query'] = '';
		// reset the order by
		$query_args['orderby'] = 'post__in';


	}

	$query_args['ignore_sticky_posts'] = 1;
	$query         = new WP_Query($query_args);
	$counter       = 1;
	$counter_i     = $counter;
	$size_of_array = count($query->posts);
	ob_start();
	ob_clean();
	// The Loop

	// hook into before cosmo loop filter, for example you may want to add here advertising or something else
	$before_loop = apply_filters('cosmo_before_loop', '');
	if ($before_loop != '') {
		echo $before_loop;
	}
	$i = 1;
	
	if(function_exists('cosmo_get_template')){
		cosmo_get_template( 'loop/loop-start.php' );
	}else{
		flo_get_template( 'loop/loop-start.php' );
	}
	if ($query->have_posts()) {
		$current_post = 1;
		$post_ids     = array();
		while ($query->have_posts()) {
			if ($counter == $size_of_array) {
				$last = true;
			} else {
				$last = false;
			}
			$counter++;
			$nr_cols = $number_columns;
			if (isset($current_post) && isset($number_columns) && $number_columns != '' && $current_post != '' && $current_post % $number_columns == 0) {
				$column_class = 'cosmo-column-last';
			} else if (isset($current_post) && isset($number_columns) && $number_columns != '' && $current_post != '' && $current_post % $number_columns == 1) {
				$column_class = 'cosmo-column-first';
			} else {
				$column_class = '';
			}
			$query->the_post();


			if(function_exists('cosmo_get_template')){
                if($view_type == 'list_content_width_view' || $view_type == 'list_full_width_view'):
                    cosmo_get_template('list_view.php' );
                else:
                    cosmo_get_template( $view_type.'.php' );
                endif;
			}else{
                if($view_type == 'list_content_width_view' || $view_type == 'list_full_width_view'):
                    flo_get_template('list_view.php' );
                else:
                    flo_get_template( $view_type.'.php' );
                endif;

			}

			$post_ids[] = $query->post->ID;

			$current_post++;
			$column_class = '';
			$i++;
		}
	} else {
		// no posts found
	}
	?>
	<?php
	if(function_exists('cosmo_get_template')){
		cosmo_get_template( 'loop/loop-end.php' );
	}else{
		flo_get_template( 'loop/loop-end.php' );
	}
	//			==========================EOF Pagination==============================

	// hook into after cosmo loop filter, for example you may want to add here advertising or something else
	$after_loop = apply_filters('cosmo_after_loop', '');
	if ($after_loop != '') {
		echo $after_loop;
	}

	/* Restore original Post Data */
	wp_reset_postdata();
	wp_reset_query();
	$title_over_shc = NULL;
	$posts_list     = ob_get_clean();

	return $posts_list;
}

remove_shortcode('cosmo_list_posts'); // remove the plugin generated shortcode
add_shortcode('cosmo_list_posts', 'cosmo_list_posts_custom'); // use the function from the theme
add_shortcode('flo_list_posts', 'cosmo_list_posts_custom'); // use the function from the theme

if (!function_exists('cosmo_set_list_posts_shortcode')) {
	/**
	 * /////////////////////////////////=================================/////////////////////////////////
	 *
	 *    overwrite the default parameters for cosmo_list_posts shortcode
	 *    For the necesary format and possible arguments see the Cosmo Shortcodes plugin (/tinymce/config.php)
	 *    Returns and array with configuration settings for the shortcode
	 */

	function cosmo_set_list_posts_shortcode() {
		$cosmo_list_posts_config = array(
				'no_preview'  => true,
				'params'      => array(
						'post_type'                  => array(
								'type'    => 'select',
								'label'   => __('Post type', 'flotheme'),
								'desc'    => __('Select the post type you want to be displayed', 'flotheme'),
								'options' => cosmo_get_post_types_hc()
						),
						'taxonomy'                   => array(
								'type'    => 'select',
								'label'   => __('Taxonomy', 'flotheme'),
								'desc'    => __('Select All to retrieve all the posts, or you can select a taxonomy beloging to a post type selected above.', 'flotheme'),
								'options' => array('' => __('All', 'flotheme'), 'category' => 'category', 'post_tag' => 'post_tag') // by default we show onlt taxonomies for the 'post' type
						),
						'term_name'                  => array(
								'std'   => '',
								'type'  => 'text',
								'label' => __('Term name ', 'flotheme'),
								'desc'  => __('If taxonomy parameter is not set to All, then you should set here the name of the term from which you want to retrieve the posts. For example if "category" is selected as taxonomy, you can type here "uncategorized" to get posts from that category.', 'flotheme'),

						),
						'view_type'                  => array(
								'type'    => 'select',
								'label'   => __('View type', 'flotheme'),
								'desc'    => '',
								'options' => array(
										'grid_view'   => __('Grid View', 'flotheme'),
										'orig-size'         => __('Original size', 'flotheme'),
										'list_view'         => __('List view', 'flotheme'),
										'list_view_full'         => __('List view full content', 'flotheme'),
								),
							//	'action' => "actionSelect( '#cosmo_view_type' , { 'cosmo-list-view' : '.number-columns' } , 'hs_' );" // we want to show/hide the row with class '.number-columns' when the selected value is changed
								'action'  => "actionSelect( '#cosmo_view_type' ,
						{
							'list-view' : '  ',
						} , 'sh_' );" // we want to show/hide the row with class '.number-columns' when the selected value is changed

						),
						'post_in'                    => array(
								'std'   => '',
								'type'  => 'text',
								'label' => __('Post in', 'flotheme'),
								'desc'  => 'Add your post ids. If you added post ids to this field, categories will be ignored. Example: 41,22'
						),
						'number_posts'           => array(
								'std'          => '',
								'type'         => 'text',
								'label'        => __('Number of posts', 'flotheme'),
								'desc'         => 'Number of posts.',
								'hide_default' => false,
								'class'        => ' nr_of_posts'
						),
						'number_columns'             => array(
								'type'         => 'select',
								'label'        => __('Number of columns', 'flotheme'),
								'desc'         => '',
								'class'        => ' number-columns ', // additional class to settings row, this class is used to show/hide this settings depending on view type value
								'hide_default' => false, // we want to hide this option by default, because we need it only for grid and thumb view, and by default we have list view
								'options'      => array(
										'3' => 3,
										'4' => 4,
								)
						),
						'gutter'                     => array(
								'type'         => 'select',
								'label'        => __('Use gutter', 'flotheme'),
								'desc'         => __('Adds space between blocks', 'flotheme'),
								'class'        => ' gutter-options ', // additional class to settings row, this class is used to show/hide this settings depending on view type value
								'hide_default' => false, // we want to hide this option by default, because we need it only for grid and thumb view, and by default we have list view
								'options'      => array(
										'gutter-default'   => __('Default 30px', 'flotheme'),
										'gutter-0'  => __('No gutter', 'flotheme'),
										'gutter-2'  => __('Gutter 2px', 'flotheme'),
										'gutter-5'  => __('Gutter 5px', 'flotheme'),
										'gutter-10' => __('Gutter 10px', 'flotheme'),
										'gutter-20' => __('Gutter 20px', 'flotheme'),
										'gutter-30' => __('Gutter 30px', 'flotheme'),
								)
						),
						'masonry'                   => array(
								'type'         => 'select',
								'label'        => __('Masonry', 'flotheme'),
								'desc'         => __('If enabled, it will place the elements in optimal position based on available vertical space', 'flotheme'),
								'class' => ' masonry-option ', // additional class to settings row, this class is used to show/hide this settings depending on view type value
								'hide_default' => true, // we want to hide this option by default, because we need it only for grid and thumb view, and by default we have list view
								'options'      => array(
										'no'  => __('Off', 'flotheme'),
										'yes' => __('On', 'flotheme')
								)
						),
						'orderby'                    => array(
								'type'    => 'select',
								'label'   => __('Order by', 'flotheme'),
								'options' => cosmo_get_order_by_options(),
								'desc'    => ''
						),
						'order'                      => array(
								'type'    => 'select',
								'label'   => __('Order', 'flotheme'),
								'desc'    => '',
								'options' => array(
										'DESC' => __('Descending', 'flotheme'),
										'ASC'  => __('Ascending', 'flotheme')
								)
						),
				),
				'shortcode'   => '[flo_list_posts
									post_type="{{post_type}}" 
									taxonomy="{{taxonomy}}" 
									term_name="{{term_name}}" 
									view_type="{{view_type}}" 
									number_columns="{{number_columns}}"
									number_posts="{{number_posts}}"
									orderby="{{orderby}}" 
									order="{{order}}"
			 						gutter="{{gutter}}"
			 						post_in="{{post_in}}"
			 						masonry="{{masonry}}"
									]
								[/flo_list_posts]',
				'popup_title' => __('Insert List Posts Shortcode', 'flotheme')
		);
		return $cosmo_list_posts_config;
	}
}

if (!function_exists('cosmo_set_box_shortcode')) {
	/**
	 * /////////////////////////////////=================================/////////////////////////////////
	 *
	 *    overwrite the default parameters for cosmo_box shortcode
	 *    For the necesary format and possible arguments see the Cosmo Shortcodes plugin (/tinymce/config.php)
	 *    Returns and array with configuration settings for the shortcode
	 */

	function cosmo_set_box_shortcode()
	{
		$cosmo_box_config = array(
				'no_preview'  => true,
				'params'      => array(

						'box_bg_color'   => array(
								'std'   => '#fff',
								'type'  => 'colorpicker',
								'label' => __('Background color', 'flotheme'),
								'desc'  => ''
						),
						'box_text_color' => array(
								'std'   => '#000',
								'type'  => 'colorpicker',
								'label' => __('Text color', 'flotheme'),
								'desc'  => ''
						),
						'content_width'  => array(
								'type'    => 'select',
								'label'   => __('Content width', 'flotheme'),
								'desc'    => __('You will notice the difference only if the shortcode is used in a page using "Full width" template page.', 'flotheme'),
								'options' => array(
										'1140px' => '1140px',
										'100%'   => '100%'
								)
						),
						'padding'        => array(
								'type'    => 'select',
								'label'   => __('Add padding', 'flotheme'),
								'desc'    => __('If this option is enabled then a padding will be added around the box.', 'flotheme'),
								'options' => array(
										'disabled' => __('No', 'flotheme'),
										'enabled'  => __('Yes', 'flotheme')
								)
						),
				),
				'shortcode'   => '[flo_box box_bg_color="{{box_bg_color}}" box_text_color="{{box_text_color}}" content_width="{{content_width}}" padding="{{padding}}" ]' . __('Add your content here', 'flotheme') . '[/flo_box]',
				'popup_title' => __('Insert Box Shortcode', 'flotheme')
		);
		return $cosmo_box_config;
	}
}

if (!function_exists('cosmo_box_custom')) {
	function cosmo_box_custom($atts, $content = NULL)
	{
		extract(shortcode_atts(array(
				'box_bg_color'   => '',
				'box_text_color' => '',
				'content_width'  => '',
				'padding'        => 'disabled'
		), $atts));

		if (strlen($box_bg_color)) {
			$bg_color = 'background-color: ' . $box_bg_color . ';';
		} else {
			$bg_color = '';
		}

		if (strlen($box_text_color)) {
			$text_color = 'color: ' . $box_text_color . ';';
		} else {
			$text_color = '';
		}

		$padding_class = '';
		if ($padding == 'enabled') {
			$padding_class = ' padded ';
		}
		$result = "<div class='cosmo-box $padding_class ' style='$bg_color $text_color' >";
		if (strlen($content_width) && $content_width == '1140px') {
			$result .= '<div class="row">';
		}
		$result .= do_shortcode($content);
		if (strlen($content_width) && $content_width == '1140px') {
			$result .= '</div>';
		}
		$result .= "</div>";
		return $result;
	}

}
remove_shortcode('cosmo_box'); // remove the plugin generated shortcode
add_shortcode('cosmo_box', 'cosmo_box_custom'); // use the function from the theme
add_shortcode('flo_box', 'cosmo_box_custom'); // use the function from the theme

/**

 */
if (!function_exists('cosmo_contact_form_custom')) {
	function cosmo_contact_form_custom($atts, $content = NULL)
	{
		extract(shortcode_atts(array(
				'email'   => '',
				'thx_msg' => ''
		), $atts));

		if (!is_email($email)) {
			$output = __('plese use a valid email address', 'flotheme');
		} else {

			ob_start();
			ob_clean();
			?>
			<div class="contact-icon">
				<i class="icon-email"></i>
			</div>
			<form id="flo-contact-form" class="flo-contact-form">

				<div class="row">
					<div class="six columns">
						<p class="contact-form-name">
							<label for="cosmo-name"><?php _e('Name', 'flotheme'); ?> <span class="required">*</span></label>
							<input id="cosmo-name" name="cosmo-name" type="text" value="" aria-required="true">
						</p>

						<p class="contact-form-email">
							<label for="cosmo-email"><?php _e('Email', 'flotheme'); ?> <span class="required">*</span></label>
							<input id="cosmo-email" name="cosmo-email" type="text" value="" aria-required="true">
						</p>

						<p class="contact-form-phone">
							<label for="cosmo-phone"><?php _e('Phone', 'flotheme'); ?> </label>
							<input id="cosmo-phone" name="cosmo-phone" type="text" value="">
						</p>

						<p class="contact-form-subject">
							<label for="cosmo-subject"><?php _e('Subject', 'flotheme'); ?> </label>
							<input id="cosmo-subject" name="cosmo-subject" type="text" value="">
						</p>
					</div>
					<div class="six columns">
						<p class="comment-form-comment">
							<label for="cosmo-message"><?php _e('Message', 'flotheme'); ?> </label>
							<textarea id="cosmo-message" name="cosmo-message" cols="45" rows="8"></textarea>
						</p>
					</div>
					<div class="twelve columns">
						<p class="form-submit submit gray">
							<input type="button" value="<?php _e('Send Message', 'flotheme'); ?>" tabindex="5"
								   id="cosmo-send-msg" name="btn_submit" onclick="floSendMail( '#flo-contact-form' ,
								    'div#cosmo_contact_response' );">
						</p>
						<input type="hidden" name="cosmo-contact-email" value="<?php echo $email; ?>">
						<input type="hidden" name="thx_msg" value="<?php echo $thx_msg; ?>">

						<div id="cosmo_contact_response"></div>
					</div>

				</div>
			</form>

			<?php
			$output = ob_get_clean();
		}

		return $output;
	}

	remove_shortcode('cosmo_contact_form'); // remove the plugin generated shortcode
	add_shortcode('cosmo_contact_form', 'cosmo_contact_form_custom'); // use the function from the theme
	add_shortcode('flo_contact_form', 'cosmo_contact_form_custom'); // use the function from the theme

}
?>
