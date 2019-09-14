var meta = new Object();
meta.save = function( res , box , post_id , selector ){
	var selected_box_id = jQuery('.'+box+'-idrecord option:selected').val(); 
	
	/*for some meta we need to check if user has selected from provided select a real value
	 In the array bellow add those meta  to be checked:
	*/
	var exceptions_meta_arr = [ "conference","presentation","exhibitor", "sponsor" ,"speaker" ];
	
	/*check if exceptions_meta_arr  contains  'box' */
	var is_exception_meta = jQuery.inArray( box, exceptions_meta_arr );
	if (selected_box_id > 0 || is_exception_meta == -1){
		jQuery( document ).ready(function(){
			jQuery( 'div#form' + box ).wrap( '<form id="wrapform' + box + '" />' );
			var data = jQuery( 'form#wrapform' + box ).serializeArray( );
			jQuery( 'div#form' + box ).unwrap( 'form#wrapform' + box );
			jQuery.post(
			ajaxurl , {
			"action" : 'meta_save' ,
			"res" : res,
			"box" : box,
			"post_id" : post_id,
			"data" : data }, function( result ){
					jQuery( selector).addClass('postbox');
					jQuery( selector ).html( result );
			} );
		});
	}else{
		alert('Please select '+box);
	}  
}

meta.save_data = function( res , box , post_id , data , selector ){

    if ( post_id > 0 ){
        jQuery( document ).ready(function(){
            jQuery.post( ajaxurl , { "action" : 'meta_save' , "res" : res , "box" : box , "post_id" : post_id , "data" : data } ,
                function( result ){
                    if( selector != '.--'){
                        jQuery('#attach_'+box+'_'+res).fadeTo( 100 , 1 );
                        jQuery('#attach_'+box+'_'+res).fadeTo( 2000 , 0 );
                        jQuery.post( ajaxurl , { "action" : "search_relation" , "post_id" : data[0].value , "args" : [ res , box ] } , function( result ){ jQuery( selector).addClass('postbox'); jQuery( selector ).html( result ); });
                    }
                }
            );
        });
    }else{
        if( res == 'presentation' && box == 'speaker' ){
            alert('Please select ' + ' conferance and presentations' );
        }else{
            alert('Please select ' + res );
        }
    }
}

meta.del = function( res ,  box , post_id , index  , selector ){
	jQuery( document ).ready(function(){
		jQuery.post(
		ajaxurl , {
		"action" : 'meta_delete' ,
        "res" : res,
		"box" : box,
		"post_id" : post_id,
		"index" : index }, function( result ){
            if( result.length > 0 ){
                jQuery( selector).addClass('postbox');
            }else{
                jQuery( selector).removeClass('postbox');
            }
			jQuery( selector ).html( result );
		} );
	});
}

meta.del_data = function( res ,  box , post_id , index , post_id_result , selector ){
	jQuery( document ).ready(function(){
		jQuery.post(
		ajaxurl , {
		"action" : 'meta_delete' ,
        "res" : res,
		"box" : box,
		"post_id" : post_id,
		"index" : index }, function( result ){
            if( selector != '.--' ){
                jQuery.post( ajaxurl , { "action" : "search_relation" , "post_id" : post_id_result , "args" : [ res , box ] } ,
                    function( result ){
                        if( result.length > 0 ){
                            jQuery( selector).addClass('postbox');
                        }else{
                            jQuery( selector).removeClass('postbox');
                        }

                        jQuery( selector ).html( result );

                    }
                );
            }
		});
	});
}

meta.clear = function( selector ){
    jQuery( document ).ready(function(){
        jQuery('input[type="radion"]' + selector ).attr('checked','unchecked');
        jQuery('select' + selector ).attr('selected','unselected');
        jQuery('textarea' + selector ).val('');
        jQuery('input' + selector ).val('');
    });
}

meta.sort = function( res , box , post_id , name ){
    var data = new Array();
    jQuery( document ).ready(function(){
        jQuery( 'input.' + res + '-' + box + '-' + name ).each(function( i ){
            data[i] = { 'name' : name + '[]' , 'value' : jQuery( this ).val() };
        });

        jQuery.post( ajaxurl , { "action" : "meta_sort" , "res" : res , "box" : box , "post_id" : post_id , "data" : data } ,
                    function( result ){
                        jQuery( 'div.layout-a.meta-box.sort-' + res + '-' + box ).html( result );
                    }
                );
    });
}

