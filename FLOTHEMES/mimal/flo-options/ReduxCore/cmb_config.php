<?php
if (file_exists(dirname(__FILE__) . '/../../cmb2/init.php')) {
    require_once dirname(__FILE__) . '/../../cmb2/init.php';
} elseif (file_exists(dirname(__FILE__) . '/../../CMB2/init.php')) {
    require_once dirname(__FILE__) . '/../../cmb2/init.php';
}

//add_action('cmb2_init', 'yourprefix_register_repeatable_group_field_metabox');

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function cmb2_hide_if_no_cats($field)
{
// Don't show this field if not in the cats category
    if (!has_tag('cats', $field->object_id)) {
        return false;
    }
    return true;
}

/**
 * Conditionally displays a message if the $post_id is 2
 *
 * @param  array $field_args Array of field parameters
 * @param  CMB2_Field object $field      Field object
 */
function cmb2_before_row_if_2($field_args, $field)
{
    if (2 == $field->object_id) {
        echo '<p>Testing <b>"before_row"</b> parameter (on $post_id 2)</p>';
    } else {
        echo '<p>Testing <b>"before_row"</b> parameter (<b>NOT</b> on $post_id 2)</p>';
    }
}


add_filter('cmb2_meta_boxes', 'latest_posts_metabox');
function load_js()
{
    if (is_admin()) {
        wp_register_style('fancybox_meta', get_template_directory_uri() . '/flo-options/ReduxCore/assets/js/fancybox/jquery.fancybox.css');
        wp_enqueue_style('fancybox_meta');
        wp_register_script('fancybox_meta', get_template_directory_uri() . '/flo-options/ReduxCore/assets/js/fancybox/jquery.fancybox.pack.js');
        wp_enqueue_script('fancybox_meta');
        wp_register_script('meta', get_template_directory_uri() . '/flo-options/ReduxCore/assets/js/meta.js');
        wp_enqueue_script('meta');
        wp_register_script('extra', get_template_directory_uri() . '/flo-options/ReduxCore/assets/js/extra.js');
        wp_enqueue_script('extra');
        wp_register_script('actions', get_template_directory_uri() . '/flo-options/ReduxCore/assets/js/actions.js');
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script( 'jquery-ui-autocomplete' ); // for autocomplete search
        wp_enqueue_script( 'actions' );
        wp_enqueue_style(
            'generic-fields',
            get_template_directory_uri() . '/flo-options/ReduxCore/assets/css/generic-fields.css');
    }
}



add_action('admin_init', 'load_js', 1);


