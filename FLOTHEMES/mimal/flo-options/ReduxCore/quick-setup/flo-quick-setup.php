<?php
global $flo_options;

add_action('wp_ajax_set_home_page', 'flo_set_home_page' );
add_action('wp_ajax_set_blog_page', 'flo_set_blog_page' );
add_action('wp_ajax_set_main_menu', 'flo_maybe_set_main_menu' );
add_action('wp_ajax_quick_set_logo', 'flo_quick_set_logo' );
add_action('wp_ajax_quick_update_style_kit', 'flo_quick_update_style_kit' );
add_action('wp_ajax_quick_update_pemalins', 'flo_quick_update_pemalins' );
add_action('wp_ajax_quick_set_fav_ico', 'flo_quick_set_fav_ico' );


function flo_load_quick_setup_scripts(){
    if(isset($_GET['page']) && 'flo_quick_setup' == $_GET['page']){
        // enqueuse the quick setup js and css files only when the user is visiting that specific page
        wp_register_script('quick-setup', get_template_directory_uri() . '/flo-options/ReduxCore/quick-setup/js/quick-setup.js');
        wp_enqueue_script('quick-setup');

        wp_enqueue_style(
                'quick-setup',
                get_template_directory_uri() . '/flo-options/ReduxCore/quick-setup/css/quick-setup.css');
    }
        
}
add_action('admin_init', 'flo_load_quick_setup_scripts', 1);

add_action("after_switch_theme", "flo_redirect_quik_setup");
function flo_redirect_quik_setup(){

    // update all pages in atempt to fix any meta data that can conflict
    $pages = get_posts('post_type=page');
    foreach($pages as $page){
        wp_update_post($page);
    }

    // redirect the user to Quick setup tab in the theme options 
    // were they can choose the 'Quick setup' options they need
    
    
    wp_redirect( get_dashboard_url().'themes.php?page=flo_quick_setup', 301 );
    //wp_redirect( admin_url().'/admin.php?page=_flo_options&tab=12', 301 );
}


/**
 *
 * Create the quick setup menu under Appearance menu
 *
 */
if(!function_exists('flo_quick_setup_wizard')){
    function flo_quick_setup_wizard(){
        add_theme_page(__('Flothemes quick setup wizard','flotheme'), __('Flo quick setup','flotheme'), 'edit_theme_options', 'flo_quick_setup', 'flo_render_quick_setup_content');
    }
}
add_action('admin_menu', 'flo_quick_setup_wizard');


if(!function_exists('flo_render_quick_setup_content')){
    function flo_render_quick_setup_content(){
        include_once get_template_directory() . '/flo-options/ReduxCore/quick-setup/flo-quick-setup-content.php';
    }
}
//add_action("redux/options/flo_options/saved", 'flo_redux_options_change');
/**
*
* When the redux options are changed we check agains some options and set some initial settings if necessary
*
**/

function flo_redux_options_change() {

    $theme_data = wp_get_theme();

    // This options is set the save settings button is used for the first time
    if( $theme_data->Name.'flo-ok' != get_option('flo-quik-setup') ){
        flo_maybe_create_home_page(); // check if it is necessary to create a home page
        flo_maybe_create_default_menu(); // check if it  is necessary to create a default menu from the existing pages
        update_option('flo-quik-setup', $theme_data->Name.'flo-ok'); // set this flag option
    }

}

function flo_maybe_create_home_page(){

        $default_pages = array('Home');
        $existing_pages = get_pages();
        $temp = array();

        foreach ($existing_pages as $page) {
            $temp[] = $page->post_title;
        }

        $pages_to_create = array_diff($default_pages, $temp);

        foreach ($pages_to_create as $new_page_title) {
            $add_default_pages = array(
                'post_title' => $new_page_title,
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'page'
            );

            $result = wp_insert_post($add_default_pages);
        }

        $home = get_page_by_title('Home');

        update_option('show_on_front', 'page');
        update_option('page_on_front', $home->ID);

        return $home->ID;

}

