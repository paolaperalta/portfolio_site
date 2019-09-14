<?php
global $wp_registered_sidebars, $flo_options;

foreach ($wp_registered_sidebars as $side) {
    $sidebar_value[$side['id']] = $side['name'];
}
//var_dump();die;
if (!isset($sidebar_value) || !(is_array($sidebar_value) || !empty($sidebar_value))) {
    $sidebar_value = array();
}
/* hide if is full width */
$classes = ' sidebar_list';

if (isset($_GET['post'])) {
    $meta = meta::get_meta((int)$_GET['post'], 'layout');

    if (isset($meta['type']) && $meta['type'] == 'full') {
        $classes = 'sidebar_list hidden';
    }
}

/*******************************************************************GALLERY************************************************************/

if (isset($flo_options['flo_minimal-gallery_categ_link']) && $flo_options['flo_minimal-gallery_categ_link'] != '') {
    $gallery_permalink = $flo_options['flo_minimal-gallery_link'];
} else {
    $gallery_permalink = '';
}
if (!$gallery_permalink) {
    $gallery_permalink = 'gallery';
}

if (isset($flo_options['flo_minimal-gallery_categ_link']) && $flo_options['flo_minimal-gallery_categ_link'] != '') {
    $gallery_categ_permalink = $flo_options['flo_minimal-gallery_categ_link'];
} else {
    $gallery_categ_permalink = '';
}
if (!$gallery_categ_permalink) {
    $gallery_categ_permalink = 'gallery-category';
}
if (isset($flo_options['flo_minimal-gallery_tags_link']) && $flo_options['flo_minimal-gallery_tags_link'] != '') {
    $gallery_tags_permalink = $flo_options['flo_minimal-gallery_tags_link'];
} else {
    $gallery_tags_permalink = '';
}
if (!$gallery_tags_permalink) {
    $gallery_tags_permalink = 'gallery-tag';
}

/* post type Gallery */
$res['gallery']['labels'] = array(
    'name' => _x('Galleries', 'post type general name', 'flotheme'),
    'singular_name' => _x('Gallery', 'post type singular name', 'flotheme'),
    'add_new' => _x('Add New', 'Gallery', 'flotheme'),
    'add_new_item' => __('Add New Gallery', 'flotheme'),
    'edit_item' => __('Edit Gallery', 'flotheme'),
    'new_item' => __('New Gallery', 'flotheme'),
    'view_item' => __('View Gallery', 'flotheme'),
    'search_items' => __('Search Gallery', 'flotheme'),
    'not_found' => __('Nothing found', 'flotheme'),
    'not_found_in_trash' => __('Nothing found in Trash', 'flotheme')
);
$res['gallery']['args'] = array(
    'menu_icon' => '',
    'public' => true,
    'hierarchical' => false,
    'rewrite' => array('slug' => $gallery_permalink, 'with_front' => true),
    'menu_position' => 7,
    'supports' => array('title', 'editor', 'thumbnail' /*, 'comments'*/),
    '__on_front_page' => true
);
$bg_color_icon = fields::post_metabox_help_img('list_bg_color.jpg');
$text_color_icon = fields::post_metabox_help_img('lis_text_color.jpg');
$gallery_category = array(
    'hierarchical' => true,
    'labels' => array(
        'name' => _x('Gallery Categories', 'taxonomy general name', 'flotheme'),
        'singular_name' => _x('Gallery Category', 'taxonomy singular name', 'flotheme'),
        'search_items' => __('Search Categories', 'flotheme'),
        'all_items' => __('All Categories', 'flotheme'),
        'parent_item' => __('Parent Category', 'flotheme'),
        'parent_item_colon' => __('Parent Category:', 'flotheme'),
        'edit_item' => __('Edit Category', 'flotheme'),
        'update_item' => __('Update Category', 'flotheme'),
        'add_new_item' => __('Add New Category', 'flotheme'),
        'new_item_name' => __('New Category Name', 'flotheme'),
        'menu_name' => __('Categories', 'flotheme'),
    ),
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array('slug' => $gallery_categ_permalink),
);

