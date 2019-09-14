<?php
// attched images management
function flo_slideshow_meta_boxes()
{

    global $post;

    // add meta box that will hold attached images
    add_meta_box('lala-post-images', __('Slideshow Images', 'flotheme'), 'flo_slideshow_images_box', 'slideshow', 'normal', 'high');
    add_meta_box('lala-label', __('Scroll down label', 'flotheme'), 'flo_slideshow_label_box', 'slideshow','normal',
        'high');

}

add_action('add_meta_boxes', 'flo_slideshow_meta_boxes');

/**
 * Product Images
 *
 * Function for displaying the product images meta box.
 *
 */


/**
 * Display the product images meta box.
 *
 * @access public
 * @return void
 */
function flo_slideshow_images_box()
{
    global $post;
    ?>
    <style type="text/css">
        .logo_image_preview {
            max-width: 100px;
            height: auto;
        }
    </style>
    <div id="post_images_container" class="flo-slideshow-images generic-field">
        <ul class="product_images">
            <?php

            if (metadata_exists('post', $post->ID, '_post_image_gallery')) {

                $product_image_gallery = get_post_meta($post->ID, '_post_image_gallery', true);


                $attachments = array_filter(explode(',', $product_image_gallery));
            }

            if (metadata_exists('post', $post->ID, '_floslideshow')) {

                $_floslideshow = get_post_meta($post->ID, '_floslideshow', true);

            }


            if (isset($_floslideshow)) {
                foreach ($_floslideshow as $key => $data) {
                    $attachment_id = $data['meta_id'];
                    echo '<li class="image" data-attachment_id="' . $attachment_id . '">
							' . wp_get_attachment_image($attachment_id, 'thumbnail') . '
							<ul class="actions">
								<li><a href="#" class=" dashicons dashicons-edit edit-flo-slide" title="' . __('Edit image', 'flotheme') . '"></a></li>
								<li><a href="#" class=" dashicons dashicons-trash delete-flo-slide" title="' . __('Delete image', 'flotheme') . '"></a></li>
							</ul>
							' . flo_get_slider_image_meta($attachment_id, $data, $post->ID, $key) . '
						</li>';
                }
            }


            if (!isset($product_image_gallery)) {
                $product_image_gallery = '';
            }
            ?>
        </ul>

        <input type="hidden" id="product_image_gallery" name="product_image_gallery"
               value="<?php echo esc_attr($product_image_gallery); ?>"/>

    </div>
    <p class="add_slideshow_images hide-if-no-js" style="font-size:18px;">
        <a href="#" class="add_slideshow_images_link" style="">
            <input class="button media-button button-primary button-large " type="button"
                   value="<?php _e('Add Slideshow Images', 'flotheme'); ?>"/>
        </a>
        <input class="button media-button media-button_clean button-primary button-large " type="button"
               value="<?php _e('Add Clean Slide', 'flotheme'); ?>"/>
    </p>


    <script type="text/javascript">
        function show_hide_slideshow(attach_id) {
            if(!attach_id) {
                $('.content_type_radio').first().attr('checked');
            }
            if (jQuery("table[data-floslideshow-meta-id='" + attach_id + "'] input[type='radio']:checked").val() == 'logo') {
                jQuery('.for_title').each(function () {
                    jQuery(this).hide();
                })
                jQuery('.for_logo').each(function () {
                    jQuery(this).show();
                })
            }
            else {
                jQuery('.for_title').each(function () {
                    jQuery(this).show();
                })
                jQuery('.for_logo').each(function () {
                    jQuery(this).hide();
                })
            }
        }
        jQuery(document).ready(function ($) {

            var flo_sldshow_main_frame_meta = false,
                attach_id;

            // Uploading files
            var product_gallery_frame;
            var logo_frame;
            var $image_gallery_ids = $('#product_image_gallery');
            var $product_images = $('#post_images_container ul.product_images');
            var $logo_images = $('.floslideshow-logo-box');

            jQuery('.product_images').on('click', '.floslideshow-logo-box a.add_logo', function (e) {
                var $el1 = $(this);
                var $img;
                e.preventDefault();
                // Create the media frame.
                logo_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: '<?php _e( 'Add Images to Gallery', 'flotheme' ); ?>',
                    button: {
                        text: '<?php _e( 'Add to gallery', 'flotheme' ); ?>',
                    },
                    multiple: false
                });

                logo_frame.on('select', function () {
                    var selection1 = logo_frame.state().get('selection');
                    selection1.map(function (attachment) {
                        attachment = attachment.toJSON();
                        if (attachment.id) {
                            $img = attachment.url;
                        }
                    });
                    $el1.parents('td').find('.floslideshow-logo').val($img);
                    console.log($img);
                    $el1.parents('td').find('.logo_image_preview').attr('src', $img);
                });
                logo_frame.open();
            });


            jQuery('.add_slideshow_images').on('click', 'input.media-button_clean', function (event) {
                var $el = $(this);
                var attachment_ids = $image_gallery_ids.val();
                event.preventDefault();

                var rand_class = 'attach_' + Math.floor((Math.random() * 1000000));
                var at_id = '-' + Math.floor((Math.random() * 1000000));

                $product_images.append('\
								<li class="image clean_slide ' + rand_class + '" data-attachment_id="' + at_id + '">\
									\<img src="<?php echo get_template_directory_uri();?>/img/blank.gif" />\
									<ul class="actions">\
										<li><a href="#" class=" dashicons dashicons-edit edit-flo-slide" title="<?php _e( 'Edit image', 'flotheme' ); ?>"><?php //_e( 'Edit', 'flotheme' ); ?></a></li>\
										<li><a href="#" class=" dashicons dashicons-trash delete-flo-slide" title="<?php _e( 'Delete image', 'flotheme' ); ?>"><?php //_e( 'Delete', 'flotheme' ); ?></a></li>\
									</ul>\
								</li>');

                // add the slide data fields
                flo_get_sl_data(at_id, <?php echo $post->ID; ?>, rand_class); // this will appent the data table to the current attachment


            });

            jQuery('.add_slideshow_images').on('click', 'a', function (event) {

                var $el = $(this);
                var attachment_ids = $image_gallery_ids.val();

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if (product_gallery_frame) {
                    product_gallery_frame.open();
                    return;
                }

                // Create the media frame.
                product_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: '<?php _e( 'Add Images to Gallery', 'flotheme' ); ?>',
                    button: {
                        text: '<?php _e( 'Add to gallery', 'flotheme' ); ?>',
                    },
                    multiple: true
                });

                // When an image is selected, run a callback.
                product_gallery_frame.on('select', function () {

                    var selection = product_gallery_frame.state().get('selection');

                    selection.map(function (attachment) {

                        attachment = attachment.toJSON();

                        if (attachment.id) {
                            attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

                            var rand_class = 'attach_' + Math.floor((Math.random() * 1000000));

                            $product_images.append('\
								<li class="image ' + rand_class + '" data-attachment_id="' + attachment.id + '">\
									<img src="' + attachment.url + '" />\
									<ul class="actions">\
										<li><a href="#" class=" dashicons dashicons-edit edit-flo-slide" title="<?php _e( 'Edit image', 'flotheme' ); ?>"><?php //_e( 'Edit', 'flotheme' ); ?></a></li>\
										<li><a href="#" class=" dashicons dashicons-trash delete-flo-slide" title="<?php _e( 'Delete image', 'flotheme' ); ?>"><?php //_e( 'Delete', 'flotheme' ); ?></a></li>\
									</ul>\
								</li>');

                            // add the slide data fields
                            flo_get_sl_data(attachment.id, <?php echo $post->ID; ?>, rand_class); // this will appent the data table to the current attachment

                        }

                    });

                    $image_gallery_ids.val(attachment_ids);
                });

                // Finally, open the modal.
                product_gallery_frame.open();
            });


            // Image ordering
            $product_images.sortable({
                items: 'li.image',
                cursor: 'move',
                scrollSensitivity: 40,
                forcePlaceholderSize: true,
                forceHelperSize: false,
                helper: 'clone',
                handle: " > img",
                opacity: 0.65,
                placeholder: 'wc-metabox-sortable-placeholder',
                start: function (event, ui) {
                    ui.item.css('background-color', '#f6f6f6');
                },
                stop: function (event, ui) {
                    ui.item.removeAttr('style');
                },
                update: function (event, ui) {
                    var attachment_ids = '';

                    $('#post_images_container ul li.image').css('cursor', 'default').each(function () {
                        var attachment_id = jQuery(this).attr('data-attachment_id');
                        attachment_ids = attachment_ids + attachment_id + ',';
                    });

                    $image_gallery_ids.val(attachment_ids);
                }
            });

            // Remove images

            $('#post_images_container').on('click', 'a.delete-flo-slide_logo', function () {
                $(this).parents('td').find('img.logo_image_preview').attr('src',$('.blank_img').val());
                $(this).parents('td').find('input.floslideshow-logo').val('');
            });

            $('#post_images_container').on('click', 'a.delete-flo-slide', function () {

                $(this).closest('li.image').remove();

                var attachment_ids = '';

                $('#post_images_container ul li.image').css('cursor', 'default').each(function () {
                    var attachment_id = jQuery(this).attr('data-attachment_id');
                    attachment_ids = attachment_ids + attachment_id + ',';
                });

                $image_gallery_ids.val(attachment_ids);

                return false;
            });


            // Edit images

            // Close the modal
            $('#post_images_container').on('click', 'a.media-modal-close, .media-modal-backdrop', function () {

                //append_and_hide_meta();
                $(this).closest('.floslideshow-meta-container').hide();
                flo_sldshow_main_frame_meta = false;

            });

            // Close modal window on Esc key press
            $(document).off('keydown').on('keydown', function (e) {
                if (27 == e.keyCode && flo_sldshow_main_frame_meta) {
                    append_and_hide_meta(e);

                }
            });

            // Close the modal window on user action
            var append_and_hide_meta = function (e) {
                $('.floslideshow-meta-container').hide();
                soliloquy_main_frame_meta = false;
            };

            $('#lala-post-images').on('click', 'a.edit-flo-slide', function () {
                attach_id = $(this).closest('li.image').data('attachment_id');
                show_hide_slideshow(attach_id);
                $(this).closest('li.image').find('.floslideshow-meta-container').show();
                flo_sldshow_main_frame_meta = true;
            });
            $('#lala-post-images').on('change', '.content_type_radio input[type="radio"]', function () {
                attach_id = $(this).closest('li.image').data('attachment_id');
                show_hide_slideshow(attach_id);
            });

        });


    </script>
    <?php
}


