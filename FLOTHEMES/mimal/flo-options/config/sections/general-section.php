<?php
global $flo_prefix,
$dummy_data_folders;



$this->sections[] = array(
    'title' => __('General Settings', 'flotheme'),
    'icon' => 'general',
    'class' => 'general',
);

$this->sections[] = array(
    'title' => __('Style Kits', 'flotheme'),
    'class' => 'style_kits',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider_style_kits',
            'title' => __('Style Kits', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Style Kits",
            'doc_iframe' => "http://docs.flothemes.com/mimal-general-settings/#style-kits"
        ),
        array(
            'id' => 'flo-style_sheet',
            'type' => 'image_select',
            'customizer' => true,
            'title' => __('Select the predefined stylesheet', 'flotheme'),
            'options' => $predefined_stylesheet,
            'class' => 'img-stylesheet',
            'default' => ''
        ),
        array(
            'id' => $flo_prefix . '-sk-tab-name-1',
            'title' => 'Regular Style Kit Options',
            'type' => 'raw',
            'class' => 'no-fold',
            'full_width' => true,
            'required' => array('flo-style_sheet', '=', '')
        ),
        array(
            'id' => $flo_prefix . '-sk-regular-minor-background',
            'title' => 'Navigation background color',
            'default' => '#e5e5e5',
            'transparent' => false,
            'type' => 'color',
            'required' => array('flo-style_sheet', '=', ''),
            'output' => array(
                'background-color' => '.page.post-page .post-nav li:hover'
            ),
            'help_img' => array('nav-bg-color.jpg')
        ),
        array(
            'id' => $flo_prefix . '-sk-regular-grid-hover',
            'title' => 'Grid view hover color',
            'default' => '#fff',
            'transparent' => false,
            'type' => 'color_rgba',
            'required' => array('flo-style_sheet', '=', ''),
            'output' => array(
                'background-color' => '.page.portfolio-page li.image .figure-hover'
            ),
            'help_img' => array('grid-bg-color.jpg')
        ),

        array(
            'id' => $flo_prefix . '-sk-regular-list-hover',
            'title' => 'List view hover color',
            'default' => '#fff',
            'transparent' => false,
            'type' => 'color_rgba',
            'required' => array('flo-style_sheet', '=', ''),
            'output' => array(
                'background-color' => '#wrapper > div.page.blog > div.all-posts.full-width.text-center > div.layout > div.post > div.post-header:before',
                'background-color' => '#wrapper > div.page.blog > div.all-posts.with-layout.text-center > div.layout > div.post > div.post-header.with-image:hover'
            )
        ),
        array(
            'id' => $flo_prefix . '-sk-regular-grid-text-color',
            'title' => 'Grid view text color',
            'default' => '#000',
            'transparent' => false,
            'type' => 'color',
            'required' => array('flo-style_sheet', '=', ''),
            'output' => array(
                'color' => '.page.portfolio-page li.image .figure-hover, .page.portfolio-page li.image .figure-hover a'
            ),
            'help_img' => array('grid-text-color.jpg')
        ),
        array(
            'id' => $flo_prefix . '-sk-tab-name',
            'title' => 'Blue Style Kit Options',
            'class' => 'no-fold',
            'type' => 'raw',
            'full_width' => false,
            'required' => array('flo-style_sheet', '=', 'style-blue.css'),
        ),
        array(
            'id' => $flo_prefix . '-sk-blue-primary-color',
            'title' => 'Primary color',
            'default' => '#e6f4f3',
            'transparent' => false,
            'type' => 'color',
            'required' => array('flo-style_sheet', '=', 'style-blue.css'),
            'output' => array(
                'background-color' => '.category-select a.toggle:before,.pagination li:not(.nav).active,header.main-header .header-actions .search .min-icon-search-icon:before,.social-links a.icon,.social-links a,.page.portfolio-page li.image .figure-hover .content:after,.page.portfolio-single .image a:before,.hero-slider .slider button.slick-prev:before,.hero-slider .slider button.slick-next:before,.flobox-wrapper button.slick-prev:after,.flobox-wrapper button.slick-next:after,.flobox-wrapper .options-side .icons a,.flobox-wrapper .options-side .option.share,.page.blog .all-posts.with-layout .post.style-blue:after,.page.post-page .post-nav li:hover',
                'color' => 'footer.main-footer .block:after,.flobox-wrapper .options-side .option.info h2.title:after,.page.blog .all-posts.full-width .post.style-blue h6.date:after,.hero-image.full-width .content:before',
                'border-color' => '.page.portfolio-single .image a:after,.hero-image.full-width figure:after'
            ),
            'help_img' => array('blue-main-color-3.jpg','blue-primary-color.jpg')
        ),
        array(
            'id' => $flo_prefix . '-sk-blue-secondary-color',
            'title' => 'Secondary color',
            'default' => '#f5f2e9',
            'transparent' => false,
            'type' => 'color',
            'required' => array('flo-style_sheet', '=', 'style-blue.css'),
            'output' => array(
                'background-color' => 'input[type="text"],input[type="email"],input[type="password"],input[type="search"],textarea,footer.main-footer .widget .widget-title:after,.page.portfolio-page li.image .figure-hover:before,.page.portfolio-page li.image .figure-hover:after,.flobox-wrapper,.flobox-wrapper .flobox-bg,.flobox-wrapper .options-side .option.info h2.title:before,.flobox-wrapper .options-side .option.share .social-links a,.page.blog .all-posts.with-layout figure,.page.blog .all-posts.with-layout .post.style-blue.with-image h2.title:after,.page.blog .all-posts.with-layout .post.style-blue.with-image h2.title:before,.page.blog .all-posts.full-width .post.style-blue figure,.page.blog .all-posts.full-width .post.style-blue .post-header:after,.page.blog .all-posts.full-width .post.style-blue .post-header:before,.hero-image.full-width .content:after,.hero-image.small-photo',
                'border-color' => '.page.portfolio-page li.image .figure-hover .content:before,.page.blog .all-posts.with-layout .post.style-blue,.page.blog .all-posts.full-width .post.style-blue figure:after,.hero-image.full-width figure:before'
            ),
            'help_img' => array('blue-secondary-color.jpg')
        ),
        array(
            'id' => $flo_prefix . '-sk-blue-button-background-color',
            'title' => 'Button background color',
            'default' => '#000',
            'transparent' => false,
            'type' => 'color',
            'required' => array('flo-style_sheet', '=', 'style-blue.css'),
            'output' => array(
                'background-color' => 'input[type="submit"], input[type="button"], .page.blog .all-posts.with-layout .post.style-blue a.open-post, .pagination li.nav a, .page.blog .all-posts.full-width .post.style-blue a.open-post,   .page.blog .all-posts.with-layout .post.style-blue a.open-post',
                'border-color' => 'input[type="submit"], input[type="button"], .page.blog .all-posts.with-layout .post.style-blue a.open-post, .pagination li.nav a, .page.blog .all-posts.full-width .post.style-blue a.open-post,   .page.blog .all-posts.with-layout .post.style-blue a.open-post',
                'color' => 'input[type="submit"]:hover, input[type="button"]:hover, .page.blog .all-posts.with-layout .post.style-blue a.open-post:hover, .pagination li.nav a:hover, .page.blog .all-posts.full-width .post.style-blue a.open-post:hover,   .page.blog .all-posts.with-layout .post.style-blue a.open-post:hover',
            ),
            'help_img' => array('blue-button-bg-color.jpg'),
        ),
        array(
            'id' => $flo_prefix . '-sk-blue-button-text-color',
            'title' => 'Button text color',
            'default' => '#fff',
            'transparent' => false,
            'type' => 'color',
            'required' => array('flo-style_sheet', '=', 'style-blue.css'),
            'output' => array(
                'color' => 'input[type="submit"], input[type="button"], .page.blog .all-posts.with-layout .post.style-blue a.open-post, .pagination li.nav a, .page.blog .all-posts.full-width .post.style-blue a.open-post,   .page.blog .all-posts.with-layout .post.style-blue a.open-post'
            ),
            'help_img' => array('blue-button-bg-color.jpg'),
        ),

        array(
            'id' => $flo_prefix . '-sk-tab-name-3',
            'title' => 'Red Style Kit Options',
            'type' => 'raw',
            'class' => 'no-fold',
            'full_width' => true,
            'required' => array('flo-style_sheet', '=', 'style-red.css')
        ),
        array(
            'id' => $flo_prefix . '-sk-red-primary-color',
            'title' => 'Primary color',
            'default' => '#7c353e',
            'transparent' => false,
            'type' => 'color',
            'required' => array('flo-style_sheet', '=', 'style-red.css'),
            'output' => array(
                'background-color' => '.social-links a.icon:hover,.social-links a:hover,header.main-header .header-actions .search:hover .min-icon-search-icon:before,.flobox-wrapper .options-side .icons a.share,.flobox-wrapper .options-side .option.share,.page.contact-page input[type="button"]:hover,.page.post-page .post-nav li:hover,.page.post-page .actions .share ul li a:hover,.comments .comment-form input[type="submit"]:hover',
                'color' => '.flobox-wrapper .options-side .icons a.info:before,.flobox-wrapper .options-side .option.share .social-links li a:hover,.page-side-bar .social-links li a,.page.post-page .actions .share ul li a ',
                'border-color' => '.category-select a.toggle:after '
            ),
            'help_img' => array('pr-1.jpg','pr-2.jpg')
        ),
        array(
            'id' => $flo_prefix . '-sk-red-secondary-color',
            'title' => 'Secondary color',
            'default' => '#b3afaf',
            'transparent' => false,
            'type' => 'color',
            'required' => array('flo-style_sheet', '=', 'style-red.css'),
            'output' => array(
                'background-color' => '.social-links a.icon,.social-links a,header.main-header .header-actions .search .min-icon-search-icon:before,.newsletter-widget input[type="text"],.flobox-wrapper,.flobox-wrapper .flobox-bg,.flobox-wrapper .options-side .icons a.active,.pagination li a:after'
            ),
            'help_img' => array('sec-1.jpg')
        ),
    )
);
$this->sections[] = array(
    'title' => __('Titles and Links', 'flotheme'),
    'class' => 'links',
    'subsection' => true,
    'customizer' => false,
    'fields' => array(
        array(
            'id' => 'divider_links',
            'title' => __('Titles and Links', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Titles and Links",
            'doc_iframe' => "http://docs.flothemes.com/mimal-general-settings/#titles-and-links"
        ),
        array(
            'id' => $flo_prefix.'-blog_page_title',
            'type' => 'text',
            'title' => __('Blog page title', 'flotheme'),
            'default' => __('Blog', 'flotheme')
        ),
        array(
            'id' => $flo_prefix.'-search_page_title',
            'type' => 'text',
            'title' => __('Search page title', 'flotheme'),
            'default' => __('Search results for: %', 'flotheme')
        ),
        array(
            'id' => $flo_prefix.'-gallery_link',
            'type' => 'text',
            'title' => __('Gallery link url (gallery slug)', 'flotheme'),
            'default' => 'gallery',
            'customizer' => false,
            'hint' => array(

                //'title'   => 'Hint Title',
                'content' => __('Set a custom permalink for your galleries. For example: portfolio. Example: http://yoursitename.com/portfolio', 'flotheme')
            )
        ),
        array(
            'id' => $flo_prefix.'-gallery_categ_link',
            'type' => 'text',
            'title' => __('Gallery categories link url (gallery category slug)', 'flotheme'),
            'default' => 'gallery-category',
            'customizer' => false,
            'hint' => array(
                'content' => __('Set a custom permalink for your galleries categories. For example: portfolio. Example: http://yoursitename.com/portfolio', 'flotheme')
            )
        ),
        array(
            'id' => $flo_prefix.'-gallery_tags_link',
            'type' => 'text',
            'title' => __('Gallery tags link url(gallery tag slug)', 'flotheme'),
            'default' => 'gallery-tag',
            'customizer' => true,
            'hint' => array(
                'content' => __('Set a custom permalink for your galleries tags. For example: portfolio. Example: http://yoursitename.com/portfolio', 'flotheme')
            )
        ),
    )
);
$this->sections[] = array(
    'title' => __('Social Media', 'flotheme'),
    'class' => 'social',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider_social',
            'title' => __('Social Media', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Social Media",
            'doc_iframe' => "http://docs.flothemes.com/mimal-general-settings/#social-networks"
        ),
        array(
            'id' => $flo_prefix.'-social',
            'type' => 'social_networks',
            'title' => __('Add social', 'flotheme'),
            'description' => __("NOTE! The font icons are avalible for the following services: facebook, twitter, gplus, yahoo, dribbble, linkedin, vimeo, youtube, tumblr, delicious, flickr, instagram, pinterest. So, if you use any of these services, it is not required to upload icons (if you leave the icon field blank the default font icons will be used). For any other social profiles you'll have to upload image icons.", 'flotheme'),
        ),
    )
);
$this->sections[] = array(
    'title' => __('Analytics', 'flotheme'),
    'class' => 'analytics',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider_analytics',
            'title' => __('Analytics', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Analytics",
            'doc_iframe' => "http://docs.flothemes.com/mimal-general-settings/#analytics"
        ),
        array(
            'id' => $flo_prefix.'-tracking_code',
            'type' => 'textarea',
            'title' => __('Tracking code', 'flotheme'),
            'default' => '',
            'customizer' => true,
            'hint' => array(
                'content' => __('Paste your Google Analytics or other tracking code here.
                                                It will be added into the footer of this theme', 'flotheme')
            ),
        ),
    )
);
$this->sections[] = array(
    'title' => __('Favicon', 'flotheme'),
    'class' => 'favicon',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-favicon',
            'title' => __('Favicon', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Favicon",
            'doc_iframe' => "http://docs.flothemes.com/mimal-general-settings/#favicon"
        ),
        array(
            'id' => $flo_prefix.'-favicon',
            'type' => 'media',
            'title' => __('Custom Favicon', 'flotheme'),
            'desc' => __("Please select 'ico' type media file. Make sure you allow uploading 'ico' type in General Settings -> Upload file types. If you don't have a favicon, you can generate one using <a href='http://www.convertico.com/'>this service</a>", 'flotheme'),
            'subtitle' => __('Upload any media using the WordPress native uploader', 'flotheme'),
        ),
    )
);
$this->sections[] = array(
    'title' => __('Admin Bar', 'flotheme'),
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-admin_bar',
            'title' => __('Admin Bar', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Admin Bar",
            'doc_iframe' => "http://docs.flothemes.com/mimal-general-settings/#admin-bar"
        ),
        array(
            'id' => $flo_prefix.'-show_admin_bar',
            'type' => 'button_set',
            'title' => __('Show wordpress admin bar', 'flotheme'),
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'customizer' => false,
            'default' => true,
        ),
    )
);
$this->sections[] = array(
    'title' => __('Import / Export', 'flotheme'),
    'class' => 'import',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-import',
            'title' => __('Import / Export ', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Import / Export ",
            'doc_iframe' => "http://docs.flothemes.com/mimal-general-settings/#import-export"
        ),
        array(
            'id' => $flo_prefix.'-import_one_click',
            'type' => 'select',
            'title' => 'Import Demo Content',
            'subtitle' => sprintf(__('Before importing the content, please install and activate %sWidget Importer Exporter%s plugin if you want to import all the demo widgets.','flotheme'),'<a href="https://wordpress.org/plugins/widget-importer-exporter/" target="_blank">', '</a>','<a href="https://wordpress.org/plugins/jetpack/" target="_blank">','</a>','<a href="http://jetpack.me/support/widget-visibility/" target="_blank">','</a>'  ),
            'options' => $dummy_data_folders,
            'default' => 'export',
            'customizer' => false,
            'desc' => '<input type="button" class="import-demo-content generic-record-button  button-primary  " value="' . __('Import dummy data','flotheme') . '" onclick="importDummyData();"> <div class="spinner-container"><span class="spinner import-demo-spinner" ></span></div><div class="import-response">' . __('Please be patient, the process may take some time.', 'flotheme') . '</div>'
        ),
        array(
            'id' => 'opt-import-export',
            'type' => 'import_export',
            'title' => 'Import Export',
            'subtitle' => 'Save and restore your Redux options',
            'full_width' => false,
        ),
    )
);
?>
