/*global redux_change, wp, redux*/

(function( $ ) {
    "use strict";
    redux.field_objects = redux.field_objects || {};
    redux.field_objects.social_networks = redux.field_objects.social_networks || {};

    $( document ).ready(
        function() {
            $('.redux-social_networks-list').find('img').each(function(){
                if($(this).attr('src').length <=0){
                    $(this).hide();
                }
            })
            $('.remove_image_r').on('click',function(e){
                e.preventDefault();
                $(this).parents('ul').find('.slide_icon_r').val('');
                $(this).parents('ul').find('.redux-social_networks-image1').attr('src','');
                $(this).parents('ul').find('.redux-social_networks-image1').hide();
            });
            $('.remove_image_c').on('click',function(e){
                e.preventDefault();
                $(this).parents('ul').find('.slide_icon_c').val('');
                $(this).parents('ul').find('.redux-social_networks-image').attr('src','');
                $(this).parents('ul').find('.redux-social_networks-image').hide();
            });
            //redux.field_objects.slides.init();
        }
    );

    redux.field_objects.social_networks.init = function( selector ) {

        if ( !selector ) {
            selector = $( document ).find( ".redux-group-tab:visible" ).find( '.redux-container-social_networks:visible' );
        }

        $( selector ).each(
            function() {
                var el = $( this );

                redux.field_objects.media.init(el);

                var parent = el;
                if ( !el.hasClass( 'redux-field-container' ) ) {
                    parent = el.parents( '.redux-field-container:first' );
                }
                if ( parent.is( ":hidden" ) ) { // Skip hidden fields
                    return;
                }

                if ( parent.hasClass( 'redux-container-social_networks' ) ) {
                    parent.addClass( 'redux-field-init' );
                }

                if ( parent.hasClass( 'redux-field-init' ) ) {
                    parent.removeClass( 'redux-field-init' );
                } else {
                    return;
                }

                el.find( '.redux-social_networks-remove' ).live(
                    'click', function() {
                        redux_change( $( this ) );

                        $( this ).parent().siblings().find( 'input[type="text"]' ).val( '' );
                        $( this ).parent().siblings().find( 'textarea' ).val( '' );
                        $( this ).parent().siblings().find( 'input[type="hidden"]' ).val( '' );

                        var slideCount = $( this ).parents( '.redux-container-social_networks:first' ).find( '.redux-social_networks-accordion-group' ).length;

                        if ( slideCount > 1 ) {
                            $( this ).parents( '.redux-social_networks-accordion-group:first' ).slideUp(
                                'medium', function() {
                                    $( this ).remove();
                                }
                            );
                        } else {
                            var content_new_title = $( this ).parent( '.redux-social_networks-accordion' ).data( 'new-content-title' );

                            $( this ).parents( '.redux-social_networks-accordion-group:first' ).find( '.remove-image' ).click();
                            $( this ).parents( '.redux-container-social_networks:first' ).find( '.redux-social_networks-accordion-group:last' ).find( '.redux-social_networks-header' ).text( content_new_title );
                        }
                    }
                );

                //el.find( '.redux-slides-add' ).click(
                el.find( '.redux-social_networks-add' ).off('click').click(
                    function() {
                        var newSlide = $( this ).prev().find( '.redux-social_networks-accordion-group:last' ).clone( true );

                        var slideCount = $( newSlide ).find( '.slide-title' ).attr( "name" ).match( /[0-9]+(?!.*[0-9])/ );
                        var slideCount1 = slideCount * 1 + 1;

                        $( newSlide ).find( 'input[type="text"], input[type="hidden"], textarea' ).each(
                            function() {

                                $( this ).attr(
                                    "name", jQuery( this ).attr( "name" ).replace( /[0-9]+(?!.*[0-9])/, slideCount1 )
                                ).attr( "id", $( this ).attr( "id" ).replace( /[0-9]+(?!.*[0-9])/, slideCount1 ) );
                                $( this ).val( '' );
                                if ( $( this ).hasClass( 'slide-sort' ) ) {
                                    $( this ).val( slideCount1 );
                                }
                            }
                        );

                        var content_new_title = $( this ).prev().data( 'new-content-title' );



                        $( newSlide ).find( 'input[type="button"].c' ).attr( 'onclick', $( newSlide ).find( 'input[type="button"].c' ).attr( 'onclick').replace( /\d+/g, slideCount1) );
                        $( newSlide ).find( 'input[type="button"].r' ).attr( 'onclick', $( newSlide ).find( 'input[type="button"].r' ).attr( 'onclick').replace( /\d+/g, slideCount1) );
                        //$( newSlide ).find( 'input[type="button"]' ).attr( 'onclick', $( newSlide ).find( 'input[type="button"]' ).attr( 'onclick').replace( /[0-9]+(?!.*[0-9])/, slideCount1) );
                        $( newSlide ).find( '.redux-social_networks-image' ).attr( 'src', '' );
                        $( newSlide ).find( '.redux-social_networks-image1' ).attr( 'src', '' );
                        $( newSlide ).find( '.redux-social_networks-image' ).attr( 'id', $( newSlide ).find( '.redux-social_networks-image' ).attr( 'id').replace( /[0-9]+(?!.*[0-9])/, slideCount1) );
                        $( newSlide ).find( '.redux-social_networks-image1' ).attr( 'id', $( newSlide ).find( '.redux-social_networks-image1' ).attr( 'id').replace( /[0-9]+(?!.*[0-9])/, slideCount1) );
                        $( newSlide ).find( 'h3' ).text( '' ).append( '<span class="redux-social_networks-header">' + content_new_title + '</span><span class="ui-accordion-header-icon ui-icon ui-icon-plus"></span>' );
                        $( this ).prev().append( newSlide );
                    }
                );



                el.find( '.slide-title' ).keyup(
                    function( event ) {
                        var newTitle = event.target.value;
                        $( this ).parents().eq( 3 ).find( '.redux-social_networks-header' ).text( newTitle );
                    }
                );


                el.find( ".redux-social_networks-accordion" )
                    .accordion(
                    {
                        header: "> div > fieldset > h3",
                        collapsible: true,
                        active: false,
                        heightStyle: "content",
                        icons: {
                            "header": "ui-icon-plus",
                            "activeHeader": "ui-icon-minus"
                        }
                    }
                )
                    .sortable(
                    {
                        axis: "y",
                        handle: "h3",
                        connectWith: ".redux-social_networks-accordion",
                        start: function( e, ui ) {
                            ui.placeholder.height( ui.item.height() );
                            ui.placeholder.width( ui.item.width() );
                        },
                        placeholder: "ui-state-highlight",
                        stop: function( event, ui ) {
                            // IE doesn't register the blur when sorting
                            // so trigger focusout handlers to remove .ui-state-focus
                            ui.item.children( "h3" ).triggerHandler( "focusout" );
                            var inputs = $( 'input.slide-sort' );
                            inputs.each(
                                function( idx ) {
                                    $( this ).val( idx );
                                }
                            );
                        }

           }
                );
            }
        );
    };
})( jQuery );
var act = new Object();

act.upload = function( selector ,img){

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
                var image_el = jQuery(selector).parents('div'); // add the image URL in the text input
                image_el.find('img#'+img).prop('src',attachment.url).show();
                jQuery(selector+'_id').val(attachment.id); // add the Attachment id the hidden input

            }

        } );


    });

    // Finally, open the modal.
    product_gallery_frame.open();


}