add_action('save_post', 'flo_save_attached_images');

// save attached images meta data
function flo_save_attached_images($post_id)
{
    //// GLOBAL $POST
    global $post;

    // Gallery Images
    if (isset($_POST['product_image_gallery'])) {
        $attachment_ids = array_filter(explode(',', sanitize_text_field($_POST['product_image_gallery'])));
        update_post_meta($post_id, '_post_image_gallery', implode(',', $attachment_ids));

    }
    if (isset($_POST['portfolio_label'])) {
        $slideshow_data_label = $_POST['portfolio_label'];
        update_post_meta($post_id, 'portfolio_label', $slideshow_data_label);
    }
    //  Slideshow images Data
    if (isset($_POST['_floslideshow'])) {
        // Sanitize user input.
        $slideshow_data = $_POST['_floslideshow'];
        update_post_meta($post_id, '_floslideshow', $slideshow_data);

    }


}


//// REGISTER OUR STYLES for attached images AND PUTS IN OUR ADMIN PAGE
function flo_attached_images_style()
{
    wp_register_style('AttachedImagesStyle', get_template_directory_uri() . '/lib/css/attached_images.css');
    wp_enqueue_style('AttachedImagesStyle');
}


//// ADDS STYLE IN OUR HEAD SO THE attached images look nice
add_action('admin_init', 'flo_attached_images_style');