/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function latest_posts_metabox(array $meta_boxes)
{

// Start with an underscore to hide fields from custom fields list
    $prefix = '_cmb2_minimal_';

    /**
     * Sample metabox to demonstrate each field type included
     */
    $gutter_options = array(
        'gutter-default'  => __('Default 30px', 'flotheme'),
        'gutter-0'           => __('No gutter', 'flotheme'),
        'gutter-2'  => __('Gutter 2px', 'flotheme'),
        'gutter-5'  => __('Gutter 5px', 'flotheme'),
        'gutter-10'  => __('Gutter 10px', 'flotheme'),
        'gutter-20'  => __('Gutter 20px', 'flotheme'),
        'gutter-40'  => __('Gutter 40px', 'flotheme'),
        'gutter-50'  => __('Gutter 50px', 'flotheme'),
    );
	$view_type        = array(
			'grid_view'               =>  '../icons/view_type_1.jpg',
            'orig-size'              =>  '../icons/gallery_1.jpg',
			'list_full_width_view'              =>  '../icons/blog_layout_1.jpg',
			'list_content_width_view'              =>  '../icons/blog_layout_2.jpg',
			'list_full_content_view'              =>  '../icons/list_full.jpg',

	);

    $post_categories = get_terms('category');
    $post_category_array = array();
    foreach($post_categories as $cat_p){
        array_push($post_category_array,$cat_p->name , $cat_p->name);
    }
    $gallery_categories = get_terms('gallery-category');
    $gallery_category_array = array();
    foreach($gallery_categories as $cat_g){
        array_push($gallery_category_array,$cat_g->name , $cat_g->name);
    }

    $args_post = flo_get_categories_cmb('post', 'category');

    $all_post_categories = get_categories( $args_post );
    $post_category = array();
    foreach ($all_post_categories as $key => $the_post) {
        $post_category[$the_post->term_id] = $the_post->name;
    }
    $args_gallery =flo_get_categories_cmb('gallery', 'gallery-category');
    $all_gallery_categories = get_categories( $args_gallery );
    $gallery_category = array();
    foreach ($all_gallery_categories as $key => $the_category) {
        $gallery_category[$the_category->term_id] = $the_category->name;
    }


    $all_pages = get_pages();
    $pages_array = array();
    foreach ($all_pages as $key => $the_page) {
        $pages_array[$the_page->ID] = $the_page->post_title;
    }
    $meta_boxes['latest_posts'] = array(
        'id' => 'latest_posts',
        'title' => __('Latest Posts', 'flotheme'),
        'type' => 'group_field',
        'object_types' => array('page'), // Post type
        'context' => 'side',
        'priority' => 'core',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => __('Select Post Type', 'flotheme'),
                'desc' => __('Select post type', 'flotheme'),
                'id' => $prefix . 'post_type',
                'type' => 'select',
                'options' => array(
                    'post' => __('Posts', 'flotheme'),
                    'gallery' => __('Galleries', 'flotheme'),
                    'page' => __('Pages', 'flotheme'),
                ),
            ),
            array(
                'name' => __('Select Post Category', 'flotheme'),
                'desc' => __('If no specific categories are selected in the dropdown below, all categories will be
                displayed on the page.', 'flotheme'),
                'id' => $prefix . 'category_p',
                'type' => 'multicheck',
                'options' => $post_category,
                'dependence_parent_id' => $prefix . 'post_type',
                'dependence_option_index' =>'post',
            ),

            array(
                'name' => __('Select Gallery Category', 'flotheme'),
                'desc' => __('If no specific categories are selected in the dropdown below, all categories will be
                displayed on the page.', 'flotheme'),
                'id' => $prefix . 'category_g',
                'type' => 'multicheck',
                'options' => $gallery_category,
                'dependence_parent_id' => $prefix . 'post_type',
                'dependence_option_index' =>'gallery',
            ),
            array(
                'name'    => __('Select Pages', 'flotheme'),
                'desc'    => __('If no specific pages are selected in the dropdown below, all pages will be
                displayed on the page.', 'flotheme'),
                'id'      => $prefix . 'page_ids',
                'type'    => 'multicheck',
                'options' => $pages_array,
                'dependence_parent_id' => $prefix . 'post_type',
                'dependence_option_index' =>'page' //  make sure you add the necessary code in cmb2/js/cmb2.min.js
            ),
            array(
                'name' => __('View type', 'flotheme'),
                'desc' => __('Select view type', 'flotheme'),
                'id' => $prefix . 'view_type',
                'type' => 'grid_radio',
                'options' => array(
                    'grid_view' => __('Grid view', 'flotheme'),
                    'orig-size' => __('Grid View Original Size.', 'flotheme'),
                    'list_full_width_view' => __('List Full Width View', 'flotheme'),
                    'list_content_width_view' => __('List Content Width View', 'flotheme'),
                    'list_full_content_view' => __('List Content Width View', 'flotheme'),
                ),
                'value' => $view_type,
                'path' => 'pattern/',
                'default' => 'grid_view'
            ),

//	        array(
//		        'name' => __('List View Width', 'flotheme'),
//		        'desc' => __('Choose List View Width', 'flotheme'),
//		        'id' => $prefix . 'list_view_width',
//		        'type' => 'select',
//		        'options' => array(
//				        '1' => 'Narrow',
//				        '2' => 'Full Width',
//		        ),
//		        'dependence_parent_id' => $prefix . 'view_type',
//		        'dependence_option_index' =>array('3'),
//	        ),
            array(
                'name' => __('Number of posts', 'flotheme'),
                'desc' => __('Enter number of posts (numeric)', 'flotheme'),
                'id' => $prefix . 'nr_of_posts',
                'type' => 'text',
                'dependence_parent_id' => $prefix . 'view_type',
                'dependence_option_index' =>array('1','2','3','4'),
            ),

            array(
                'name' => __('Number of columns', 'flotheme'),
                'desc' => __('Select number of columns.', 'flotheme'),
                'id' => $prefix . 'nr_of_columns',
                'type' => 'select',
                'options' => array(
                    '3' => 'Three Columns',
                    '4' => 'Four Columns',
                ),
                'dependence_parent_id' => $prefix . 'view_type',
                'dependence_option_index' =>array('1','2'),
            ),
            array(
                'name' => __('Gutter type', 'flotheme'),
                'desc' => __('Select gutter type (in px).', 'flotheme'),
                'id' => $prefix . 'gutter',
                'type' => 'select',
                'options' => $gutter_options,
                'dependence_parent_id' => $prefix . 'view_type',
                'dependence_option_index' =>array('1','2'),
            ),
            array(
                'name' => __('Enable pagination ?', 'flotheme'),
                'desc' => __('Enable pagination ?', 'flotheme'),
                'id' => $prefix . 'pagination',
                'type' => 'select',
                'options' => array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ),
                'dependence_parent_id' => $prefix . 'view_type',
                'dependence_option_index' =>array('1','2','3','4'),
            )

        ),
    );

	$meta_boxes['gallery'] = array(
			'id' => 'latest_galleries',
			'title' => __('Gallery', 'flotheme'),
			'object_types' => array('page'), // Post type
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			'fields' => array(
					array(
							'name' => __('Select Gallery', 'flotheme'),
							'desc' => __('Select Gallery', 'flotheme'),
							'id' => $prefix . 'gallery',
							'type' => 'gallery_search_text',
					),
			),
	);

    $single_gallery_layout = array(
                'grid_view'   => '../icons/view_type_1.jpg',
                'orig-size'   => '../icons/gallery_1.jpg',
                'thumbs'      => '../icons/gallery-thumbs.jpg',
                'thumbs-full' => '../icons/gallery-thumbs-full.jpg'
            );

	$meta_boxes['gallery_single'] = array(
			'id' => 'single_galleries',
			'title' => __('Gallery', 'flotheme'),
			'object_types' => array('gallery'), // Post type
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			'fields' => array(
					array(
							'name' => __('View type', 'flotheme'),
							'desc' => __('Select view type', 'flotheme'),
							'id' => $prefix . 'gallery_view_type',
							'type' => 'grid_radio',
							'options' => array(
									'grid_view' => __('Grid view', 'flotheme'),
									'orig-size' => __('Original size', 'flotheme'),
									'thumbs' => __('Thums', 'flotheme'),
									'thumbs-full' => __('Thumbs full', 'flotheme'),
							),
							'value' => $single_gallery_layout,
							'path' => 'icons/',
					),
			),
	);

// Add other metaboxes as needed
    return $meta_boxes;
}

