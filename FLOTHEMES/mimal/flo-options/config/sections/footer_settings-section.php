<?php
global $flo_prefix;

$this->sections[] = array(
    'title' => __('Footer Settings', 'flotheme'),
    'icon' => 'footer',
    'class' => 'footer',
);
$this->sections[] = array(
    'title' => __('Copyright', 'flotheme'),
    'class' => 'copy',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-copy',
            'title' => __('Copyright', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Copyright",
            'doc_iframe' => "http://docs.flothemes.com/mimal-footer-settings/"
        ),
        array(
            'id' => $flo_prefix.'-editor',
            'type' => 'editor',
            'title' => __('Copyright text', 'flotheme'),
            'subtitle' => __('Type here the Copyright text that will appear in the footer.To display the current year use "%year%"', 'flotheme'),
            'default' => '',
        ),
        array(
            'id' => $flo_prefix.'-footer_copyright',
            'type' => 'typography',
            'title' => __('Copyright text typography', 'flotheme'),
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
            'output' => array('footer.main-footer .copyright'),
            'placeholder' => array(
                'font-weight'  => '400',
                'font-family' => '',
                'google' => true,
                'font-size' => '11px',
                'font-size-mobile' => '11px',
                'font-size-tablet' => '11px',
            ),
        ),

    )
);