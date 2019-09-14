<?php
global $flo_prefix;

$this->sections[] = array(
    'title' => __('Typography', 'flotheme'),
    'icon' => 'typography',
    'class' => 'typography',
);
$this->sections[] = array(
    'title' => __('Base Fonts', 'flotheme'),
    'class' => 'base_fonts',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-base_fonts',
            'title' => __('Base Fonts', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Base Fonts",
            'doc_iframe' => "http://docs.flothemes.com/mimal-typography-settings/#base-fonts"
        ),
        array(
            'id' => $flo_prefix . '-typography-general_menu',
            'type' => 'typography',
            'title' => __('General Menu Font', 'flotheme'),
            'subtitle' => __('This will change the font for the following elements: menu and meta data.', 'flotheme'),
            'google' => true,
            'font-backup' => false,
            'text-align' => false,
            'font-style' => false, // Includes font-style and weight. Can use font-style or font-style to declare
            'subsets' => false, // Only appears if google is true and subsets not set to false
            'font-size' => false,
            'font-size-mobile' => false,
            'font-size-tablet' => false,
            'line-height' => false,
            'line-height-mobile' => false,
            'line-height-tablet' => false,
            'font-weight' => false,
            'color' => false,
            'letter-spacing' => false, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => false,
            'output' => array('

                                 header.main-header ul.nav-menu > .menu-item a,
                                 .hero-slider a.slide-btn,
                                 .category-select .label,
                                  h4, h5, h6, textarea,
                                .widget .widget-title,
                                .page.post-page .post h6.date,
                                .page.portfolio-page li.image .figure-hover h5.date,
                                .page.portfolio-page li.image .figure-hover a.open-gallery,
                                .page.post-page .sub-content label,
                                .page.post-page .actions h6.title,
                                .page.post-page .actions h6.title,
                                .page.post-page .post-nav a.name,
                                .page.blog .all-posts .post.style-basic .date h6,
                                .page.blog .all-posts .post.style-basic a.open-post,
                                .pagination,
                                header.main-header .header-actions .search label
                                '),
            'units' => 'px',
        ),
        array(
            'id' => $flo_prefix . '-typography-general_page_titles',
            'type' => 'typography',
            'title' => __('Page / Post Titles Font', 'flotheme'),
            'subtitle' => __('This will change the font for pages titles, and for the slideshow title.', 'flotheme'),
            'google' => true,
            'font-backup' => false,
            'text-align' => false,
            'font-style' => false, // Includes font-style and weight. Can use font-style or font-style to declare
            'subsets' => false, // Only appears if google is true and subsets not set to false
            'font-size' => false,
            'font-size-mobile' => false,
            'font-size-tablet' => false,
            'line-height' => false,
            'line-height-mobile' => false,
            'line-height-tablet' => false,
            'font-weight' => false,
            'color' => false,
            'letter-spacing' => false, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => false,
            'output' => array('
                                h1,h2,h3,
                                footer.main-footer .block h3
                                '),
            'units' => 'px',
        ),
        array(
            'id' => $flo_prefix . '-typography-general_content',
            'type' => 'typography',
            'title' => __('General Content Font', 'flotheme'),
            'subtitle' => __('This will change the font for the following elements: posts and pages content, comments content and widgets content', 'flotheme'),
            'google' => true,
            'font-backup' => false,
            'text-align' => false,
            'font-style' => false, // Includes font-style and weight. Can use font-style or font-style to declare
            'subsets' => false, // Only appears if google is true and subsets not set to false
            'font-size' => false,
            'font-size-mobile' => false,
            'font-size-tablet' => false,
            'line-height' => false,
            'line-height-mobile' => false,
            'line-height-tablet' => false,
            'font-weight' => false,
            'color' => false,
            'letter-spacing' => false, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => false,
            'output' => array('
                               body,

                                .flo_comments_wrap .comment_text,
                                .flo_page p,
                                .flo_post_list.type_card_1.type_slider_2 .excerpt_wrap,
                                .flo_post_list.type_card_2.type_slider_2 .excerpt_wrap,
                                .flo_post_list.type_card_3.type_slider_2 .excerpt_wrap,
                                .flo_post_list.type_card_with_slider.type_slider_2 .excerpt_wrap,
                                .flo_post_list.type_card_with_slider.type_slider_2 .excerpt_wrap,
                                .flo_post_list.type_list_without_image.type_slider_2 .excerpt_wrap,
                                .flo_post_list.type_grid_text_under.type_slider_2 .excerpt_wrap,
                                .flo_post_list.type_grid.type_slider_2 .excerpt_wrap,
                                .flo_post_list.type_big_title.type_slider_2 .excerpt_wrap,
                                .flo_post_list.type_big_titles.type_slider_2 .excerpt_wrap,
                                .flo_post_list.type_pattern.type_slider_2 .excerpt_wrap,
                                .flo_post_list.type_slider_2 .excerpt_wrap,
                                .flo_slider .slide_content .text
                                '),
            'units' => 'px',
        ),
    )
);
$this->sections[] = array(
    'title' => __('Advanced Fonts', 'flotheme'),
    'class' => 'advanced_fonts',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-advanced_fonts',
            'title' => __('Advanced Fonts', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Advanced Fonts",
            'doc_iframe' => "http://docs.flothemes.com/mimal-typography-settings/#advanced-typography"
        ),
        array(
            'id' => $flo_prefix.'-typography-general',
            'type' => 'typography',
            'title' => __('General font', 'flotheme'),
            'subtitle' => __('default font: "Adobe Caslon Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('body, body p',
                'body .article-content div, body .article-content span, body .article-content applet, body .article-content object, body .article-content iframe,
body .article-content h1, body .article-content h2, body .article-content h3, body .article-content h4, body .article-content h5, body .article-content h6, body .article-content p, body .article-content blockquote, body .article-content pre,
body .article-content a, body .article-content abbr, body .article-content acronym, body .article-content address, body .article-content big, body .article-content cite, body .article-content code,
body .article-content del, body .article-content dfn, body .article-content em, body .article-content img, body .article-content ins, body .article-content kbd, body .article-content q, body .article-content s, body .article-content samp,
body .article-content small, body .article-content strike, body .article-content strong, body .article-content sub, body .article-content sup, body .article-content tt, body .article-content var,
body .article-content b, body .article-content u, body .article-content i, body .article-content center,
body .article-content dl, body .article-content dt, body .article-content dd, body .article-content ol, body .article-content ul, body .article-content li,
body .article-content fieldset, body .article-content form, body .article-content label, body .article-content legend,
body .article-content table, body .article-content caption, body .article-content tbody, body .article-content tfoot, body .article-content thead, body .article-content tr, body .article-content th, body .article-content td,
body .article-content article, body .article-content aside, body .article-content canvas, body .article-content details, body .article-content embed,
body .article-content figure, body .article-content figcaption, body .article-content footer, body .article-content header, body .article-content hgroup,
body .article-content menu, body .article-content nav, body .article-content output, body .article-content ruby, body .article-content section, body .article-content summary,
body .article-content time, body .article-content mark, body .article-content audio, body .article-content video '),
            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),

        array(
            'id' => $flo_prefix.'-page1',
            'type' => 'typography',
            'title' => __('Page header "Full image" title typography', 'flotheme'),
            'subtitle' => __('default font: "Adobe Caslon Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('.page .hero-image.full-width .title'),
            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
            'help_img' => array('page_header_full_image.jpg')

        ),
        array(
            'id' => $flo_prefix.'-page2',
            'type' => 'typography',
            'title' => __('Page header "Small image centered" (hexagon) title typography', 'flotheme'),
            'subtitle' => __('default font: "Adobe Caslon Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('.page .hero-image.small-photo .title'),
            'units' => 'px',
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
            'help_img' => array('page_header_small_image_centered.jpg')
        ),
        array(
            'id' => $flo_prefix.'-page3',
            'type' => 'typography',
            'title' => __('Page header title "sub image": typography', 'flotheme'),
            'subtitle' => __('default font: "Adobe Caslon Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('.page .page-header .title'),
            'units' => 'px',
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
            'help_img' => array('page_header_title_sub_image.jpg')
        ),
        array(
            'id' => $flo_prefix.'-blog_list_title',
            'type' => 'typography',
            'title' => __('Blog List View / Single Blog Post : Titles', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('

                            .page.post-page .post h2.title,
                             .page.portfolio-page h2,
                              .next-post .title,
                               .prev-post .title,
                                 .page.blog .all-posts.full-width .post.with-image.style-basic.active h2.title,
                                  .post-page .post h1.title

                                 '),
            'units' => 'px',
            'help_img' => array('blog_list_title.jpg'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-grid_view_title',
            'type' => 'typography',
            'title' => __('Grid view / Next post / Prev post / Related posts : Titles ', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('.orig-size .logo , .squares .logo , .post-nav li a , .also-like .title, .also .title a, .orig-size .title, .squares .title'),
            'units' => 'px',
            'help_img' => array('grid_view_title.jpg'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-list_view_title',
            'type' => 'typography',
            'title' => __('Full Width List View : Title over image ', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'output' => array('.page.blog .all-posts.full-width .post.with-image h2.title,
                            .post-header.with-image h2.title,
                            .post.with-image h2.title,
                            .page.blog .all-posts.full-width .post.with-image h2.title a'),
            'units' => 'px',
            'help_img' => array('list_view_title_over.jpg'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-list_view_title_color',
            'type' => 'color',
            'title' => __('Full Width List View : Text over image Color', 'flotheme'),
            'output' => array('
                                              .page.blog .all-posts.full-width .post.with-image h2.title,
                                              .post-header.with-image h2.title,
                                              .page.blog .all-posts.full-width .post.with-image h2.title a,
                                              .page.blog .all-posts.full-width .post.with-image h2.title,
                                              .post-header.with-image h2.title,
                                              .page.blog .all-posts.full-width .post.with-image h2.title a,
                                              .page.blog .all-posts.full-width .post.with-image .meta h6,
                                               div.categories.meta-block,
                                              .page.blog .all-posts.full-width .post.with-image a.open-post,
                                              .page.blog .all-posts.full-width .post.style-red.with-image h2.title a,
                                              .page.blog .all-posts.full-width .post.style-red.with-image a.open-post
                                              '),
            'transparent' => false,
            'units' => 'px',
        ),

        array(
            'id' => $flo_prefix.'-gallery_title',
            'type' => 'typography',
            'title' => __('Gallery Title ', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('.flobox-wrapper .options-side .option.info h2.title, .page.portfolio-single .page-header .title'),
            'units' => 'px',
            'help_img' => array('gallery_open_title.jpg'),
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '50px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
            'default' => array(
                'font-size' => '44px',
            )
        ),
        array(
            'id' => $flo_prefix.'-meta',
            'type' => 'typography',
            'title' => __('Meta', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('.date, .share .title '),
            'units' => 'px',
            'help_img' => array('meta.jpg'),
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-pagination',
            'type' => 'typography',
            'title' => __('Open post button / Pagination ', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'help_img' => array('open_post_button_pagination.jpg'),
            'output' => array('.pagination li a, .pagination li span, .pagination li , .open-post'),
            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),


        array(
            'id' => $flo_prefix.'-h1',
            'type' => 'typography',
            'title' => __('H1 ', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('h1,body .article-content h1'),
            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-h2',
            'type' => 'typography',
            'title' => __('H2', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('h2,body .article-content h2'),
            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-h3',
            'type' => 'typography',
            'title' => __('H3', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('h3,body .article-content h3'),
            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-h4',
            'type' => 'typography',
            'title' => __('H4', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('h4,body .article-content h4'),
            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-h5',
            'type' => 'typography',
            'title' => __('H5', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('h5,body .article-content h5'),
            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-h6',
            'type' => 'typography',
            'title' => __('H6 ', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'output' => array('h6, body .article-content h6'),
            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),


        array(
            'id' => $flo_prefix.'-sidebar_widget_title',
            'type' => 'typography',
            'title' => __('Sidebar Widget Title', 'flotheme'),
            'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'help_img' => array('sidebar_widget_title.jpg'),
            'output' => array('.content-sidebar .widget .widget-title'),
            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#504c49',
                'font-family' => '',
                'google' => true,
                'letter-spacing' => '0.9px',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),

        array(
            'id' => $flo_prefix.'-placeholders',
            'type' => 'typography',
            'title' => __('Input Placeholders', 'flotheme'),
            //'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'help_img' => array('placeholder-typography.png'),
            'output' => array('input[type="text"]::-moz-placeholder, input[type="email"]::-moz-placeholder, input[type="password"]::-moz-placeholder, input[type="search"]::-moz-placeholder, textarea::-moz-placeholder',
                'input[type="text"]::-webkit-input-placeholder, input[type="email"]::-webkit-input-placeholder, input[type="password"]::-webkit-input-placeholder, input[type="search"]::-webkit-input-placeholder, textarea::-webkit-input-placeholder',
                'input[type="text"]:-ms-input-placeholder, input[type="email"]:-ms-input-placeholder, input[type="password"]:-ms-input-placeholder, input[type="search"]:-ms-input-placeholder, textarea:-ms-input-placeholder'),

            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-weight'  => '400',
                'color'       => '#000',
                'font-family' => '',
                'google' => true,

            ),
        ),

        array(
            'id' => $flo_prefix.'-buttons',
            'type' => 'typography',
            'title' => __('Buttons', 'flotheme'),
            //'subtitle' => __('default font: "Didot-Italic"','flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'help_img' => array('btn1.png', 'btn2.png'),
            'output' => array('.comments .comment-form input[type="submit"], input[type="submit"], input[type="button"]'),
            'units' => 'px',
            //'subtitle' => __('Typography option with each property can be called individually.', 'flotheme'),
            'placeholder' => array(
                'font-family' => '',
                'google' => true,
            ),
        ),
        array(
            'id' => $flo_prefix.'-footer_widget_title',
            'type' => 'typography',
            'title' => __('Footer Widget title', 'flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'units' => 'px',
            'help_img' => array('footer_widgets_title.jpg'),
            'output' => array('.main-footer .widget .widget-title'),
            'placeholder' => array(
                'font-weight'  => '400',
                'font-family' => '',
                'google' => true,
                'font-size' => '24px',
                'font-size-mobile' => '24px',
                'font-size-tablet' => '24px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-footer_widget_text',
            'type' => 'typography',
            'title' => __('Footer Widget text', 'flotheme'),
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
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'units' => 'px',
            //'help_img' => array('footer_widgets_title.jpg'),
            'output' => array('.main-footer .widget'),
            'placeholder' => array(
                'font-weight'  => '400',
                'font-family' => '',
                'google' => true,
                'font-size' => '14px',
                'font-size-mobile' => '14px',
                'font-size-tablet' => '14px',
            ),
        ),
    )
);
