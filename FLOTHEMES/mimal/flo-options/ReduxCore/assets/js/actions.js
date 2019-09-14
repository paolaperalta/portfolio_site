var act = new Object();
act.sh = new Object();
var triggerLoadMore = true;
var triggerVerticalLoadMore = true;

act.preview_select = function (select) {
    var $preview = jQuery(select).parents('.generic-field-preview-select').find('.preview');
    jQuery(select).children('option').each(function (index, elem) {
        if (jQuery(elem).is(':selected')) {
            $preview.addClass(jQuery(elem).val());
        } else {
            $preview.removeClass(jQuery(elem).val());
        }

    });
};

act.sh.multilevel = new Object();
act.sh.multilevel.check = function( args ){
    var show = true;
    for( var selector in args ){
        var classname = args[ selector ];
        if( show && !jQuery( selector ).first().is( ':checked' ) ){
            show = false;
        }
        if( show ){
            jQuery( classname ).show();
        }else{
            jQuery( classname ).hide();
        }
    }
}

act.sh.multilevel.mixed = function( args ){
    var show = true;
    for( var selector in args ){
        var classname = args[ selector ][ 'class' ];
        if( show ){
            if( jQuery( selector ).is( 'input' ) ){
                if( show && !jQuery( selector ).first().is( ':checked' ) ){
                    show = false;
                }
            }else if( jQuery( selector ).is( 'select' ) ){
                if( jQuery( selector ).val() == args[ selector ][ 'value' ] ){
                    show = false;
                }
            }
        }
        
        if( show ){
            jQuery( classname ).show();
        }else{
            jQuery( classname ).hide();
        }
    }
}


jQuery(function(){
    jQuery('input.generic-record-search').each(function(){
        var self = this;
        jQuery( self ).autocomplete({ 
            source: ajaxurl + '?action=search&params=' + jQuery( self ).parent().children('input.generic-params').val(), 
            minLength:2,
            
            select: function( event, ui ) {
                if(typeof(ui.item.data ) != 'undefined'){
                    console.log(ui.item.data);
                    jQuery( self ).parent().children('input.generic-value').val( ui.item.data );    
                }
                
            }
            
        });
    });
});

act.search = function( self , selector ){
    jQuery(function(){
        if( jQuery( self ).val().length > 0 ){
            if( selector != '-' ){
                jQuery( selector ).show();
            }
        }else{
            if( selector != '-' ){
                jQuery( selector ).hide();
            }
            jQuery( self ).parent().children('input.generic-value').val('');
        }
    });
} 


act.select = function( selector , args , type ){
    jQuery(document).ready(function( ){
        jQuery( 'option' , jQuery( 'select' + selector ) ).each(function(i){
            if( type == 'hs' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {

                            if( jQuery( this ).val().trim()  == key ){
                                jQuery( args[ key ] ).hide();
                            }else{
                                jQuery( args[ key ] ).show();
                            }
                        }
                    }
                }
            }

            if( type == 'sh' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {
                            if( jQuery( this ).val().trim()  == key ){
                                jQuery( args[ key ] ).show();
                            }else{
                                jQuery( args[ key ] ).hide();
                            }
                        }
                    }
                }
            }
			
			if( type == 'sh_' ){
				var show = '';
                var show_ = '';
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {

                            if( jQuery( this ).val().trim()  == key ){
                                show = args[ key ];
                            }else{
                                if( key == 'else' ){
                                    show_ = args[ key ];
                                }
                                jQuery( args[ key ] ).hide();
                            }
                        }
                    }

                    if( show == '' ){
                        jQuery( show_ ).show();
                    }else{
                        jQuery( show ).show();
                    }
                }
            }
			
			if( type == 'hs_' ){
				var hide = '';
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {

                            if( jQuery( this ).val().trim()  == key ){
                                hide = args[ key ];
                            }else{
                                jQuery( args[ key ] ).show();
                            }
                        }
                    }
					
					jQuery( hide ).hide();
                }
            }

            if( type == 's' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {
                            if( jQuery( this ).val().trim()  == key ){
                                jQuery( args[ key ] ).show();
                            }
                        }
                    }
                }
            }

            if( type == 'h' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {
                            if( jQuery( this ).val().trim()  == key ){
                                jQuery( args[ key ] ).hide();
                            }
                        }
                    }
                }
            }

            if( type == 'ns' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {
                            if( jQuery( this ).val().trim()  == key ){
                            }else{
                                jQuery( args[ key ] ).show();
                            }
                        }
                    }
                }
            }

            if( type == 'nh' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {
                            if( jQuery( this ).val().trim()  == key ){
                            }else{
                                jQuery( args[ key ] ).hide();
                            }
                        }
                    }
                }
            }
        });
    });
}
act.mcheck = function( selectors ){
    var result = true;
    jQuery(document).ready(function( ){
        for( var i = 0 ; i < selectors.length; i++ ){
            if( jQuery( selectors[ i ] ).is(':checked') ){
                if( jQuery( selectors[ i ] ).val().trim() == 'yes' ){
                    result = result && true;
                }else{
                    result = result && false;
                }
            }else{
                result = result && false;
            }
        }
    });

    if( result ){
        jQuery( '.g_l_register' ).show();
    }else{
        jQuery( '.g_l_register' ).hide();
    }
}