function cmb2_post_search_render_field( $field, $escaped_value, $object_id, $object_type, $field_type ) {
    $select_type = $field->args( 'select_type' );
    $value = get_post_meta($object_id,$field->args('value'));
    if(isset($value['_cmb2_minimal_feat_post'])){
	    $val = $value['_cmb2_minimal_feat_post'];
    }else{
	    $val = '';
    }

    if(isset($val[0])){
        $feat_p = get_post($val[0]);
    }else{
        $feat_p = get_post(0);
    }
    $post_type = 'post';
    $post_status = 'publish';
    echo $field_type->input( array(
        'data-posttype'   => $field->args( 'post_type' ),
        'data-selecttype' => 'radio' == $select_type ? 'radio' : 'checkbox',
        'class' => 'ui-autocomplete-input',
        'value' => $feat_p->post_title
    ) );
    echo $field_type->input( array(
        'type' => 'hidden',
        'value' => 'post',
        'class' => 'generic-params',
        'desc' => ''

    ) );
    $unique_id = mt_rand(0,9999);
    echo $field_type->input( array(
        'type' => 'hidden',
        'name' => $field->args('id'),
        'class' => 'generic-record generic-value u-class-'.$unique_id,
        'desc' => ''
    ) );
}
add_action( 'cmb2_render_post_search_text', 'cmb2_post_search_render_field', 10, 5 );