meta.update = function( res , box , post_id , struct , index , selector ){
    var data = new Array();
    var k = 0;
    for (var key in struct ) {
        if ( struct.hasOwnProperty( key ) ) {
            if( ( typeof struct[ key ] ).toString() != "string" ){
                for( var i = 0; i < struct[ key ].length; i++ ){
                    data[ k ] = { 'name' : extra.name( 'div.meta-' + box + '-' + index + ' .' + struct[ key ][i] ) , 'value' : extra.val( 'div.meta-' + box + '-' + index + ' .' + struct[ key ][i] ) }
                    k++;
                }
            }else{
                data[ k ] = { 'name' : extra.name( 'div.meta-' + box + '-' + index + ' .' + struct[ key ] ) , 'value' : extra.val( 'div.meta-' + box + '-' + index + ' .' + struct[ key ] ) }
                k++;
            }
        }
    }
    jQuery( document ).ready(function(){
        jQuery.post( ajaxurl , { "action" : 'meta_update' , "res" : res , "box": box , "post_id" : post_id , "data" : data , "index" : index } , function( result ){ jQuery( 'div.layout-a.meta-box.sort-' + res + '-' + box ).html( result ); } );
    });
}

meta.edit = function( res , box , post_id , index , selector ){
    jQuery( document ).ready(function(){
        jQuery( 'div.meta-' + box + '-' + index + ' .edit-action').hide();
        jQuery( 'div.meta-' + box + '-' + index + ' .update-action').show();
        jQuery( 'div.meta-' + box + '-' + index + ' .fvisible' ).show();
        jQuery( 'div.meta-' + box + '-' + index + ' .lvisible' ).hide();
        init_color_pickers( '.generic-meta-color-picker' );
    });
}