/*
*   selector - the elements that takes action
*   show_values - an array of values for which  elements_to_show will be shown, if the selector has any other values, then we will hive elements_to_show
*   elements_to_show = the class or id of the element that needs to be shown or hidden depending on selector's value
*/
function show_hide_options(selector, show_values, elements_to_show){
        
    if( show_values.indexOf( jQuery( selector ).val() )  > -1 ){ // if the selected value is in the array of passed values
        jQuery(elements_to_show).show();
    }else{
        jQuery(elements_to_show).hide();
    }
    
}

act.check = function( selector , args , type ){
    jQuery(document).ready(function( ){
        if( type == 'hs' ){
            if( jQuery( selector ).is(':checked') ){
                
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                            jQuery( args[ key ] ).hide();
                        }else{
                            jQuery( args[ key ] ).show();
                        }
                    }
                }
            }
        }

        if( type == 'sh' ){
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                            jQuery( args[ key ] ).show();
                        }else{
                            jQuery( args[ key ] ).hide();
                        }
                    }
                }
            }
        }

        
        if( type == 'sh_' ){
            var show = '';
            var show_ = '';
            if( jQuery( selector ).is(':checked') ){
                
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {

                        if( jQuery( this ).val().trim()  == key ){
                            show = args[ key ];
                        }else{
                            if( key == 'else' ){
                                show_ = args[ key ];
                            }
                            jQuery( args[ key ] ).hide();
                        }
                    }
                }
                if( show == '' ){
                    jQuery( show_ ).show();
                }else{
                    jQuery( show ).show();
                }
            }
        }

        if( type == 'hs_' ){
            var hide = '';
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {

                        if( jQuery( this ).val().trim()  == key ){
                            hide = args[ key ];
                        }else{
                            jQuery( args[ key ] ).show();
                        }
                    }
                }

                jQuery( hide ).hide();
            }
        }

        if( type == 's' ){
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                            jQuery( args[ key ] ).show();
                        }
                    }
                }
            }
        }

        if( type == 'h' ){
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                            jQuery( args[ key ] ).hide();
                        }
                    }
                }
            }
        }

        if( type == 'ns' ){
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                        }else{
                            jQuery( args[ key ] ).show();
                        }
                    }
                }
            }
        }

        if( type == 'nh' ){
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                        }else{
                            jQuery( args[ key ] ).hide();
                        }
                    }
                }
            }
        }
    });
}

act.show = function( selector ){
    jQuery(document).ready(function( ){
        jQuery( selector ).show();
    });
}

act.hide = function( selector ){
    jQuery(document).ready(function( ){
        jQuery( selector ).hide();
    });
}

act.link = function( selector , args , type ){
    jQuery(document).ready(function( ){
		var id = jQuery( selector ).attr('id');
        if( type == 'hs' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.trim()  == key ){
						jQuery( args[ key ] ).hide();
					}else{
						jQuery( args[ key ] ).show();
					}
				}
			}            
        }

        if( type == 'sh' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.trim()  == key ){
						jQuery( args[ key ] ).show();
					}else{
						jQuery( args[ key ] ).hide();
					}
				}
			}            
        }

        if( type == 's' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.trim()  == key ){
						jQuery( args[ key ] ).show();
					}
				}
			}
        }

        if( type == 'h' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.trim()  == key ){
						jQuery( args[ key ] ).hide();
					}
				}
			}
        }

        if( type == 'ns' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.val().trim()  == key ){
					}else{
						jQuery( args[ key ] ).show();
					}
				}
			}
        }

        if( type == 'nh' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.val().trim()  == key ){
					}else{
						jQuery( args[ key ] ).hide();
					}
				}
			}
        }
    });
}