function cmb2_gallery_search_render_field( $field, $escaped_value, $object_id, $object_type, $field_type ) {
	$select_type = $field->args( 'select_type' );
	$value = get_post_meta($object_id,$field->args('value'));
	if(isset($value['_cmb2_minimal_gallery'])){
		$val = $value['_cmb2_minimal_gallery'];
	}else{
		$val = '';
	}

    if(isset($val[0])){
        $feat_p = get_post($val[0]);
    }else{
        $feat_p = get_post(0);
    }

	$post_type = 'gallery';
	$post_status = 'publish';
	echo $field_type->input( array(
			'data-posttype'   => $post_type,
			'data-selecttype' => 'radio' == $select_type ? 'radio' : 'checkbox',
			'class' => 'ui-autocomplete-input',
			'value' => $feat_p->post_title
	) );
	echo $field_type->input( array(
			'type' => 'hidden',
			'value' => 'post',
			'class' => 'generic-params',
			'desc' => ''

	) );
	$unique_id = mt_rand(0,9999);
	echo $field_type->input( array(
			'type' => 'hidden',
			'name' => $field->args('id'),
			'class' => 'generic-record generic-value u-class-'.$unique_id,
			'desc' => ''
	) );
}
add_action( 'cmb2_render_gallery_search_text', 'cmb2_gallery_search_render_field', 10, 5 );
/**
 * Set the post type via pre_get_posts
 * @param  array $query  The query instance
 */


add_action( 'cmb2_init', 'register_contact_page_metabox' );
/**
 * Hook in and add a metabox that only appears on the 'About' page
 */