/**
 * Helper method for retrieving the slider image metadata.
 *
 * @param int $id The ID of the item to retrieve.
 * @param array $data Array of data for the item.
 * @param int $post_id The current post ID.
 * @return string      The HTML output for the slider item.
 */
function flo_get_slider_image_meta($id, $data, $post_id, $key)
{

    ob_start();
    ?>
    <div id="floslideshow-meta-<?php echo $id; ?>" class="floslideshow-meta-container" style="display:none;">
        <div class="media-modal wp-core-ui">

            <div class="media-modal-content">
                <div
                    class="media-frame floslideshow-media-frame wp-core-ui hide-menu hide-router floslideshow-meta-wrap">
                    <div class="media-frame-title">
                        <h1><?php _e('Edit Metadata', 'flotheme'); ?></h1>
                    </div>
                    <div class="media-frame-content">
                        <div class="attachments-browser">
                            <div class="floslideshow-meta attachments">
                                <?php do_action('floslideshow_before_image_meta_table', $id, $data, $post_id, $key); ?>
                                <input id="floslideshow-id-<?php echo $id; ?>" class="floslideshow-id" type="hidden"
                                       name="_floslideshow[<?php echo $key; ?>][meta_id]"
                                       value="<?php echo(!empty($id) ? esc_attr($id) : ''); ?>"
                                       data-floslideshow-meta="id"/>

                                <table id="floslideshow-meta-table-<?php echo $id; ?>"
                                       class="form-table floslideshow-meta-table"
                                       data-floslideshow-meta-id="<?php echo $id; ?>">
                                    <tbody>
                                    <?php do_action('floslideshow_before_image_meta_settings', $id, $data, $post_id, $key); ?>

                                    <tr>
                                        <th scope="row"><label><?php _e('Slide content type', 'flotheme'); ?></label>
                                        </th>
                                        <td class="content_type_radio"
                                            id="content_type_radio">
                                            <label for="slideshow_title">Title, Description</label>
                                            <input type="radio" id="slideshow_title" class="slideshow_title"
                                                   name="_floslideshow[<?php echo $key ?>][content_type_radio]"
                                                   value="title" <?php if (!isset($data['content_type_radio']) ||
                                            $data['content_type_radio'] == '' || isset
                                            ($data['content_type_radio']) && $data['content_type_radio'] ==
                                            'title'): ?>checked="checked"<?php endif;
                                            ?>/>
                                            <label for="slideshow_logo">Logo</label>
                                            <input type="radio" id="slideshow_logo" class="slideshow_logo"
                                                   name="_floslideshow[<?php echo $key ?>][content_type_radio]"
                                                   value="logo" <?php if (isset($data['content_type_radio']) &&
                                            $data['content_type_radio'] ==
                                            'logo'): ?>checked="checked"<?php endif;
                                            ?>/>
                                        </td>
                                    </tr>


                                    <tr id="floslideshow-logo-box-<?php echo $id; ?>" valign="middle"
                                        class="floslideshow-logo-box for_logo">
                                        <th scope="row"><label
                                                for="floslideshow-logo-<?php echo $id; ?>"><?php _e('Slide logo', 'flotheme'); ?></label>
                                        </th>
                                        <td>
                                            <input id="floslideshow-logo-<?php echo $id; ?>" class="floslideshow-logo"
                                                   type="hidden" name="_floslideshow[<?php echo $key; ?>][logo]"
                                                   value="<?php echo(!empty($data['logo']) ? esc_attr($data['logo']) : ''); ?>"
                                                   data-floslideshow-meta="title"/>
                                            <input class="blank_img" value="<?php echo get_template_directory_uri().
                                                '/img/blank.gif';?>" type="hidden"/>
                                            <a href="#"
                                               class="add_logo button media-button button-primary button-large "><?php echo __('Add Image', 'flotheme'); ?></a>

                                            <img class="logo_image_preview" src="<?php echo(!empty(
                                            $data['logo']) ? esc_attr($data['logo']) :
                                                get_template_directory_uri() . '/img/blank.gif'); ?>"/>
                                            <ul class="delete_image_logo">
                                                <li><a href="#" class=" dashicons dashicons-trash delete-flo-slide_logo" title="<?php _e( 'Delete image', 'flotheme' ); ?>"></a></li>
                                            </ul>
                                        </td>
                                    </tr>

                                    <tr id="floslideshow-title-box-<?php echo $id; ?>" valign="middle"
                                        class="for_title">
                                        <th scope="row"><label
                                                for="floslideshow-title-<?php echo $id; ?>"><?php _e('Slide Title', 'flotheme'); ?></label>
                                        </th>
                                        <td>
                                            <input id="floslideshow-title-<?php echo $id; ?>" class="floslideshow-title"
                                                   type="text" name="_floslideshow[<?php echo $key; ?>][title]"
                                                   value="<?php echo(!empty($data['title']) ? esc_attr($data['title']) : ''); ?>"
                                                   data-floslideshow-meta="title"/>


                                        </td>
                                    </tr>

                                    <?php do_action('floslideshow_before_image_meta_description', $id, $data, $post_id, $key); ?>
                                    <tr id="floslideshow-title-box-<?php echo $id; ?>" valign="middle"
                                        class="for_title">
                                        <th scope="row"><label
                                                for="floslideshow-title-<?php echo $id; ?>"><?php _e('Slide Description', 'flotheme'); ?></label>
                                        </th>
                                        <td>
                                            <textarea id="floslideshow-description-<?php echo $id; ?>"
                                                      class="floslideshow-description"
                                                      name="_floslideshow[<?php echo $key; ?>][description]"
                                                      value="<?php echo(!empty($data['description']) ? esc_attr($data['description']) : ''); ?>"
                                                      data-floslideshow-meta="description"><?php echo(!empty($data['description']) ? esc_attr($data['description']) : ''); ?></textarea>

                                        </td>
                                    </tr>

                                    <?php do_action('floslideshow_before_image_meta_video', $id, $data, $post_id, $key); ?>
                                    <tr id="floslideshow-video-box-<?php echo $id; ?>"
                                        class="floslideshow-link-cell for_title"
                                        valign="middle">
                                        <th scope="row"><label
                                                for="floslideshow-link-<?php echo $id; ?>"><?php _e('Video URL', 'flotheme'); ?></label>
                                        </th>
                                        <td>
                                            <input id="floslideshow-video-<?php echo $id; ?>" class="floslideshow-video"
                                                   type="text" name="_floslideshow[<?php echo $key; ?>][video]"
                                                   value="<?php echo(!empty($data['video']) ? esc_url($data['video']) : ''); ?>"
                                                   data-floslideshow-meta="video"/>

                                            <p class="description"><?php _e('If you want to add a video to the slide, add the video URL to this field (only Vimeo or Youtube URLs).', 'flotheme'); ?></p>
                                        </td>
                                    </tr>

                                    <!-- Text color option -->
                                    <tr id="floslideshow-text-color-box-<?php echo $id; ?>" valign="middle"
                                        class="for_title">
                                        <th scope="row"><label
                                                for="floslideshow-text-color-<?php echo $id; ?>"><?php _e('Text Color', 'flotheme'); ?></label>
                                        </th>
                                        <td>
                                            <input type="text" name="_floslideshow[<?php echo $key; ?>][text_color]"
                                                   value="<?php echo(!empty($data['text_color']) ? esc_attr($data['text_color']) : ''); ?>"
                                                   class="generic-meta-color-picker generic-record settings-color-field flo-slideshow-color-picker "/>

                                            <p class="description"><?php _e('Title text color', 'flotheme'); ?></p>
                                        </td>
                                    </tr>
                                    <tr id="floslideshow-title_hover_color-<?php echo $id; ?>" valign="middle"
                                        class="for_title">
                                        <th scope="row"><label
                                                for="floslideshow-title_hover_color-<?php echo $id; ?>"><?php _e('Title hover color', 'flotheme'); ?></label>
                                        </th>
                                        <td>
                                            <input type="text"
                                                   name="_floslideshow[<?php echo $key; ?>][title_hover_color]"
                                                   value="<?php echo(!empty($data['title_hover_color']) ? esc_attr($data['title_hover_color']) : ''); ?>"
                                                   class="generic-meta-color-picker generic-record settings-color-field flo-slideshow-color-picker "/>

                                            <p class="description"><?php _e('Title text hover color', 'flotheme'); ?></p>
                                        </td>
                                    </tr>
                                    <tr id="floslideshow-background_color-<?php echo $id; ?>" valign="middle"
                                        class="for_title">
                                        <th scope="row"><label
                                                for="floslideshow-background_color-<?php echo $id; ?>"><?php _e('Slide Background color', 'flotheme'); ?></label>
                                        </th>
                                        <td>
                                            <input type="text"
                                                   name="_floslideshow[<?php echo $key; ?>][background_color]"
                                                   value="<?php echo(!empty($data['background_color']) ? esc_attr($data['background_color']) : ''); ?>"
                                                   class="generic-meta-color-picker generic-record settings-color-field flo-slideshow-color-picker "/>

                                            <p class="description"><?php _e('Applied only to clean slides.', 'flotheme'); ?></p>
                                        </td>
                                    </tr>

                                    <?php do_action('floslideshow_after_image_meta_settings', $id, $data, $post_id, $key); ?>
                                    </tbody>
                                </table>
                                <?php do_action('floslideshow_after_image_meta_table', $id, $data, $post_id, $key); ?>
                            </div>
                            <!-- end .floslideshow-meta -->
                            <div class="media-sidebar">
                                <div class="floslideshow-meta-sidebar">
                                    <h4>
                                        <?php _e('Helpful Tips', 'flotheme');echo " : "; _e('Saving and Exiting',
                                            'flotheme');
                                        ?>
                                    </h4>
                                    <p class="no-margin"><?php _e('To save the added data, close this modal window and click on Update post button. You can close this window by either clicking on the "OK" above or hitting the esc key on your keyboard.', 'flotheme'); ?></p>
                                </div>
                                <!-- end .floslideshow-meta-sidebar -->
                            </div>
                            <!-- end .media-sidebar -->
                        </div>
                        <!-- end .attachments-browser -->
                    </div>
                    <!-- end .media-frame-content -->
                    <a class="media-modal-close ok_button" href="#">
                        <span class="media-modal-icon">
                            <input class="button button-primary button-small" id="publish" value="OK">
                        </span>
                    </a>
                </div>
                <!-- end .media-frame -->
            </div>
            <!-- end .media-modal-content -->
        </div>
        <!-- end .media-modal -->
        <div class="media-modal-backdrop"></div>
    </div>
    <?php

    return ob_get_clean();

}