if(!function_exists('flo_update_home_page')){
    function flo_update_home_page($page_id){
        update_option('show_on_front', 'page');

        update_option('page_on_front', $page_id);

    }
}



/**
 *
 * Set a given menu as the primary menu
 *
 * @param - menu ID
 *
 */
if(!function_exists('flo_set_main_menu')){
    function flo_set_main_menu($menu_id){
        $flotheme_nav_theme_mod['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $flotheme_nav_theme_mod);
    }
}


/**
 *
 * Crete a menu from the existing page and set it as the Primary menu
 *
 */
function flo_maybe_create_default_menu(){


    if (!has_nav_menu('primary')) {
        $primary_nav_id = wp_create_nav_menu('Main Menu', array('slug' => 'main_menu'));
        $flotheme_nav_theme_mod['primary'] = $primary_nav_id;

        if ($flotheme_nav_theme_mod) {
            set_theme_mod('nav_menu_locations', $flotheme_nav_theme_mod);
        }

        $primary_nav = wp_get_nav_menu_object('Main Menu');
        $primary_nav_term_id = (int) $primary_nav->term_id;
        $menu_items = wp_get_nav_menu_items($primary_nav_term_id);
        if (!$menu_items || empty($menu_items)) {
            $pages = get_pages();
            foreach ($pages as $page) {
                $item = array(
                    'menu-item-object-id' => $page->ID,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish'
                );
                wp_update_nav_menu_item($primary_nav_term_id, 0, $item);
            }
        }

        return $primary_nav_id; // return the ID of the created menu
    }else{

        return sprintf(__('There is already a Primary menu set, you can etid it from %s here %s','flotheme'),
                '<a href="'.get_dashboard_url().'nav-menus.php" target="_blank">','</a>'
            );
    }

    

}


/**
 *
 * This function precesses the Ajax request for setting up the main menu.
 * It will either create an menu frm the existig page,
 * or will set the menu selected by the user as main menu
 *
 */
if(!function_exists('flo_maybe_set_main_menu')){
    function flo_maybe_set_main_menu(){
        $response = array();

        if(isset($_POST['action']) && 'set_main_menu' == $_POST['action']){

            if(isset($_POST['menu_option']) && $_POST['menu_option'] == 'automatically' ){
                $main_menu = flo_maybe_create_default_menu();

                if(is_numeric($main_menu)){
                    
                    // when there is no main menu and it is actually created '$main_menu' is the created Menu ID
                    $response['message'] = sprintf(__('The Main menu was created succesfully. You can edit it %s here %s','flotheme'), '<a href="'.get_dashboard_url().'nav-menus.php?action=edit&menu='.$main_menu.'" target="_blank">', '</a>' );
                }else{
                    
                    // usually we get here when there already exists a primary menu
                    // in this case '$main_menu' is a strig telling us that the Primary menu already exists and we can edit it

                    $response['message'] = $main_menu;

                }
                

            }else if(isset($_POST['menu_option']) && $_POST['menu_option'] == 'manually' 
                && isset($_POST['manually_menu_option']) && is_numeric($_POST['manually_menu_option'])){

                $main_menu = $_POST['manually_menu_option'];

                // set the selected menu as the main menu
                flo_set_main_menu($main_menu);
                $response['message'] = sprintf(__('The selected menu was set as the main menu. You can edit it %s here %s','flotheme'), '<a href="'.get_dashboard_url().'nav-menus.php?action=edit&menu='.$main_menu.'" target="_blank">', '</a>' );
            }else{
                $response['message'] = __('Invalid Menu creation method was selected. Try again please.','flotheme');
            }
        }else{
            $response['message'] = __('Invalid action','flotheme');
        }

        echo json_encode($response);
        exit();
    }
}

/**
 *
 * Automatically create a page with the name Blog
 * @return - int the post ID
 *
 */
if(!function_exists('flo_maybe_create_blog_page')){
    function flo_maybe_create_blog_page(){

        $default_pages = array('Blog');
        $existing_pages = get_pages();
        $temp = array();

        foreach ($existing_pages as $page) {
            $temp[] = $page->post_title;
        }

        $pages_to_create = array_diff($default_pages, $temp);

        foreach ($pages_to_create as $new_page_title) {
            $add_default_pages = array(
                'post_title' => $new_page_title,
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'page'
            );

            $result = wp_insert_post($add_default_pages);
        }

        $blog = get_page_by_title('Blog');

        return $blog->ID;
    }
}

if(!function_exists('flo_set_blog_page_template')){
    function flo_set_blog_page_template($page_id){

        // assign the 'Latest Post Types' template to that page
        update_post_meta( $page_id, '_wp_page_template', 'templates/template-blog.php' );

        /*----------  Note!  ----------*/
        /*----------  The following code may varry from theme to theme  ----------*/

        $prefix = '_cmb2_minimal_';

        // tell it to show the latest blog posts
        update_post_meta( $page_id, $prefix.'post_type', 'post' );

        // tell it the view to use
        update_post_meta( $page_id, $prefix.'view_type', 'list_content_width_view' );

    }
}

/**
 *
 * Function that respondes to the Ajax request
 * It creates a home page, or sets one of the existing pages as the home page
 *
 */
if(!function_exists('flo_set_home_page')){
    function flo_set_home_page(){
        //var_dump($_POST);
        $response = array();
        if(isset($_POST['action']) && 'set_home_page' == $_POST['action']){

            if(isset($_POST['home_option'])){
                if($_POST['home_option'] == 'automatically'){
                    $home_page_id = flo_maybe_create_home_page();
                    $response['message'] = sprintf(__('The home page was created succesfully. You can edit it %s here %s','flotheme'), '<a href="'.get_edit_post_link($home_page_id).'" target="_blank">', '</a>' );

                }else if($_POST['home_option'] == 'manually'){

                    if(isset($_POST['manually_home_option']) && is_numeric($_POST['manually_home_option'])){

                        $home_pag_id = $_POST['manually_home_option'];

                        flo_update_home_page($home_pag_id);

                        $response['message'] = sprintf(__('The home page was created succesfully. You can edit it %s here %s','flotheme'), '<a href="'.get_edit_post_link($home_pag_id).'" target="_blank">', '</a>' );
                    }else{
                        $response['message'] = __('Invalid Home page','flotheme');
                    }

                }else{
                    $response['message'] = __('Invalid data received. Check the selected options and try again','flotheme');
                }
            }
        }else{
            $response['message'] = __('Invalid action','flotheme');
        }

        echo json_encode($response);

        exit();
    }
}


/**
 *
 * Function that respondes to the Ajax request
 * It creates a blog page, or sets one of the existing pages as the blog page
 *
 */
if(!function_exists('flo_set_blog_page')){
    function flo_set_blog_page(){
        $response = array();
        if(isset($_POST['action']) && 'set_blog_page' == $_POST['action']){

            if(isset($_POST['blog_option'])){
                if($_POST['blog_option'] == 'automatically'){
                    $blog_page_id = flo_maybe_create_blog_page();

                    flo_set_blog_page_template($blog_page_id); //assign the necessary template and view type

                    $response['message'] = sprintf(__('The blog page was created succesfully. You can edit it %s here %s','flotheme'), '<a href="'.get_edit_post_link($blog_page_id).'" target="_blank">', '</a>' );

                }else if($_POST['blog_option'] == 'manually'){

                    if(isset($_POST['manually_blog_option']) && is_numeric($_POST['manually_blog_option'])){

                        $blog_page_id = $_POST['manually_blog_option'];

                        flo_set_blog_page_template($blog_page_id); //assign the necessary template and view type

                        $response['message'] = sprintf(__('The blog page was created succesfully. You can edit it %s here %s','flotheme'), '<a href="'.get_edit_post_link($blog_page_id).'" target="_blank">', '</a>' );
                    }else{
                        $response['message'] = __('Invalid Blog page','flotheme');
                    }

                }else{
                    $response['message'] = __('Invalid data received. Check the selected options and try again','flotheme');
                }
            }
        }else{
            $response['message'] = __('Invalid action','flotheme');
        }

        echo json_encode($response);

        exit();
    }
}

/**
 *
 * Render the image uploader input
 * @params:
 *
 * 
 */
function quick_setup_image_uploader_field( $value = array('url' => '','id' => '', 'height' => '', 'width' => '', 'thumbnail' => ''), $img_type = 'logo')
{
    //$default = get_template_directory_uri() . '/img/no_img.png';
    if($img_type == 'logo'){
        $default = ReduxFramework::$_url . 'quick-setup/native_logo.png';
    }else if($img_type == 'fav_ico'){
        $default = get_template_directory_uri().'/favicon.ico';
    }

    if (isset($value['url']) && strlen($value['url']))  {
        $src              = $value['url'];
    } else {
        $src = $default;
    }

    echo '
    <div>
        <img data-src="' . $default . '" src="' . $src . '"  style="max-width:200px;" />
        <div>
            <button type="submit" class="quick_upload_image_button button" data-img_type="'.$img_type.'" >Upload</button>
            <button type="submit" class="quick_remove_image_button button">&times;</button>
        </div>
    </div>
    ';
}


if(!function_exists('flo_quick_set_fav_ico')){
    function flo_quick_set_fav_ico(){

        //var_dump($_POST);
        $img_logo = array(
                'url' => $_POST['attachment_url'],
                'id' => $_POST['attachment_id']
            );

        global $reduxConfig;

        // note fot the other theme replace the option prefix
        $reduxConfig->ReduxFramework->set('flo_minimal-favicon', $img_logo);

        exit();
    }
}

if(!function_exists('flo_quick_set_logo')){
    function flo_quick_set_logo(){

        //var_dump($_POST);
        $img_logo = array(
                'url' => $_POST['attachment_url'],
                'id' => $_POST['attachment_id'],
                'width' => $_POST['attachment_width'],
                'height' => $_POST['attachment_height'],
                'thumbnail' => $_POST['attachment_thumbnail']
            );

        global $reduxConfig;

        // note fot the other theme replace the option prefix
        $reduxConfig->ReduxFramework->set('flo_minimal-logo_type', 'image');
        $reduxConfig->ReduxFramework->set('flo_minimal-logo_image_desktop', $img_logo);

        exit();
    }
}

if(!function_exists('flo_quick_setup_radio_img')){
    function flo_quick_setup_radio_img($style_kits){
        if(is_array($style_kits) && sizeof($style_kits)){
            foreach ($style_kits as $style_kit_name => $style_kit_img) {
                $class_name = str_replace('.','_',$style_kit_name);
            ?>
                <div class="generic-input-radio-icon hidden <?php echo $class_name; ?>">
                    <input type="radio" value="<?php echo $style_kit_name; ?>" name="flo_style_kit" class="generic-record radio-icon-input  hidden  " >
                </div>

                <img onclick="flo_style_kit_radio_icon( '<?php echo $style_kit_name; ?>','<?php echo $class_name ?>' );" title="<?php echo $style_kit_name; ?> " class="pattern-texture  stylekit-type <?php echo $class_name ?>"  src="<?php echo $style_kit_img; ?>" />
            <?php
            }
        }

    }
}

/**
 *
 * Update the style kit
 *
 */
if(!function_exists('flo_quick_update_style_kit')){
    function flo_quick_update_style_kit(){

        $response = array();
        if(isset($_POST['style_kit'])){
            global $reduxConfig;

            // note fot the other theme replace the option prefix
            $reduxConfig->ReduxFramework->set('flo-style_sheet', $_POST['style_kit']);
            $response['message'] = __("The style Kit was updated succesfully",'flotheme');
        }else{
            $response['message'] = __('Wrong action','flotheme');
        }

        echo json_encode($response);

        exit();
    }
}

if(!function_exists('flo_quick_update_pemalins')){
    function flo_quick_update_pemalins(){

        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure( '/%postname%/' );
        flush_rewrite_rules();

        $response = array('message' => __('The permalinks were updated succesfully','flotheme'));

        echo json_encode($response);

        exit();
    }
}
?>