$gallery_tag = array(
    'hierarchical' => false,
    'labels' => array(
        'name' => _x('Gallery Tags', 'taxonomy general name', 'flotheme'),
        'singular_name' => _x('Gallery Tag', 'taxonomy singular name', 'flotheme'),
        'search_items' => __('Search Tags', 'flotheme'),
        'popular_items' => __('Popular Tags', 'flotheme'),
        'all_items' => __('All Tags', 'flotheme'),
        'parent_item' => NULL,
        'parent_item_colon' => NULL,
        'edit_item' => __('Edit Tag', 'flotheme'),
        'update_item' => __('Update Tag', 'flotheme'),
        'add_new_item' => __('Add New Tag', 'flotheme'),
        'new_item_name' => __('New Tag Name', 'flotheme'),
        'separate_items_with_commas' => __('Separate tags with commas', 'flotheme'),
        'add_or_remove_items' => __('Add or remove tags', 'flotheme'),
        'choose_from_most_used' => __('Choose from the most used tags', 'flotheme'),
        'menu_name' => __('Tags', 'flotheme'),
    ),
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array('slug' => $gallery_tags_permalink),
);
register_taxonomy('gallery-category', 'gallery', $gallery_category);
register_taxonomy('gallery-tag', 'gallery', $gallery_tag);

resources::$labels['gallery'] = $res['gallery']['labels'];
resources::$type['gallery'] = $res['gallery']['args'];

/* BOF post type slideshow */
$res['slideshow']['labels'] = array(
    'name' => _x('Slideshow', 'post type general name', 'flotheme'),
    'singular_name' => _x(__('Slideshow', 'flotheme'), 'post type singular name'),
    'add_new' => _x('Add New', 'Slideshow', 'flotheme'),
    'add_new_item' => __('Add New Slideshow', 'flotheme'),
    'edit_item' => __('Edit Slideshow', 'flotheme'),
    'new_item' => __('New Slideshow', 'flotheme'),
    'view_item' => __('View Slideshow', 'flotheme'),
    'search_items' => __('Search Slideshow', 'flotheme'),
    'not_found' => __('Nothing found', 'flotheme'),
    'not_found_in_trash' => __('Nothing found in Trash', 'flotheme')
);
$res['slideshow']['args'] = array(
    'public' => true,
    'hierarchical' => false,
    'menu_position' => 3,
    'supports' => array('title'),
    'exclude_from_search' => true,
    '__on_front_page' => true,
    'menu_icon' => ''
);

/*=====================================================*/
/*================------Slideshow-----=================*/
/*=====================================================*/

resources::$labels['slideshow'] = $res['slideshow']['labels'];
resources::$type['slideshow'] = $res['slideshow']['args'];
/* EOF slideshow */

/* standard post */

$classes_p = 'sidebar_list hidden';
if (!(is_array($sidebar_value) || !empty($sidebar_value))) {
    $sidebar_value = array();
}
if (isset($_GET['post'])) {
    $meta = meta::get_meta((int)$_GET['post'], 'settings');
    if (isset($meta['include_below_page_content_sidebar']) && $meta['include_below_page_content_sidebar'] == 'yes') {
        $classes_p = 'sidebar_list';
    }
}

$page_layout = array('full_width' => 'full_width.png', 'right_sidebar' => 'sidebar_right.png', 'left_sidebar' => 'sidebar_left.png');
if (isset($flo_options) && isset($flo_options['flo_minimal-pages-sidebar']) && $flo_options['flo_minimal-pages']) {
    $cur_width_p = $flo_options['flo_minimal-pages'];
    $cur_side_p = $flo_options['flo_minimal-pages-sidebar'];
} else {
    $cur_width_p = 'full_width';
    $cur_side_p = 'full_width';
}