act.extern_upload_id = function( group , name , id, upload_url ){
	if( upload_url == ""){
        tb_show_url = 'media-upload.php?post_id=0&amp;type=image&amp;TB_iframe=true';
	}else{
        tb_show_url = upload_url;
	}

    
    jQuery(document).ready(function() {
        (function(){
            var tb_show_temp = window.tb_show;
            window.tb_show = function(){
                tb_show_temp.apply(null, arguments);
                jQuery('#TB_iframeContent').load(function(){

                    if( jQuery( this ).contents().find('p.upload-html-bypass').length ){
                        jQuery( this ).contents().find('p.upload-html-bypass').remove();
                    }

                    jQuery( this ).contents().find('div#html-upload-ui').show();
                    jQuery( this ).contents().find('ul#sidemenu li#tab-type_url , ul#sidemenu li#tab-library').hide();
                    jQuery( this ).contents().find('thead tr td p input.button').hide();
                    jQuery( this ).contents().find('tr.image_alt').hide();
                    jQuery( this ).contents().find('tr.post_content').hide();
                    jQuery( this ).contents().find('tr.url').hide();
                    jQuery( this ).contents().find('tr.align').hide();
                    jQuery( this ).contents().find('tr.image-size').hide();
                    jQuery( this ).contents().find('p.savebutton.ml-submit').hide();


                    $container = jQuery( this ).contents().find('tr.submit td.savesend');
                    var sid = '';
                    $container.find('div.del-attachment').each(function(){
                        var $div = jQuery(this);
                        sid = $div.attr('id').toString();
                        if( typeof sid != "undefined" ){
                            sid = sid.replace(/del_attachment_/gi , "" );
                            jQuery(this).parent('td.savesend').html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                        }else{
                            var $submit = $container.find('input[type="submit"]');
                            sid = $submit.attr('name');
                            if( typeof sid != "undefined" ){
                                sid = sid.replace(/send\[/gi , "" );
                                sid = sid.replace(/\]/gi , "" );
                                $container.html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                            }
                        }
                    });

                    $container.find('input[type="submit"]').click(function(){
                        $my_submit = jQuery( this );
                        sid = $my_submit.attr('name');
                        if( typeof sid != "undefined" ){
                                sid = sid.replace(/send\[/gi , "" );
                                sid = sid.replace(/\]/gi , "" );
                        }else{
                            sid = 0;
                        }
                        var html = $my_submit.parent('td').parent('tr').parent('tbody').parent('table').html();
                        window.send_to_editor = function() {
                            var attach_url = jQuery('input[name="attachments['+sid+'][url]"]',html).val();
                            jQuery( 'input#' + group + '_' + name + id ).val(  attach_url  );
                            jQuery( 'input#' + group + '_' + name + '_id' + id ).val( sid );

                            if( id.length > 0 ){
                                jQuery( 'img#attach_' + group + '_' + name  + id).attr( "src" ,  attach_url  );
                            }

                            tb_remove();
                        }
                    });
                });

            }})()

        formfield = jQuery( 'input#' + group + '_' + name + id ).attr('name');
        tb_show('', tb_show_url);
        return false;
    });
}

act.upload_id = function( group , name , id, upload_url ){

    // Uploading files
    var product_gallery_frame;

       
    // If the media frame already exists, reopen it.
    if ( product_gallery_frame ) {
        product_gallery_frame.open();
        return;
    }

    // Create the media frame.
    product_gallery_frame = wp.media.frames.downloadable_file = wp.media({
        // Set the title of the modal.
        title: 'Add attachment',
        button: {
            text: 'Add this attachment',
        },
        multiple: false
    });

    // When an image is selected, run a callback.
    product_gallery_frame.on( 'select', function() {
        
        var selection = product_gallery_frame.state().get('selection');

        selection.map( function( attachment ) {

            attachment = attachment.toJSON();

            if ( attachment.id ) {
                
                jQuery( 'input#' + group + '_' + name + id ).val(  attachment.url  );
                jQuery( 'input#' + group + '_' + name + '_id' + id ).val( attachment.id );

                if( id !== undefined ){
                    jQuery( 'img#attach_' + group + '_' + name  + id).attr( "src" ,  attachment.url  );
                }
                
            }

        } );

        
    });

    // Finally, open the modal.
    product_gallery_frame.open();

	
}