function flo_get_slide_data()
{

    if (isset($_POST['post_id']) && isset($_POST['attachment_id']) && isset($_POST['container_class'])) {

        $key = $_POST['container_class']; // the unique key that will be used mark each slide info

        echo flo_get_slider_image_meta($_POST['attachment_id'], array(), $_POST['post_id'], $key);

    }

    exit;
}


// Add here functions for the 'floslideshow_after_image_meta_settings' action


/* TITLE URL */
add_action('floslideshow_before_image_meta_video', 'flo_sl_title_link', 10, 4); // priority 10 / 4 arguments
if (!function_exists('flo_sl_title_link')) {
    function flo_sl_title_link($id, $data, $post_id, $key)
    {
        ?>

        <tr id="floslideshow-title-link-box-<?php echo $id; ?>" class="floslideshow-link-cell"
            valign="middle">
            <th scope="row"><label
                    for="floslideshow-title-link-<?php echo $id; ?>"><?php _e('URL', 'flotheme'); ?></label></th>
            <td>
                <input id="floslideshow-title-link-<?php echo $id; ?>" class="floslideshow-title-link" type="text"
                       name="_floslideshow[<?php echo $key; ?>][title_link]"
                       value="<?php echo(!empty($data['title_link']) ? esc_url($data['title_link']) : ''); ?>"/>

                <p class="description"><?php _e('If you want to add a link to the slide title, add the URL to this field.', 'flotheme'); ?></p>
            </td>
        </tr>
        <?php
    }
}
// Add here functions for the 'floslideshow_after_image_meta_table' action

add_action('floslideshow_after_image_meta_table', 'flo_sl_init_color_picker', 10); // priority 10 / 4 arguments


if (!function_exists('flo_sl_init_color_picker')) {
    function flo_sl_init_color_picker()
    {
        ?>
        <script>
            // init color picker
            init_color_pickers('.flo-slideshow-color-picker');
        </script>
        <?php
    }
}
function flo_slideshow_label_box(){
    global $post;
    $portfolio_label = get_post_meta($post->ID, 'portfolio_label', true) && $post ? get_post_meta($post->ID,
        'portfolio_label', true) : '';
    ?>
    <p class="" style="font-size:15px;">
        <span><label for="portfolio_label">Scroll down label.</label></span></br>

        <input type="text" class="portfolio_label" value="<?php echo esc_attr($portfolio_label); ?>"
               name="portfolio_label"
               id="portfolio_label"/>

        <a href="<?php echo get_template_directory_uri(); ?>/img/quick_portfolio_label.jpg"
           data-fancybox-group="prettyPhoto_63618" title="See how it looks on the site" class="img-lightbox-hint" target="_blank"><span
                class="dashicons dashicons-editor-help"></span>
        </a>
    </p>
<?php }
?>
