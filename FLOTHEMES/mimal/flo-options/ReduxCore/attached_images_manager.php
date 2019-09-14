<?php
// attched images management

function cosmo_meta_boxes() {
    global $post;

    // add meta box that will hold attached images
    add_meta_box( 'lala-post-images', __( 'Attached Images', 'flotheme' ), 'cosmo_product_images_box', 'gallery', 'normal', 'high' );
    /*add_meta_box( 'lala-post-images', __( 'Attached Images', 'flotheme' ), 'cosmo_product_images_box', 'page', 'side', 'high' );
		add_meta_box( 'lala-post-images', __( 'Attached Images', 'flotheme' ), 'cosmo_product_images_box', 'post', 'side', 'high' );*/

}

add_action( 'add_meta_boxes', 'cosmo_meta_boxes' );

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
function cosmo_product_images_box() {
    global $post;
    ?>

    <div class="gallery-image-block">
        <div class="sub-images actions">
            <div class="add_product_images hide-if-no-js">
                <a href="#" class="button button-primary add-img-btn">+ <?php _e( 'Add gallery images', 'flotheme' ); ?></a>
            </div>

            <div class="edit-actions">
                <a href="#" class="button reverse-img-btn"><?php _e( 'Reverse images order', 'flotheme' ); ?></a>
                <a href="#" class="button delete-img-btn" ><?php _e( 'Delete all images', 'flotheme' ); ?></a>
            </div>
        </div>
        <div id="post_images_container">
            <ul class="product_images">
                <?php

                if ( metadata_exists( 'post', $post->ID, '_post_image_gallery' ) ) {

                    $product_image_gallery = get_post_meta( $post->ID, '_post_image_gallery', true );

                    $attachments = array_filter( explode( ',', $product_image_gallery ) );
                }


                if ( isset( $attachments ) ){
                    foreach ( $attachments as $attachment_id ) {
                        echo '<li class="image" data-attachment_id="' . $attachment_id . '">
    							' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
    							<ul class="actions">
    								<li><a href="#" class=" dashicons dashicons-trash" title="' . __( 'Delete image', 'flotheme' ) . '"></a></li>
    							</ul>
    						</li>';
                    }
                }



                if(!isset($product_image_gallery)){
                    $product_image_gallery = '';
                }
                ?>
            </ul>

            <input type="hidden" id="product_image_gallery" class="product_image_gallery" name="product_image_gallery" value="<?php echo esc_attr( $product_image_gallery ); ?>" />
        </div>



    </div>


    <script type="text/javascript">
        jQuery(document).ready(function($){

            // Uploading files
            var product_gallery_frame;
            var $image_gallery_ids = $('#product_image_gallery');
            var $product_images = $('#post_images_container ul.product_images');

            jQuery('.add_product_images').on( 'click', 'a.add-img-btn', function( event ) {

                var $el = $(this);
                var attachment_ids = $image_gallery_ids.val();

                event.preventDefault();

                // If the media frame already exists, reopen it.
                if ( product_gallery_frame ) {
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
                product_gallery_frame.on( 'select', function() {

                    var selection = product_gallery_frame.state().get('selection');

                    selection.map( function( attachment ) {

                        attachment = attachment.toJSON();

                        if ( attachment.id ) {
                            attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

                            $product_images.append('\
								<li class="image" data-attachment_id="' + attachment.id + '">\
									<img src="' + attachment.url + '" />\
									<ul class="actions">\
										<li><a href="#" class=" dashicons dashicons-trash" title="<?php _e( 'Delete image', 'flotheme' ); ?>"><?php //_e( 'Delete', 'flotheme' ); ?></a></li>\
									</ul>\
								</li>');
                        }

                    } );

                    $image_gallery_ids.val( attachment_ids );
                });

                // Finally, open the modal.
                product_gallery_frame.open();
            });

            // Image ordering
            $product_images.sortable({
                items: 'li.image',
                cursor: 'move',
                scrollSensitivity:40,
                forcePlaceholderSize: true,
                forceHelperSize: false,
                helper: 'clone',
                opacity: 0.65,
                placeholder: 'wc-metabox-sortable-placeholder',
                start:function(event,ui){
                    ui.item.css('background-color','#f6f6f6');
                },
                stop:function(event,ui){
                    ui.item.removeAttr('style');
                },
                update: function(event, ui) {
                    var attachment_ids = '';

                    $('#post_images_container ul li.image').css('cursor','default').each(function() {
                        var attachment_id = jQuery(this).attr( 'data-attachment_id' );
                        attachment_ids = attachment_ids + attachment_id + ',';
                    });

                    $image_gallery_ids.val( attachment_ids );
                }
            });

            // Remove images
            $('#post_images_container').on( 'click', 'a.dashicons-trash', function() {

                $(this).closest('li.image').remove();

                var attachment_ids = '';

                $('#post_images_container ul li.image').css('cursor','default').each(function() {
                    var attachment_id = jQuery(this).attr( 'data-attachment_id' );
                    attachment_ids = attachment_ids + attachment_id + ',';
                });

                $image_gallery_ids.val( attachment_ids );

                return false;
            } );

            jQuery('.edit-actions').on( 'click', 'a.reverse-img-btn', function( event ) {
                reverseImages('.product_images.ui-sortable','.product_image_gallery');
                return false;
            });

            jQuery('.edit-actions').on( 'click', 'a.delete-img-btn', function( event ) {
                if(confirm('Are you sure you want to delete all the images ?')){
                    jQuery('ul.product_images').empty();
                    jQuery('.product_image_gallery').val('');
                }

                return false;
            });

        });

        //this function  will reverse the images order
        // reverseImages('.product_images.ui-sortable','.product_image_gallery');
        function reverseImages(the_ul, the_input){
            // product_images ui-sortable
            // product_image_gallery


            var list = jQuery(the_ul);
            var listItems = list.children('li');

            list.empty().append(listItems.get().reverse()); // revrse the images

            var input_val = jQuery(the_input).val();
            //reverse the value of the hidden input

            jQuery(the_input).val( input_val.split(",").reverse().join(",") );

        }
    </script>
<?php
}


add_action('save_post', 'lala_save_attached_images');

// save attached images meta data
function lala_save_attached_images($post_id){
    //// GLOBAL $POST
    global $post;

    // Gallery Images
    if(isset($_POST['product_image_gallery'] )){
        $attachment_ids = array_filter( explode( ',', lala_clean( $_POST['product_image_gallery'] ) ) );
        update_post_meta( $post_id, '_post_image_gallery', implode( ',', $attachment_ids ) );

    }

    if(isset($_POST['gallery_type'] )){
        //$attachment_ids = array_filter( explode( ',', lala_clean( $_POST['product_image_gallery'] ) ) );
        update_post_meta( $post_id, '_post_gallery_type', lala_clean( $_POST['gallery_type']) );

    }

}


//// REGISTER OUR STYLES for attached images AND PUTS IN OUR ADMIN PAGE
function lala_attached_images_style() {
    wp_register_style('AttachedImagesStyle', get_template_directory_uri().'/flo-options/ReduxCore/assets/css/attached_images.css');
    wp_enqueue_style('AttachedImagesStyle');
}


//// ADDS STYLE IN OUR HEAD SO THE attached images look nice
add_action('admin_init', 'lala_attached_images_style');

/**
 * Clean variables
 *
 * @access public
 * @param string $var
 * @return string
 */
function lala_clean( $var ) {
    return sanitize_text_field( $var );
}

?>