act.upload = function( selector ){

    // Uploading files
    var product_gallery_frame;

       
    // If the media frame already exists, reopen it.
    if ( product_gallery_frame ) {
        product_gallery_frame.open();
        return;
    }

    // Create the media frame.
    product_gallery_frame = wp.media.frames.downloadable_file = wp.media({
        // Set the title of the modal.
        title: 'Add attachment',
        button: {
            text: 'Add this attachment',
        },
        multiple: false
    });

    // When an image is selected, run a callback.
    product_gallery_frame.on( 'select', function() {
        
        var selection = product_gallery_frame.state().get('selection');

        selection.map( function( attachment ) {

            attachment = attachment.toJSON();

            if ( attachment.id ) {
                //jQuery('.cosmo-team-attached-image').attr('src',attachment.url);
                jQuery(selector).val(attachment.url); // add the image URL in the text input
                jQuery(selector+'_id').val(attachment.id); // add the Attachment id the hidden input
                
            }

        } );

        
    });

    // Finally, open the modal.
    product_gallery_frame.open();
                       
    
}

act.post_relation = function( post_id , meta_label , field_id ){
    jQuery( document ).ready(function(){
        jQuery.post( ajaxurl , {"action" : 'post_relation' , "post_id" : post_id , "meta_label": meta_label , "field_id" : field_id} , function( result ){jQuery( 'span#' + field_id  ).html( result );jQuery('div.' + field_id ).show();} );
    });
}

act.preview = function( family , size, size_mobile , weight, style, letter_space, letter_space_mobile, text , selector  ){

    jQuery( document ).ready(function(){

        jQuery.post( ajaxurl , {"action" : "text_preview" ,
                "family" : family ,
                "size" : size,
                "size_mobile" : size_mobile ,
                "weight" : weight ,
                "style" : style,
                "text" : text,
                "letter_space" : letter_space,
                "letter_space_mobile" : letter_space_mobile
            } , function( result ) {
                jQuery( selector ).html( result );
            }
        );
    });

}

act.is_array = function (obj) {
    if (obj.constructor.toString().indexOf("Array") == -1)
        return false;
    else
        return true;
}



act.radio_icon = function( group , topic , index ){
	jQuery(function(){
        jQuery('.generic-field-' + group + ' .generic-input-radio-icon input.' + group + '-' + topic + '-' + index ).removeAttr("checked");
        jQuery('.generic-field-' + group + ' img.pattern-texture.' + group + '-' + topic ).removeClass( 'selected' );

        jQuery('.generic-field-' + group + ' .generic-input-radio-icon.' + index + ' input.' + group + '-' + topic + '-' + index ).attr('checked' , 'checked');
        jQuery('.generic-field-' + group + ' .generic-input-radio-icon.' + index + ' input.' + group + '-' + topic + '-' + index ).click();
        jQuery('.generic-field-' + group + ' img.pattern-texture.' + group + '-' + topic + '-' + index ).addClass( 'selected' );
    });
}

act.accept_digits = function( objtextbox ){
    var exp = /[^\d]/g;
    objtextbox.value = objtextbox.value.replace(exp,'');
}


function init_color_pickers( selector ){
    /* color piker */
    jQuery('.generic-field input.settings-color-field').each(function() {
        jQuery('.settings-color-field').wpColorPicker();
    });
}

