<?php
    /* aditional options and meta-data init menu, register functions and options labels */


//    add_action('admin_init', array( 'options' , 'register' ) );

//    add_action('admin_init', array( 'options' , 'register' ) );
    /* register resource */
    add_action('init', array( 'resources' , 'register' ) );

//    add_action('admin_init', array( 'includes' , 'load_css' ) , 1 );
//    add_action('admin_init', array( 'includes' , 'load_js' ) , 1 );

    /* on delete action */
//    add_action( 'delete_post', 'clear_meta' );

	/* ajax actions */
	/* meta actions */

    add_action('wp_ajax_get_slide_data', 'flo_get_slide_data' ); // used for Slideshow to add data to the new added slides

	add_action('wp_ajax_meta_save', array( 'meta' , 'save' ) );
    add_action('wp_ajax_meta_delete' , array( 'meta' , 'delete') );

    add_action('wp_ajax_meta_sort' , array( 'meta' , 'sort') );
    add_action('wp_ajax_meta_update' , array( 'meta' , 'update') );

    add_action('wp_ajax_search' , array( 'post' , 'search' ) );

    /* options actions */
    add_action( 'wp_ajax_text_preview' , array( 'text' , 'preview' ) );

    //contact form
    add_action('wp_ajax_floSendContact' , 'floSendContact' );
    add_action('wp_ajax_nopriv_floSendContact' , 'floSendContact' );

    // update the header 1 menu items margin
    add_action('wp_ajax_header_1_menu_items_margin' , 'flo_header_1_menu_items_margin' );
    add_action('wp_ajax_nopriv_header_1_menu_items_margin' , 'flo_header_1_menu_items_margin' );

    // update the header 4 menu items margin
    add_action('wp_ajax_header_logo_center_menu_items_margin' , 'flo_header_logo_center_menu_items_margin' );
    add_action('wp_ajax_nopriv_header_logo_center_menu_items_margin' , 'flo_header_logo_center_menu_items_margin' );

    add_action('wp_ajax_flo_find_posts' , 'flo_find_posts' );
    add_action('wp_ajax_nopriv_flo_find_posts' , 'flo_find_posts' );



	/* extra actions */
	add_action('wp_ajax_get_rows'       ,   array('extra' , 'get') );
    add_action('wp_ajax_extra_add'      ,   array('extra' , 'add') );
    add_action('wp_ajax_extra_del'      ,   array('extra' , 'del') );
    add_action('wp_ajax_extra_update'   ,   array('extra' , 'update') );
    add_action('wp_ajax_extra_sort'     ,   array('extra' , 'sort') );

    /* new action */
    //add_action('wp_ajax_post_relation'  , 'get_post_relation' );
    add_action('wp_ajax_search_relation'  , 'search_relation' );


    add_action('wp_ajax_resetOptions' , 'cResetOptions' );

    /*actions for latest custom posts widget*/
    add_action( 'wp_ajax_get_taxonomies'                    , array( 'widget_custom_post' , 'get_taxonomies' ) );
    add_action( 'wp_ajax_get_terms'                         , array( 'widget_custom_post' , 'get_terms' ) );

	add_action( 'wp_ajax_get_taxonomies'                    , array( 'widget_about' , 'get_taxonomies' ) );
	add_action( 'wp_ajax_get_terms'                         , array( 'widget_about' , 'get_terms' ) );

    add_filter('the_content', 'do_shortcode');  /*we need this to be able to have nested shortcodes*/
    add_filter('widget_text', 'do_shortcode');


    /* widgets */
    /* general widgets */
    register_widget("widget_tweets");
    register_widget("widget_flickr");
    register_widget("widget_socialicons");
	register_widget("widget_flo_view_types");
	register_widget("widget_flo_popular");
	register_widget("widget_about_image_block");




    /* register sidebars */
