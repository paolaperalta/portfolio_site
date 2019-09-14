<?php
global $flo_prefix;
$this->sections[] = array(
    'title' => __('Header and Logo', 'flotheme'),
    'icon' => 'header',
    'class' => 'header',
);


$this->sections[] = array(
    'title' => __('Menu', 'flotheme'),
    'class' => 'flo_menu',
    'subsection' => true,
    'customizer' => false,
    'fields' => array(
        array(
            'id' => 'divider-flo_menu',
            'title' => __('Menu', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Menu",
            'doc_iframe' => "http://docs.flothemes.com/mimal-header-settings/#menu"
        ),
        array(
            'id' => $flo_prefix.'-menu',
            'type' => 'typography',
            'title' => __('Menu Typography', 'flotheme'),
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
            'all_styles' => false,
            'units' => 'px',
            'output' => array('.nav-menu > li a, header.main-header .header-actions .search label, .language-select *'),
            'help_img' => array('menu_typography.jpg'),
            'placeholder' => array(
                'font-weight'  => '400',
                'font-family' => '',
                'google' => true,
                'font-size' => '12px',
                'font-size-mobile' => '12px',
                'font-size-tablet' => '12px',
                'letter-spacing' => '1.2px'
            ),
        ),
        array(
            'id' => $flo_prefix.'-menu_color',
            'type' => 'color',
            //'mode' => 'background-color',
            'transparent' => false,
            'title' => __('Menu color', 'flotheme'),
            'output' => array('.nav-menu > li a','.header-actions','.header-actions a')
        ),
        array(
            'id' => $flo_prefix.'-submenu_links',
            'type' => 'typography',
            'title' => __('Submenu Typography', 'flotheme'),
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
            'help_img' => 'submenu_links.jpg',
            'output' => array('.nav-menu li .header_main-nav_sub-menu a'),
            'placeholder' => array(
                'font-weight'  => '400',
                'font-family' => '',
                'google' => true,
                'font-size' => '12px',
                'font-size-mobile' => '12px',
                'font-size-tablet' => '12px',
            ),
        ),
    )
);
$this->sections[] = array(
    'title' => __('Logo', 'flotheme'),
    'class' => 'logo',
    'subsection' => true,
    'customizer' => false,
    'fields' => array(
        array(
            'id' => 'divider-logo',
            'title' => __('Logo', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Logo",
            'doc_iframe' => "http://docs.flothemes.com/mimal-header-settings/#logo"
        ),
        array(
            'id' => $flo_prefix.'-logo_position',
            'type' => 'image_select',
            'title' => __('Logo / Menu : position', 'flotheme'),
            'options' => $logo_position,
            'default' => '1',
        ),
        array(
            'id' => $flo_prefix.'-logo_type',
            'type' => 'select',
            'title' => __('Logo Type', 'flotheme'),
            'options' => array('text' => 'Site Title', 'image' => 'Image'),
            'default' => 'text',
        ),
        array(
            'id' => $flo_prefix.'-logo_image_desktop',
            'class' => 'child_class',
            'type' => 'media',
            'required' => array('flo_minimal-logo_type', '=', 'image'),
            'title' => __('Upload the logo image', 'flotheme'),
        ),
        array(
            'id' => $flo_prefix.'-logo_image_mobile',
            'class' => 'child_class',
            'type' => 'media',
            'required' => array('flo_minimal-logo_type', '=', 'image'),
            'title' => __('Upload the mobile logo image', 'flotheme'),
        ),
        array(
            'id'    => 'info_warning',
            'type'  => 'info',
            'style' => 'normal',
            'required' => array('flo_minimal-logo_type', '=', 'text'),
            'desc'  => __('You can change the Site Title <a href="' . get_site_url() . '/wp-admin/options-general.php">here</a>.', 'flotheme')
        ),
        array(
            'id' => $flo_prefix.'-logo_text',
            'type' => 'typography',
            'title' => __('Text logo', 'flotheme'),
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
            'required' => array('flo_minimal-logo_type', '=', 'text'),
            'color' => true,
            'letter-spacing' => true, // Defaults to false
            'letter-spacing-mobile' => true, // Defaults to false
            'letter-spacing-tablet' => true, // Defaults to false
            'preview' => true, // Disable the previewer
            'all_styles' => true,
            'units' => 'px',
            'output' => array('header .logo a, header.main-header .hero-block__slider .hero_nav .logo a'),
            'subtitle' => __('Set typography for text logo.', 'flotheme'),
            'help_img' => array('slideshow_logo.jpg'),
            'placeholder' => array(

                'font-weight'  => '400',
                'color' => '#504c49',
                'google' => true,
                'font-family' => '',
                'font-size' => '18px',
                'font-size-mobile' => '16px',
                'font-size-tablet' => '17px',
            ),
        ),
        array(
            'id' => $flo_prefix.'-max_logo_width',
            'type' => 'text',
            'title' => __('Max Logo Width (in px)', 'flotheme'),
            'default' => '',
            'mode' => 'max-width',
            'output' => array('.main-navigation .logo img'),
            'validate' => 'numeric',
            'customizer' => true,
        ),
        array(
            'id' => $flo_prefix.'-max_logo_mobile_width',
            'type' => 'text',
            'title' => __('Max Logo mobile Width (in px)', 'flotheme'),
            'default' => '',
            'validate' => 'numeric',
            'class' => '',
            'customizer' => true,
        ),
    )
);

$this->sections[] = array(
    'title' => __('Settings', 'flotheme'),
    'class' => 'settings',
    'subsection' => true,
    'customizer' => false,
    'fields' => array(
        array(
            'id' => 'divider-settings',
            'title' => __('Settings', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Settings",
            'doc_iframe' => "http://docs.flothemes.com/mimal-header-settings/#settings"
        ),
        array(
            'id' => $flo_prefix.'-enable_sticky_header',
            'type' => 'button_set',
            'options' => array(
                '0' => 'No',
                '1' => 'Yes'
            ),
            'customizer' => true,
            'title' => __("Enable Sticky Header", 'flotheme'),
            'default' => '1',
        ),
        array(
            'id' => $flo_prefix.'-enable_search_in_header',
            'type' => 'button_set',
            'options' => array(
                '0' => 'Off',
                '1' => 'On'
            ),
            'customizer' => true,
            'title' => __("Enable Search in Header?", 'flotheme'),
            'default' => '1',
        ),
    )
);