jQuery(document).ready(function() {
	/* ready actions */
    /* flickr settings */
    jQuery('.flickr_badge_image').each(function(index){
		var x = index % 3;
		if(index !=1 && x == 2){
			jQuery(this).addClass('last');
		}
	});

	/* digit input */
	jQuery('input[type="text"].digit').bind('keyup', function(){
		act.accept_digits( this );
	});
  
    /* color piker */
    jQuery('.generic-field input.settings-color-field').each(function() {
        jQuery('.settings-color-field').wpColorPicker();
    });

        
    /*code for front end submittion form*/
    jQuery('.front_post_input').focus(function() {
    	  jQuery(this).removeClass('invalid');
    	  
    	  var obj_id = jQuery(this).attr('id');
    	  jQuery('#'+obj_id+'_info').show();
    });
    
});

function use_url(){
	jQuery('#image_type').val('url_img'); /*URL image will be used*/	
	jQuery('#image_type_upload').hide();
	jQuery('#image_type_url').show();
}


jQuery(document).ready(function(){

    if(jQuery('#form_post_image .image_gallery').val() == 'gallery') {
        jQuery('#label_gallery_upload').show();
        jQuery('#label_image_upload').hide();
    }
    else if(jQuery('#form_post_image .image_gallery').val() == 'image') {
        jQuery('#label_gallery_upload').hide();
        jQuery('#label_image_upload').show();
    }
    jQuery('li.image a').click(function(){
        jQuery('#form_post_image .image_gallery').val('image');
        jQuery('#label_gallery_upload').hide();
        jQuery('#label_image_upload').show();
    });

    jQuery('li.gallery a').click(function(){
        jQuery('#form_post_image .image_gallery').val('gallery');
        jQuery('#label_image_upload').hide();
        jQuery('#label_gallery_upload').show();
    });


    // radio button icons change action
    
    

    //jQuery("input.radio-icon-input").click(function () {  
    jQuery("input[type='radio']").click(function () {    
         
        if(jQuery(this).is(":checked")){ // if current radio button is cheched
            //console.log(456);
            //if there elements that must be shown when this value is selected
            if(jQuery(this).data('show')){
                jQuery(jQuery(this).data('show')).show();
                jQuery(jQuery(this).data('show')).find("input[type='radio']:checked").click(); // izvrashenie for double level dependency for radio buttons
            }

            //if there elements that must be hiden when this value is selected
            if(jQuery(this).data('hide')){
                jQuery(jQuery(this).data('hide')).hide();
            }
            
        }

    });

	jQuery('#footer-global').find('.widget-top').parent('div').each(function(){
		var ids = jQuery(this).attr('id');
		if (ids.toLowerCase().indexOf("widget_cosmo_flo_copyright") >= 0){
			var close_button = '<a class="widget-control-close" href="#close">Close</a>';
			jQuery('.widget-control-actions',this).find('.alignleft').empty();
			jQuery('.widget-control-actions',this).find('.alignleft').append(close_button);
		}
	})



});

jQuery(document).ready(function($){
    $('input#_cmb2_minimal_feat_post').css('width','88%');
    'use strict';
    var l10n = {
        'error' : 'sss',
        'find' : 'sss'
    };
function search_posts(obj){
    var self = obj;
    jQuery( self ).autocomplete({

        source: ajaxurl + '?action=search&params=' + jQuery( self ).parent().children('input.generic-params').val(),
        minLength:2,

        select: function( event, ui ) {
            if(typeof(ui.item.data ) != 'undefined'){
                jQuery( self ).parent().children('input.generic-value').val( ui.item.data );
            }

        }

    });
}
    jQuery('.cmb-type-post-search-text .cmb-td input[type="text"]' ).after( '<div title="'+ l10n.find +'" style="color: #999;margin: .3em 0 0 2px; cursor: pointer;" class="dashicons dashicons-search"></div><div class="for_response"></div>');
    jQuery('.cmb-type-post-search-text .cmb-td input[type="text"]').on('keypress', function(){


        search_posts($(this));

    })
    search_posts($( '.cmb-type-post-search-text .cmb-td input[type="text"]'));


	jQuery('.cmb-type-gallery-search-text .cmb-td input[type="text"]' ).after( '<div title="'+ l10n.find +'" style="color: #999;margin: .3em 0 0 2px; cursor: pointer;" class="dashicons dashicons-search"></div><div class="for_response"></div>');
	jQuery('.cmb-type-gallery-search-text .cmb-td input[type="text"]').on('keypress', function(){


		search_posts($(this));

	})
	search_posts($( '.cmb-type-gallery-search-text .cmb-td input[type="text"]'));
});