//if ( !function_exists('flo_register_sidebars') ) {
//    function flo_register_sidebars()
//    {
        if (function_exists('register_sidebar')) {
            register_sidebar(array(
                'name' => __('Main Sidebar', 'flotheme'),
                'id' => 'main',
                'before_widget' => '<aside id="%1$s" class="widget"><div class="%2$s">',
                'after_widget' => '</div></aside>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
            ));

            register_sidebar(array(
                'name' => __('Header Translation', 'flotheme'),
                'id' => 'header-translation',
                'description' => __('This sidebar is intended for translation. For example if you have a site in several languages, then you can insert the language switcher widget here(of course you must install a translation plugin that offers such a widget). ', 'flotheme'),
                'before_widget' => '<aside id="%1$s" class="widget"><div class="%2$s">',
                'after_widget' => '</div></aside>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
            ));
            // register_sidebar(array(
            //     'name' => __('Header Top full Screen width', 'flotheme'),
            //     'id' => 'top_sidebar',
            //     'description' => __('This sidebar is intended for top sidebar. ', 'flotheme'),
            //     'before_widget' => '<aside id="%1$s" class="widget"><div class="%2$s">',
            //     'after_widget' => '</div></aside>',
            //     'before_title' => '<h5 class="widget-title">',
            //     'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
            // ));

            register_sidebar(array(
                'name' => __('Below Page content', 'flotheme'),
                'id' => 'below-page-content',
                'before_widget' => '<aside id="%1$s" class="widget"><div class="%2$s">',
                'after_widget' => '</div></aside>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
            ));

            register_sidebar(array(
                'name' => __('Footer Full Content width top', 'flotheme'),
                'id' => 'footer-fifth',
                'description' => __('This sidebar is located above  the 3 columns footer sidebars.', 'flotheme'),
                'before_widget' => '<aside id="%1$s" class="widget full-width"><div class="%2$s">',
                'after_widget' => '</div></aside>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
            ));
            register_sidebar(array(
                'name' => __('Footer First', 'flotheme'),
                'id' => 'footer-first',
                'before_widget' => '<aside id="%1$s" class="widget"><div class="%2$s">',
                'after_widget' => '</div></aside>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
            ));


            register_sidebar(array(
                'name' => __('Footer Second', 'flotheme'),
                'id' => 'footer-second',
                'before_widget' => '<aside id="%1$s" class="widget"><div class="%2$s">',
                'after_widget' => '</div></aside>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
            ));

            register_sidebar(array(
                'name' => __('Footer Third', 'flotheme'),
                'id' => 'footer-third',
                'before_widget' => '<aside id="%1$s" class="widget"><div class="%2$s">',
                'after_widget' => '</div></aside>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
            ));

            register_sidebar(array(
                'name' => __('Footer Full Content width area bottom', 'flotheme'),
                'id' => 'footer-fullwidth',
                'description' => __('This sidebar is located above the footer and below the 3 columns footer sidebars.', 'flotheme'),
                'before_widget' => '<aside id="%1$s" class="widget full-width"><div class="%2$s">',
                'after_widget' => '</div></aside>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
            ));

            register_sidebar(array(
                'name' => __('Sidebar About', 'flotheme'),
                'id' => 'sidebar-about',
                'before_widget' => '<aside id="%1$s" class="widget"><div class="%2$s">',
                'after_widget' => '</div></aside>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
            ));


            register_sidebar(array(
                'name' => __('Footer bottom', 'flotheme'),
                'id' => 'footer-global',
                'description' => __('This sidebar is located at the bottom of page.', 'flotheme'),
                'before_widget' => '<aside id="%1$s" class="widget"><div class="%2$s">',
                'after_widget' => '</div></aside>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5><p class="widget-delimiter">&nbsp;</p>',
            ));


            /*register_sidebar(array(
                'name' => __( 'Social media icons', 'flotheme' ),
                'id' => 'social-media',
                'before_widget' => '<aside id="%1$s" class="widget"><div class="%2$s">',
                'after_widget' => '</div></aside>',
                'before_title' => '<h5 class="widget-title">',
                'after_title' => '</h5><p class="delimiter">&nbsp;</p>',
            ));*/

//        }
//    }
}
//add_action('widgets_init', 'flo_register_sidebars');
?>