function register_contact_page_metabox() {
//die("sd");
	$prefix = 'flo_contacts_';

	/**
	 * Metabox to be displayed on a single page ID
	 */

	$cmb_about_page = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Contact Page Metabox', 'flotheme' ),
			'object_types' => array( 'page', ), // Post type
        	'context'      => 'normal',
			'priority'     => 'low',
			'show_names'   => true, // Show field names on the left
	) );
    $contact_view_type        = array(
        'full_width'               =>  '../icons/contact_2.jpg',
        'layout_width'              =>  '../icons/contact_1.jpg',
    );
	$cmb_about_page->add_field(
        array(
            'name' => __( 'Layout', 'flotheme' ),
            'id'   => $prefix . 'layout',
            'type' => 'grid_radio',
            'options' => array(
                'full_width' => __( 'Full Width', 'flotheme' ),
                'layout_width'   => __( 'Layout Width', 'flotheme' ),
            ),
            'value' => $contact_view_type,
            'path' => 'pattern/',
            'default' => 'full_width'
        )
	);

    $cmb_about_page->add_field(array(
        'name' =>__('Custom form shortcode', 'flotheme'),
        'desc' => __('If you need to use a custom form generated by a plugin,
	    insert here the form shortcode, and the default form will be replaced by the form generated by the shortcode','flotheme'),
        'id'   => $prefix . 'custom_shortcode',
        'type' => 'textarea',
    ) );

	$cmb_about_page->add_field(array(
			'name' => __( '"Contact me" Title !'.'<a href="'.get_template_directory_uri()
                .'/flo-options/ReduxCore/assets/img/admin_hints/contact_me_title.jpg"
                data-fancybox-group="prettyPhoto_7329867942838" class="img-lightbox-hint"><span class="dashicons
                dashicons-editor-help"></span></a>', 'flotheme' ),
			'desc' => __( 'Add your "contact me" title .', 'flotheme' ),
			'id'   => $prefix . 'contact_me_title',
			'type' => 'text',
	) );


	$cmb_about_page->add_field( array(
			'name' => __( '"Contact me" Phone !'.'<a href="'.get_template_directory_uri()
                .'/flo-options/ReduxCore/assets/img/admin_hints/contact_me_phone.jpg"
                data-fancybox-group="prettyPhoto_7329867942839" class="img-lightbox-hint"><span class="dashicons
                dashicons-editor-help"></span></a>', 'flotheme' ),
			'desc' => __( 'Add your "contact me" phone .', 'flotheme' ),
			'id'   => $prefix . 'contact_me_phone',
			'type' => 'text',
	) );
	$cmb_about_page->add_field( array(
			'name' => __( 'Email'.'<a href="'.get_template_directory_uri()
                .'/flo-options/ReduxCore/assets/img/admin_hints/contact_me_mail.jpg"
                data-fancybox-group="prettyPhoto_73298679428310" class="img-lightbox-hint"><span class="dashicons
                dashicons-editor-help"></span></a>', 'flotheme' ),
			'desc' => __( 'This field  required for contact form.', 'flotheme' ),
			'id'   => $prefix . 'email',
			'type' => 'text_email',
			'attributes'  => array(
					'placeholder' => 'email',
					'rows'        => 3,
//				'required'    => 'required',
			),
	) );
    $cmb_about_page->add_field( array(
        'name' => __( 'Use the user\'s email addressin the "from" field ', 'flotheme' ),
        'id'   => $prefix . 'use_user_email',
        'type' => 'radio',
        'options'  => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
    ) );
	$cmb_about_page->add_field( array(
			'name' => __( 'Enable social links?'.'<a href="'.get_template_directory_uri()
                .'/flo-options/ReduxCore/assets/img/admin_hints/contact_enable_social.jpg"
                data-fancybox-group="prettyPhoto_73298679428311" class="img-lightbox-hint"><span class="dashicons
                dashicons-editor-help"></span></a>', 'flotheme' ),
			'id'   => $prefix . 'enable_social_links',
			'type' => 'radio',
			'options'  => array(
					'1' => 'Yes',
					'0' => 'No',
			),
	) );

    $cmb_about_page->add_field( array(
        'name' => __( 'Social links title'.'<a href="'.get_template_directory_uri()
            .'/flo-options/ReduxCore/assets/img/admin_hints/contact_social_title.jpg"
                data-fancybox-group="prettyPhoto_73298679428312" class="img-lightbox-hint"><span class="dashicons
                dashicons-editor-help"></span></a>', 'flotheme' ),
        'id'   => $prefix . 'social_links_title',
        'type' => 'text',
//        'dependence_parent_id' => $prefix . 'enable_social_links',
//        'dependence_option_index' => array('1'),
        'default' => 'SOCIAL MEDIA',
    ) );

	$cmb_about_page->add_field( array(
			'name' => __( 'Thank you message!', 'flotheme' ),
			'desc' => __( 'Add your "thank you message." .', 'flotheme' ),
			'id'   => $prefix . 'thx_msg',
			'type' => 'textarea',
	) );


}

add_action( 'cmb2_init', 'register_posts_metabox' );
function register_posts_metabox() {
    $prefix = 'flo_post_';

    /**
     * Metabox to be displayed on a single page ID
     */
    $cmb_posts_settings = new_cmb2_box( array(
        'id'           => $prefix . 'metabox',
        'title'        => __( 'Header title types.', 'flotheme' ),
        'object_types' => array( 'page' ), // Post type
        'context'      => 'normal',
        'priority'     => 'high',
        'show_names'   => true, // Show field names on the left
    ) );
    $page_view_type = array(
        '1' => '/icons/page_headers_3.jpg',
        '2' => '/icons/page_headers_1.jpg',
        '3' => '/icons/page_headers_2.jpg',
    );
    $cmb_posts_settings->add_field( array(
            'name' => __('Featured image and Title layout', 'flotheme'),
            //'desc' => __('Select header type', 'flotheme'),
            'id' => $prefix . 'header_type',
            'type' => 'grid_radio',
            'options' => array(
                '1' => __('header full image', 'flotheme'),
                '2' => __('small image centered', 'flotheme'),
                '3' => __('only small image.', 'flotheme'),
            ),
            'value' => $page_view_type,
            'path' => '/',
            'default' => '1'
        )
    );
    $cmb_posts_settings->add_field( array(
            'name' => __('Enable parallax ? ', 'flotheme'),
            'id' => $prefix . 'parallax_enable',
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'flotheme'),
                'no' => __('No', 'flotheme'),
            ),
            'path' => '/',
        )
    );

}

add_action( 'cmb2_init', 'register_posts_page_metabox' );
function register_posts_page_metabox() {
	$prefix = 'flo_posts_';

	/**
	 * Metabox to be displayed on a single page ID
	 */
	$cmb_posts_settings = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Title Color Settings', 'flotheme' ),
			'object_types' => array( 'post','gallery','page' ), // Post type
			'context'      => 'normal',
			'priority'     => 'low',
			'show_names'   => true, // Show field names on the left
	) );

	$cmb_posts_settings->add_field( array(
			'name' => __( 'Title Color', 'flotheme' ),
			'id'   => $prefix . 'title_color',
			'type' => 'colorpicker',
		)
	);
    $cmb_posts_settings->add_field( array(
            'name' => __( 'Hover Background Color', 'flotheme' ),
            'desc' => __( 'This option will be applied only when this post / page / gallery is inserted into another
            page having "List View" layout',
                'flotheme' ),
            'id'   => $prefix . 'background_color',
            'type' => 'colorpicker',
        )
    );
}
?>
