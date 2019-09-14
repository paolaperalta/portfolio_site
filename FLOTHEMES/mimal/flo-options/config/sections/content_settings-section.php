<?php
global $flo_prefix;

$this->sections[] = array(
    'title' => __('Content Settings', 'flotheme'),
    'icon' => 'content',
    'class' => 'content',
);

$this->sections[] = array(
    'title' => __('Blog', 'flotheme'),
    'class' => 'blog',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-blog',
            'title' => __('Blog', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Blog",
            'doc_iframe' => "http://docs.flothemes.com/mimal-content-settings/#blog"
        ),
        array(
            'id' => $flo_prefix.'-content_width',
            'type' => 'text',
            'title' => __('Blog Post content width (in px)', 'flotheme'),
            'subtitle' => __('Enter content width (in px), </br> Example: 1024  ', 'flotheme'),
            'output' => array('.page.post-page .layout, .page .with-layout_full'),
            'mode' => 'max-width',
            'default' => ''
        ),
        array(
            'id' => $flo_prefix.'-similar',
            'type' => 'button_set',
            'title' => __('Show similar posts on single blog post page?', 'flotheme'),
            'subtitle' => __('With the "section" field you can create indent option sections.', 'flotheme'),
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'default' => '1'
        ),
        array(
            'id' => $flo_prefix.'-similar_criteria',
            'type' => 'select',
            'title' => __('Similar posts criteria', 'flotheme'),
            'options' => array('post_tag' => 'Same Tags', 'category' => 'Same Category'),
            'required' => array('flo_minimal-similar', "=", 1),
            'default' => 'category'
        ),
        array(
            'id' => $flo_prefix.'-image_distance',
            'type' => 'text',
            'title' => __('Distance below post images', 'flotheme'),
            'subtitle' => __('Set the vertical distance between images inserted in the post content', 'flotheme'),
            'validate' => 'numeric',
            'default' => '5',
            'mode' => 'margin-bottom',
            'output' => array('.page .post img, .article-content a img, .content img, .content img
                        .alignleft, .content img.alignright, .content img.aligncenter, .page.post-page .post img'),
            'help_img' => array('distance_between_images.jpg')
        ),
        array(
            'id' => $flo_prefix.'-show_headers_categories_list',
            'type' => 'button_set',
            'title' => __('Show categories dropdown in header on page template "Latest Post Types" and
                        Single Blogpost', 'flotheme'),
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'default' => '1',
            'help_img' => array('categories_dropdown.jpg')
        ),

        array(
            'id' => $flo_prefix.'-show_categories',
            'type' => 'button_set',
            'title' => __('Show Categories / Tags below the content of Single Blogpost', 'flotheme'),
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'default' => '1'
        ),

        array(
            'id' => $flo_prefix.'-social_sharing',
            'type' => 'button_set',
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'title' => __('Enable social sharing for posts', 'flotheme'),
            'default' => '1',
            'help_img' => array('enable_social_sharing_for_posts.jpg')
        ),
        array(
            'id' => $flo_prefix.'-set_featured',
            'type' => 'button_set',
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'title' => __('Auto set featured images', 'flotheme'),
            'subtitle' => __('In case featured image is not uploaded to the post/gallery, the first of the uploaded images will be set as featured image.', 'flotheme'),
            'default' => '1'
        ),
        array(
            'id' => $flo_prefix.'-featured_on_single',
            'type' => 'button_set',
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'title' => __('Show featured image on single Blogpost ', 'flotheme'),
            'default' => '1'
        ),
        array(
            'id' => $flo_prefix.'-post_date',
            'type' => 'button_set',
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'title' => __('Show Blog post date on single blog post page, list view and grid view', 'flotheme'),
            'default' => '1'
        ),
        array(
            'id' => $flo_prefix.'-blog_post_responsive_images',
            'type' => 'select',
            'title' => 'Blog post responsive images',
            'subtitle' => __('You can control from here the responsive images introduced in WP 4.4. It is recommended to have the responsive images enabled, at least for the mobile devices. But this may affect image quality. If you disable the responsive images, then the quality will be good, but the performance will be affected, especially on mobile devices.','flotheme'),
            'options' => $responsive_images_options,
            'default' => 'no_responsive',
            'customizer' => false,

        ),

        array(
            'id' => $flo_prefix.'-comments',
            'type' => 'sorter',
            'title' => 'Use comments',
            'subtitle'  => __('In order to enable one of the comments types you need to drag-and-drop the
                        corresponding comments box to Enable section.','flotheme'),
            'compiler' => 'true',
            'options' => array(
                'Enabled' => array(
                    'wp' => 'WP comments',
                ),
                'Disabled' => array(
                    'facebook' => 'Facebook Comments'
                ),
            ),
            'limits' => array(
                'disabled' => 2,
                'enabled' => 2,
            ),


        ),
        array(
            'id' => $flo_prefix.'-fb_id',
            'type' => 'text',
            'title' => __('Facebook application ID', 'flotheme'),
            'subtitle' => __('This is necessary if you want to moderate the FB comments', 'flotheme'),
        )
    )
);
$this->sections[] = array(
    'title' => __('Galleries', 'flotheme'),
    'class' => 'galleries',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-galleries',
            'title' => __('Galleries', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Galleries",
            'doc_iframe' => "http://docs.flothemes.com/mimal-content-settings/#galleries"
        ),
        array(
            'id' => $flo_prefix.'-gallery_nr_of_columns',
            'type' => 'select',
            'compiler' => true,
            'title' => __("Select gallery's number of columns", 'flotheme'),
            'options' => array(
                '3' => 'Three Columns',
                '4' => 'Four Columns',
            ),
            'default' => '4'
        ),
        array(
            'id' => $flo_prefix.'-single_gallery_layout',
            'type' => 'image_select',
            'compiler' => true,
            'title' => __('Select Single Gallery Layout (View Type)', 'flotheme'),
            'subtitle' => __('Choose your Single Gallery layout.', 'flotheme'),
            'options' => $single_gallery_layout,
            'default' => 'grid_view'
        ),

        array(
            'id' => $flo_prefix.'-social_for_galleries',
            'type' => 'button_set',
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'help_img' => array('enable_gallery_sharing.jpg'),
            'title' => __('Enable social sharing for galleries', 'flotheme'),
            'default' => '1'
        ),

        array(
            'id' => $flo_prefix.'-gallery_date',
            'type' => 'button_set',
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'title' => __('Show Gallery post date on list view and grid view', 'flotheme'),
            'default' => '1'
        ),
        array(
            'id' => $flo_prefix.'-gallery_slideshow_effect',
            'type' => 'select',
            'options' => array(
                'zoomOut' => 'Zoom Out',
                'fade' => 'Fade',
                'fadeUp' => 'Fade Up',
                'fadeDown' => 'Fade Down',
                'fadeSide' => 'Fade side',
                'slide' => 'Slide'
            ),
            'title' => __('Slideshow sliding effect', 'flotheme'),
            'default' => 'zoomOut',
        ),

        array(
            'id' => $flo_prefix.'-gallery_slideshow_effect_speed',
            'type' => 'text',
            'validate' => 'numeric',
            'title' => __('Slideshow sliding speed (in ms)', 'flotheme'),
            'default' => ''
        ),
        array(
            'id' => $flo_prefix.'-change_gallery_shortcode',
            'type' => 'button_set',
            'title' => __('Change default WP gallery shortcode behaviour', 'flotheme'),
            'desc' => __('By enabling this option the layout and behaviour for the default WP gallery shortcode will be overwritten.', 'flotheme'),
            'options' => array(
                'yes' => 'Yes',
                'no' => 'No',
            ),
            'default' => 'yes'
        ),
    )
);
$this->sections[] = array(
    'title' => __('Slideshow', 'flotheme'),
    'class' => 'slideshow',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-slideshow',
            'title' => __('Slideshow', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Slideshow",
            'doc_iframe' => "http://docs.flothemes.com/mimal-content-settings/#slideshow"
        ),
        array(
            'id' => $flo_prefix.'-main_slideshow_autoplay',
            'type' => 'button_set',
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'title' => __('Enable autoplay for main slideshow', 'flotheme'),
            'default' => 0,
        ),

        array(
            'id' => $flo_prefix.'-autoplay_speed',
            'type' => 'text',
            'title' => __('Slideshow autoplay speed.', 'flotheme'),
            'required' => array('flo_minimal-main_slideshow_autoplay', '=', '1'),
            'subtitle' => __('This must be numeric.', 'flotheme'),
            'desc' => __('This is the description field, again good for additional info.', 'flotheme'),
            'validate' => 'numeric',
            'default' => '3000',
        ),

        array(
            'id' => $flo_prefix.'-main_slideshow_effect',
            'type' => 'select',
            'options' => array(
                'zoomOut' => 'Zoom Out',
                'fade' => 'Fade',
                'fadeUp' => 'Fade Up',
                'fadeDown' => 'Fade Down',
                'fadeSide' => 'Fade side',
                'slide' => 'Slide'
            ),
            'title' => __('Sliding effect', 'flotheme'),
            'default' => 'fade',
        ),

        array(
            'id' => $flo_prefix.'-slideshow_type',
            'type' => 'select',
            'options' => array(
                'fullscreen' => 'Full Screen',
                'full-width' => 'Full Width'
            ),
            'title' => __('Layout type', 'flotheme'),
            'default' => 'fullscreen',
        ),

        array(
            'id' => $flo_prefix.'-main_slideshow_effect_speed',
            'type' => 'text',
            'validate' => 'numeric',
            'title' => __('Sliding speed (in ms)', 'flotheme'),
            'default' => ''
        ),


        array(
            'id' => $flo_prefix.'-slideshow_logo_max_width',
            'type' => 'text',
            'title' => __('Slideshow logo image max-width.', 'flotheme'),
            'mode' => 'max-width',
            'output' => array('.hero-block__slider .logo img'),
            'validate' => 'numeric',
            'default' => '',
        ),


        array(
            'id' => $flo_prefix.'-automatically_text_color',
            'type' => 'button_set',
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'title' => __('Enable text/logo color change based on the slideshow image color', 'flotheme'),
            'subtitle' => __('This will affect the menu, social icons, search icon and copyright text
                        color on top of the slideshow.', 'flotheme'),
            'default' => 1,
        ),
        array(
            'id' => $flo_prefix.'-slideshow_logo_dark',
            'type' => 'media',
            'title' => __('Upload a dark logo to show on light slides', 'flotheme'),
            'subtitle' => __('Usualy this is a dark Logo image which is used on the pages with slideshow and is displayed over light color images.', 'flotheme'),
            'help_img' => array('slideshow_logo_dark.jpg'),
            'required' => array('flo_minimal-automatically_text_color', "=", 1),
        ),
        array(
            'id' => $flo_prefix.'-slideshow_logo_light',
            'type' => 'media',
            'title' => __('Upload a light logo to show on dark slides', 'flotheme'),
            'subtitle' => __('Usualy this is a light Logo image which is used on the pages with slideshow and is displayed over dark color images.', 'flotheme'),
            'help_img' => array('slideshow_logo_light.jpg'),
            'required' => array('flo_minimal-automatically_text_color', "=", 1),
        ),
        array(
            'id' => $flo_prefix.'-slideshow_title',
            'type' => 'typography',
            'title' => __('Slideshow Title - Typography', 'flotheme'),
            'google' => true,
            'font-backup' => false,
            'text-align' => false,
            'font-style' => true, // Includes font-style and weight. Can use font-style or font-style to declare
            'subsets' => true, // Only appears if google is true and subsets not set to false
            'font-size' => true,
            'font-size-mobile' => true,
            'font-size-tablet' => true,
            'line-height' => true,
            'line-height-mobile' => true,
            'line-height-tablet' => true,
            'color' => false,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'units' => 'px',
            'help_img' => array('slideshow_title.jpg'),
            'output' => array('.hero-slider h3 a','.hero-slider h3', '.hero-slider .slide-hover .title'),
            'placeholder' => array(
                //'color'       => '#333',
                //'font-style'  => '700',

                'font-weight'  => '400',
                'font-family' => '',
                'google' => true,
                'font-size' => '55px',
                'font-size-mobile' => '55px',
                'font-size-tablet' => '55px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-slideshow_description',
            'type' => 'typography',
            'title' => __('Slideshow Description - Typography', 'flotheme'),
            'google' => true,
            'font-backup' => false,
            'text-align' => false,
            'font-style' => true, // Includes font-style and weight. Can use font-style or font-style to declare
            'subsets' => true, // Only appears if google is true and subsets not set to false
            'font-size' => true,
            'font-size-mobile' => true,
            'font-size-tablet' => true,
            'line-height' => true,
            'line-height-mobile' => true,
            'line-height-tablet' => true,
            'color' => false,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'units' => 'px',
            'help_img' => array('slideshow_description.jpg'),
            'output' => array('.hero-slider .slick-slide h4, .hero-slider .slide-hover .sub-title'),
            'placeholder' => array(
                //'color'       => '#333',
                //'font-style'  => '700',

                'font-weight'  => '400',
                'font-family' => '',
                'google' => true,
                'font-size' => '18px',
                'font-size-mobile' => '18px',
                'font-size-tablet' => '18px',
                //'line-height' => '40px'
            ),
        ),
    )
);
$this->sections[] = array(
    'title' => __('Pages', 'flotheme'),
    'class' => 'pages',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-pages',
            'title' => __('Pages', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Pages",
            'doc_iframe' => "http://docs.flothemes.com/mimal-content-settings/#pages"
        ),
        array(
            'id' => $flo_prefix.'-blog_listing_layout',
            'type' => 'image_select',
            'compiler' => true,
            'title' => __('Blog listing layout( view type)', 'flotheme'),
            'subtitle' => __('Choose your blog layout.', 'flotheme'),
            'options' => $view_type_archives,
            'default' => 'grid_view'
        ),
        array(
            'id' => $flo_prefix.'-archive_listing_layout',
            'type' => 'image_select',
            'compiler' => true,
            'title' => __('Archive listing layout( view type)', 'flotheme'),
            'subtitle' => __('Choose your archive layout.', 'flotheme'),
            'options' => $view_type_archives,
            'default' => 'grid_view'
        ),
        array(
            'id' => $flo_prefix.'-excerpt',
            'type' => 'text',
            'title' => __('Enter excerpt List View lenght', 'flotheme'),
            'subtitle' => __('It is used in list views.', 'flotheme'),
            'default' => '400',
            'validate' => 'numeric'
        ),
        array(
            'id' => $flo_prefix.'-page_header_layout',
            'type' => 'image_select',
            'compiler' => true,
            'title' => __('Default Page Header Layout', 'flotheme'),
            'subtitle' => __('Choose your header page layout.', 'flotheme'),
            'options' => $page_view_type,
            'default' => '1'
        ),
        array(
            'id' => $flo_prefix.'-page_comments',
            'type' => 'button_set',
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'title' => __('Enable Comments for pages', 'flotheme'),
            'default' => '0'
        ),
        array(
            'id' => $flo_prefix.'-404_layout',
            'type' => 'image_select',
            'compiler' => true,
            'title' => __('404 View Type', 'flotheme'),
            'subtitle' => __('Choose 404 view type.', 'flotheme'),
            'options' => $not_found_view_type,
            'default' => 'content-full'
        ),
        array(
            'id' => $flo_prefix.'-404_image',
            'type' => 'media',
            'title' => __('404 Image', 'flotheme'),
            'subtitle' => __('Upload image background for page 404!', 'flotheme'),
        ),
        array(
            'id' => $flo_prefix.'-404_background_color',
            'type' => 'color',
            'mode' => 'background-color',
            'transparent' => false,
            'title' => __('Content 404 Background color', 'flotheme'),
            'subtitle' => __('Set background color for content 404!', 'flotheme'),
            'output' => array('.page-container.content-50','.page-container.content-full .content')
        ),
        array(
            'id' => $flo_prefix.'-404_text_color',
            'type' => 'color',
            'mode' => 'color',
            'transparent' => false,
            'title' => __('Content 404 Text color', 'flotheme'),
            'subtitle' => __('Set text color for content 404!', 'flotheme'),
            'output' => array('.page-container .content')
        ),
        array(
            'id' => $flo_prefix.'-404_content',
            'type' => 'editor',
            'title' => __('Content 404', 'flotheme'),
            'subtitle' => __('Set content 404!', 'flotheme'),
            'default' => '<h2 class="main-title">Something went wrong</h2>
									<h5 class="sub-title">Sorry but this page is missing!</h5>
									<p>Unfortunately the content you’re looking for isn’t here. There may be a misspelling in your web address or you may have clicked a link for content that no longer exists. Please use the menus to find what you are looking for.</p>'
        ),
    )
);
$this->sections[] = array(
    'title' => __('Sidebars', 'flotheme'),
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-sidebars',
            'title' => __('Sidebars', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Sidebars",
            'doc_iframe' => "http://docs.flothemes.com/mimal-content-settings/#sidebars"
        ),
        array(
            'id' => $flo_prefix.'-sidebars',
            'type' => 'sidebars',
            'title' => __('Add sidebars', 'flotheme'),
            'fields' => array(
                array(
                    'id' => 'new_sidebar',
                    'type' => 'text',
                    'placeholder' => __('Add new Sidebar', 'flotheme'),
                )
            ),
        )
    )
);
$this->sections[] = array(
    'title' => __('Image Sizing', 'flotheme'),
    'class' => 'image_sizing',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-image_sizing',
            'title' => __('Image Sizing', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Image Sizing",
            'doc_iframe' => "http://docs.flothemes.com/mimal-content-settings/#image-sizing"
        ),
        array(
            'id' => $flo_prefix.'-grid_view-width',
            'type' => 'text',
            'title' => __('Grid view image width', 'flotheme'),
            'subtitle' => __('This must be numeric.', 'flotheme'),
            'validate' => 'numeric',
            'default' => '600',
            'help_img' => array('grid_width_1.jpg','grid_width_2.jpg')
        ),
        array(
            'id' => $flo_prefix.'-grid_view-height',
            'type' => 'text',
            'title' => __('Grid view image height', 'flotheme'),
            'subtitle' => __('This must be numeric.', 'flotheme'),
            'validate' => 'numeric',
            'class' => 'bottom-separator',
            'default' => '600',
            'help_img' => array('grid_height_1.jpg','grid_height_2.jpg')
        ),
        /*-----------------------------------*/

        array(
            'id' => $flo_prefix.'-list_view-width',
            'type' => 'text',
            'title' => __('List view image width', 'flotheme'),
            'subtitle' => sprintf(__('This must be numeric. %s The value set here will change the list view width as well', 'flotheme'),'<br/>'),
            'validate' => 'numeric',
            'default' => '690',
            'help_img' => array('list-sizes.jpg')
        ),
        array(
            'id' => $flo_prefix.'-list_view-height',
            'type' => 'text',
            'title' => __('List view image height', 'flotheme'),
            'subtitle' => sprintf(__('This must be numeric. %s The value set here will change the list view height as well', 'flotheme'),'<br/>'),
            'validate' => 'numeric',
            'class' => 'bottom-separator',
            'default' => '430',
            'help_img' => array('list-sizes.jpg')
        ),

        array(
            'id' => $flo_prefix.'-list_view_full-width',
            'type' => 'text',
            'title' => __('List view full width image width', 'flotheme'),
            'subtitle' => __('This must be numeric.', 'flotheme'),
            'validate' => 'numeric',
            'default' => '1400',
            'help_img' => array('list-full-sizes.jpg')
        ),
        array(
            'id' => $flo_prefix.'-list_view_full-height',
            'type' => 'text',
            'title' => __('List view full width image height', 'flotheme'),
            'subtitle' => __('This must be numeric.', 'flotheme'),
            'validate' => 'numeric',
            'class' => 'bottom-separator',
            'default' => '690',
            'help_img' => array('list-full-sizes.jpg')
        ),
        /*-----------------------------------*/
        array(
            'id' => $flo_prefix.'-featured_image-width',
            'type' => 'text',
            'title' => __('Page header featured image width', 'flotheme'),
            'subtitle' => __('This must be numeric.', 'flotheme'),
            'validate' => 'numeric',
            'default' => '1920',
            'help_img' => array('page-feat-img.jpg')
        ),
        array(
            'id' => $flo_prefix.'-featured_image-height',
            'type' => 'text',
            'title' => __('Page header featured image height', 'flotheme'),
            'subtitle' => __('This must be numeric.', 'flotheme'),
            'validate' => 'numeric',
            'class' => 'bottom-separator',
            'default' => '980',
            'help_img' => array('page-feat-img.jpg')
        ),

        array(
            'id' => $flo_prefix.'-gallery_thumb-width',
            'type' => 'text',
            'title' => __('Single gallery thumbnail width&height', 'flotheme'),
            'subtitle' => __('This must be numeric.', 'flotheme'),
            'validate' => 'numeric',
            'class' => 'bottom-separator',
            'default' => '400',
            'help_img' => 'mimal-gal-thumb.jpg',
        ),

    )
);
