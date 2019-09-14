<?php
global $flo_prefix;

$this->sections[] = array(
    'title' => __('Custom Css', 'flotheme'),
    'icon' => 'custom_css',
    'class' => 'custom_css',
);
$this->sections[] = array(
    'title' => __('Snippets', 'flotheme'),
    'class' => 'snippets',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'divider-custom_css',
            'title' => __('Custom Css', 'flotheme'),
            'type' => 'info',
            'class' => 'header_info',
            'desc' => "Custom Css",
            'doc_iframe' => "http://docs.flothemes.com/mimal-add-custom-css/"
        ),
        array(
            'id' => $flo_prefix.'-custom_css',
            'type' => 'ace_editor',
            'title' => __('CSS Code', 'flotheme'),
            'subtitle' => __('Paste your CSS code here.', 'flotheme'),
            'mode' => 'css',
            'theme' => 'monokai',
            //                        'desc' => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
            'default' => ""
        ),
    )
);