$form['page']['layout']['type'] = array('type' => 'st--radio-icon', 'value' => $page_layout, 'path' =>
    'icons/', 'in_row' => 3,'label' => __('Select layout type', 'flotheme'),
    'action' =>"show_hide_options(this,['right_sidebar','left_sidebar'], '.sidebar_list');",
    'id' => 'post_layout', 'ivalue' => $cur_width_p);

$form['page']['layout']['sidebar'] = array('type' => 'sh--select', 'label' => __('Select widget area.', 'flotheme'),
    'value' => $sidebar_value, 'classes' => $classes, 'ivalue' => $cur_side_p);

$form['page']['layout']['link'] = array('type' => 'sh--link', 'url' => 'admin.php?page=_flo_options&tab=11',
    'title' => __('Add New Widget Area.', 'flotheme'));
if (isset($_GET['post'])) {
    $layout = meta::get_meta($_GET['post'], 'layout');
    if (isset($layout['type']) && 'full_width' == $layout['type']) {
        $form['page']['layout']['sidebar']['classes'] = $classes . ' hidden';
        $form['page']['layout']['link']['classes'] = $classes . ' hidden';
    }
} else if (options::get_value('layout', 'page') == 'full_width') {
    $form['page']['layout']['sidebar']['classes'] = $classes . ' hidden';
    $form['page']['layout']['link']['classes'] = $classes . ' hidden';
}

$slideshow_select1 = get__posts(array('post_status' => 'publish', 'post_type' => 'slideshow', 'posts_per_page' => -1), '');
$select_default = array('0' => 'No Slideshow');
$slideshow_select = $select_default + $slideshow_select1;
$slideshow_type = array(
	'menu_over' => 'Menu over slideshow',
	'menu_outside_top' => "Menu above the slideshow"
);
$form['page']['slideshowSettings']['slideshow_select'] = array('type' => 'st--select',
    'label' => __('Select slideshow', 'flotheme'), 'value' => $slideshow_select);
$form['page']['slideshowSettings']['slideshow_type'] = array('type' => 'st--select', 'classes'=>'flo-slideshow-options', 'label' => __('Select menu position.', 'flotheme'), 'value' => $slideshow_type);


$form['page']['settings']['page_title'] = array('type' => 'st--logic-radio', 'label' => __('Show page title', 'flotheme'), 'hint' => 'Show page title on this page', 'cvalue' => 'yes');

//Select sidebar before page content

//Select sidebar before page content

$form['page']['settings']['include_before_page_content_sidebar'] = array('type' => 'st--logic-radio', 'label' => __
('Enable widget area located before the page content ?', 'flotheme'), 'hint' => 'This enables the Widget area located
before page content, and all the widgets added there will be shown on this page', 'cvalue' => 'no',
    'action' => "act.check( this , {  'yes' : '.select_sidebar_before'} , 'sh')",
);
$classes_p = 'select_sidebar_before hidden';
if ($flo_options && isset($flo_options['sidebars_before']) && $flo_options['sidebars_before'] != '') {
    $sidebar_value_old = $flo_options['sidebars_before'];
} else {
    $sidebar_value_old = array();
}

$sidebar_value_p = array();
foreach ($sidebar_value_old as $k => $side) {

    $sidebar_value_p[$k] = $side['title'];
}
if (!(is_array($sidebar_value_p) || !empty($sidebar_value_p))) {
    $sidebar_value_p = array();
}
if (isset($_GET['post'])) {
    $meta = meta::get_meta((int)$_GET['post'], 'settings');
    if (isset($meta['include_before_page_content_sidebar']) && $meta['include_before_page_content_sidebar'] == 'yes') {
        $classes_p = 'select_sidebar_before';
    } else {
        $classes_p = 'select_sidebar_before hidden ';
    }
}
if (isset($_GET['post'])) {
    $layout = meta::get_meta($_GET['post'], 'settings');

    if (isset($meta['include_before_page_content_sidebar']) && $meta['include_before_page_content_sidebar'] == 'yes') {
        $form['page']['settings']['sidebar_before']['classes'] = $classes_p;
        $form['page']['settings']['link_before']['classes'] = $classes_p;
    }
} else {
    $form['page']['settings']['sidebar_before']['classes'] = '  sidebar_list hidden';
    $form['page']['settings']['link_before']['classes'] = ' sidebar_list hidden';
}
$sidebar_value['sidebar-about'] = 'Sidebar About';
$form['page']['settings']['sidebar_before'] = array('type' => 'sh--select', 'label' => __('Select widget area.',
    'flotheme'),
    'value' => $sidebar_value, 'classes' => "$classes_p select_sidebar_before");