jQuery(document).ready(function($){

    
    function templateDisplaySettings(){
    var all_boxes = "#latest_videos, #about, #contacts, #gallery, #latest_gallery, #latest_posts, #flo_contacts_metabox, #flo_repeater_metabox, #page_layout, #latest_galleries, #lala-post-images, #page_slideshowSettings, #flo_blog_list_metabox, #flo_post_metabox, .info-divider_bg_1_latest_post_types, .info-divider_bg_1_about, .info-divider_bg_1_contact";

        var page_templates_hide_boxes = { // add boxed that must be hidden for each page template
                'default':  " #latest_videos, #about, #contacts, #gallery, #latest_gallery, #latest_posts, #flo_contacts_metabox, #latest_galleries, #lala-post-images, #flo_blog_list_metabox, .info-divider_bg_1_contact, .info-divider_bg_1_about, .info-divider_bg_1_contact, .info-divider_bg_1_latest_post_types",
                'default2':  " #latest_videos, #about, #contacts, #gallery, #latest_gallery, #latest_posts," +
                " #flo_contacts_metabox, #latest_galleries, #flo_blog_list_metabox",
                'template-blog.php': " #latest_videos, #about, #contacts, #gallery, #latest_gallery," +
                " #flo_contacts_metabox, #latest_galleries, #lala-post-images, #flo_blog_list_metabox," +
                " #flo_post_metabox, #page_layout, .info-divider_bg_1_contact, .info-divider_bg_1_about ",
                'template-contact-form.php':"  #latest_videos, #about, #latest_posts, #gallery, #latest_gallery, #flo_repeater_metabox, #page_layout, #latest_galleries, #lala-post-images, #page_slideshowSettings, #flo_blog_list_metabox, .info-divider_bg_1_about, .info-divider_bg_1_latest_post_types  ",
                'template-gallery.php': "#latest_videos, #about, #contacts, #posts, #latest_gallery, #flo_contacts_metabox, #latest_posts, #flo_blog_list_metabox ",
                'template-full-width.php' : "#latest_videos, #about, #contacts, #gallery, #latest_gallery, #latest_posts, #flo_contacts_metabox, #flo_repeater_metabox, #page_layout, #latest_galleries, #lala-post-images, #page_slideshowSettings, #flo_blog_list_metabox, #flo_post_metabox, .info-divider_bg_1_contact, .info-divider_bg_1_latest_post_types",
                'template-about.php' : "#latest_videos, #latest_posts, #contacts, #gallery, #latest_gallery, #flo_contacts_metabox, #lala-post-images, #latest_galleries, #flo_blog_list_metabox, .info-divider_bg_1_contact, .info-divider_bg_1_latest_post_types ",
                'template_blog_list_view.php' : "#latest_videos, #about, #latest_posts, #gallery, #latest_gallery, #flo_repeater_metabox, #page_layout, #latest_galleries, #lala-post-images, #page_slideshowSettings, #flo_contacts_metabox, #latest_posts, #flo_posts_metabox  "
            };

        jQuery(all_boxes).show();

        jQuery.each(page_templates_hide_boxes, function( index, value ) {
            var tpl = jQuery('select#page_template').val() && jQuery('select#page_template').val().replace("templates/","");
            if(tpl == undefined){
                tpl = 'default2';
            }
            if(tpl ==  index){
                jQuery(value).hide();
            }
            
        });


    }

    jQuery('select#page_template').change(templateDisplaySettings);
    templateDisplaySettings();


    /*===========================================================================================*/
    // Mosaic
    var flo_sldshow_main_frame_meta = false;
        
        // Edit Mosaic images
        jQuery('.flo-mosaic-blocks').on( 'click', '.edit-flo-mosaic', function(event) {
            
            event.stopPropagation(); // prevent the bubble effect
            
            jQuery(this).closest('.mosaic_block').find('.flomosaic-meta-container').show(); // show the Edit modal box
            flo_sldshow_main_frame_meta = true;

        } );

        // Close the modal
        jQuery('.flo-mosaic-blocks').on( 'click', 'a.media-modal-close, .media-modal-backdrop', function(event) {

            event.stopPropagation(); // prevent the bubble effect

            //append_and_hide_meta();
            jQuery(this).closest('.flomosaic-meta-container').hide();
            flo_sldshow_main_frame_meta = false;
            
        } );

        // When user clicks on Edit Modal Box stop click propagation to not trigger the image upload window 
        jQuery('.flo-mosaic-blocks').on( 'click', '.media-modal-content', function(event) {

            event.stopPropagation(); // prevent the bubble effect
            
        } );

        

        // Close modal window on Esc key press
        jQuery(document).off('keydown').on('keydown', function(e){
            if ( 27 == e.keyCode && flo_sldshow_main_frame_meta ) {
                append_and_hide_meta(e);

            }
        });

        // Close the modal window on user action
        var append_and_hide_meta = function(e){
            jQuery('.flomosaic-meta-container').hide();
            flo_sldshow_main_frame_meta = false;
        };

        ////////////////
        // Uploading files
        var mosaic_gallery_frame;
        
       // var $product_images = $('#post_images_container ul.product_images');

		jQuery('.flo-mosaic-blocks').on( 'click', '.mosaic_block .no-flo-mosaic', function( event ) {
			jQuery(this).closest('.mosaic_block').find('.flomosaic-id').val('');
			var $myDiv = jQuery(this).closest('.mosaic_block');
			$myDiv.css('background-image', '')
		});

        jQuery('.flo-mosaic-blocks').on( 'click', '.mosaic_block .upload-flo-mosaic', function( event ) {

            var $el = jQuery(this).closest('.mosaic_block'),
            $el_id = jQuery(this).closest('.mosaic_block').attr('id');


            
            // make sure to remove 'selectedMosaicBlock' class if it exists
            jQuery('.selectedMosaicBlock').removeClass('selectedMosaicBlock');

            // set 'selectedMosaicBlock' class to the current element
            $el.addClass('selectedMosaicBlock');

            event.preventDefault();

            // If the media frame already exists, reopen it.
            if ( mosaic_gallery_frame ) {
                mosaic_gallery_frame.open();
                return;
            }

            // Create the media frame.
            mosaic_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                // Set the title of the modal.
                title: 'Add Images to Gallery',
                button: {
                    text: 'Add to gallery',
                },
                multiple: false
            });

            // When an image is selected, run a callback.
            mosaic_gallery_frame.on( 'select', function() {
                
                var selection = mosaic_gallery_frame.state().get('selection');

                selection.map( function( attachment ) {

                    attachment = attachment.toJSON();

                    if ( attachment.id ) {
                        
                        var rand_class = 'attach_'+Math.floor((Math.random() * 1000000) );

                        // add the attachment id to the hidden input
                        
                        jQuery('.selectedMosaicBlock').find('.flomosaic-id').val( attachment.id );
                        jQuery('.selectedMosaicBlock').css('background-image', 'url(' + attachment.url + ')');

                        // make sure to remove 'selectedMosaicBlock' class if it exists
                        jQuery('.selectedMosaicBlock').removeClass('selectedMosaicBlock');
                        
                    }

                } );

                
            });

            // Finally, open the modal.
            mosaic_gallery_frame.open();
        });

    /*============================================EOF Mosaic===============================================*/

});

/*
* Execute an Ajax request to get data fields for new added slideshow images
*/
function flo_get_sl_data(attachment_id,post_id, container_class){
    jQuery.ajax({
        url: ajaxurl,
        data: '&action=get_slide_data&post_id='+post_id+'&attachment_id='+attachment_id+'&container_class='+container_class,
        type: 'POST',
        cache: false,
        success: function (result) {

            jQuery('.'+container_class).append(result);
    
        }
    });
}