$form['page']['settings']['link_before'] = array('type' => 'sh--link', 'url' => 'admin.php?page=_flo_options&tab=11',
    'title' => __('Add New vidget area.', 'flotheme'), 'classes' => ' sidebar_list_before hidden select_sidebar_before
     ');


//Below page content sidebar
$form['page']['settings']['include_below_page_content_sidebar'] = array('type' => 'st--logic-radio', 'label' => __('Enable widget area located below the page content ?', 'flotheme'), 'hint' => 'This enables the Widget area located below page content, and all the widgets added there will be shown on this page', 'cvalue' => 'no',
    'action' => "act.check( this , {  'yes' : '.select_sidebar'} , 'sh')",
);
$classes_p = 'sidebar_list_below hidden';
if ($flo_options && isset($flo_options['flo_vivi-sidebars']) && $flo_options['flo_vivi-sidebars'] != '') {
    $sidebar_value_old = $flo_options['flo_vivi-sidebars'];
} else {
    $sidebar_value_old = array();
}

$sidebar_value_p = array();
foreach ($sidebar_value_old as $k => $side) {
    $sidebar_value_p[$k] = $side['title'];
}
if (!(is_array($sidebar_value_p) || !empty($sidebar_value_p))) {
    $sidebar_value_p = array();
}
if (isset($_GET['post'])) {
    $meta = meta::get_meta((int)$_GET['post'], 'settings');
    if (isset($meta['include_below_page_content_sidebar']) && $meta['include_below_page_content_sidebar'] == 'yes') {
        $classes_p = 'sidebar_list_below';
    }
}
if (isset($_GET['post'])) {
    $layout = meta::get_meta($_GET['post'], 'settings');

    if (isset($meta['include_below_page_content_sidebar']) && $meta['include_below_page_content_sidebar'] == 'yes') {
        $form['page']['settings']['sidebar']['classes'] = $classes;
        $form['page']['settings']['link']['classes'] = $classes;
    }
} else {
    $form['page']['settings']['sidebar']['classes'] = $classes . ' hidden';
    $form['page']['settings']['link']['classes'] = $classes . ' hidden';
}
$sidebar_value['sidebar-about'] = 'Sidebar About';
$form['page']['settings']['sidebar'] = array('type' => 'sh--select', 'label' => __('Select widget area.', 'flotheme'),
    'value' => $sidebar_value, 'classes' => $classes_p . " select_sidebar");
$form['page']['settings']['link'] = array('type' => 'sh--link', 'url' => 'admin.php?page=_flo_options&tab=11',
    'title' => __('Add New Widget Area', 'flotheme'), 'classes' => $classes_p . ' select_sidebar ');
$box['page']['slideshowSettings'] = array(__('Slideshow Settings', 'flotheme'), 'normal', 'low', 'content' =>
    $form['page']['slideshowSettings'], 'box' => 'slideshowSettings', 'update' => true);
$box['page']['layout'] = array(__('Layout and Sidebars', 'flotheme'), 'side', 'low', 'content' => $form['page']['layout'], 'box' => 'layout', 'update' => true);
$box['page']['settings'] = array(__('Page Settings', 'flotheme'), 'normal', 'high', 'content' => $form['page']['settings'], 'box' => 'settings', 'update' => true);
resources::$type['page'] = array();
resources::$box['page'] = $box['page'];
?>
