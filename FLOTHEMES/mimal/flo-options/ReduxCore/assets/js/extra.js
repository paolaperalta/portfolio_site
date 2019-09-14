var extra = new Object();
extra.add = function( group , struct, required_fields  ){
    
    jQuery('input[type="text"]').removeClass('invalid');

    var allow_add_row = false;

    if(required_fields && typeof(required_fields) != 'undefined'  ){
        
        
        jQuery( required_fields ).each(function( index ) {
            if(jQuery(this).val() == '' ){ // if the required field is empty
                jQuery(this).addClass('invalid');        
                allow_add_row = false;
                return false; // if at least one required field is empty, we stop and show user to fill in the value for the required field
            }else{
                allow_add_row = true;
            }
        });
        
        
    }else{
        allow_add_row = true;
    }

    if(allow_add_row){ // add row only if we do not have any empty required fields
        var data = new Array();
        var k = 0;
        for (var key in struct ) {
            if ( struct.hasOwnProperty( key ) ) {
                if( ( typeof struct[ key ] ).toString() != "string" ){
                    for( var i = 0; i < struct[ key ].length; i++ ){
                        data[ k ] = { 'name' : extra.name( key + '#' + struct[ key ][i] ) , 'value' : extra.val( key + '#' + struct[ key ][i] ) }
                        k++;
                    }
                }else{
                    data[ k ] = { 'name' : extra.name( key + '#' + struct[ key ] ) , 'value' : extra.val( key + '#' + struct[ key ] ) }
                    k++;
                }
            }
        }

        jQuery( document ).ready(function(){
            jQuery.post( ajaxurl , { "action" : 'extra_add' , "group" : group , "data" : data } , function( result ){ extra.clear( struct ); jQuery( '#container_' + group  ).html( result ); } );
        });    
    }
    
    
        
}

extra.del = function( group , index ){
    if(  confirm('You sure you want to delete this item from group ?') ){
        jQuery( document ).ready(function(){
            jQuery.post( ajaxurl , { "action" : 'extra_del' , "group" : group , "index" : index } , function( result ){ jQuery( '#container_' + group  ).html( result ); } );
        });
    }
}

extra.update = function( group , index , struct ){
    var data = new Array();
    var k = 0;
    for (var key in struct ) {
        if ( struct.hasOwnProperty( key ) ) {
            if( ( typeof struct[ key ] ).toString() != "string" ){
                for( var i = 0; i < struct[ key ].length; i++ ){
                    data[ k ] = { 'name' : extra.name( 'div#multiple_record_' + group + '_' + index + ' ' + key + '.' + struct[ key ][i] ) , 'value' : extra.val( 'div#multiple_record_' + group + '_' + index + ' ' + key + '.' + struct[ key ][i] ) }
                    k++;
                }
            }else{
                data[ k ] = { 'name' : extra.name( 'div#multiple_record_' + group + '_' + index + ' ' + key + '.' + struct[ key ] ) , 'value' : extra.val( 'div#multiple_record_' + group + '_' + index + ' ' + key + '.' + struct[ key ] ) }
                k++;
            }
        }
    }

    jQuery( document ).ready(function(){
        jQuery.post( ajaxurl , { "action" : 'extra_update' , "group" : group , "index": index , "data" : data } , function( result ){ jQuery( '#container_' + group  ).html( result ); } );
    });
}

extra.edite = function( group , index ){
    jQuery( document ).ready(function(){
        jQuery( 'div#multiple_record_' + group + '_' + index + ' .edit-action').hide();
        jQuery( 'div#multiple_record_' + group + '_' + index + ' .update-action').show();
        jQuery( 'div#multiple_record_' + group + '_' + index + ' .fvisible' ).show();
        jQuery( 'div#multiple_record_' + group + '_' + index + ' .lvisible' ).hide();
    });
}

extra.clear = function( struct ){
	jQuery( document ).ready(function(){
		for (var key in struct ) {
			if ( struct.hasOwnProperty( key ) ) {
				if( ( typeof struct[ key ] ).toString() != "string" ){
					for( var i = 0; i < struct[ key ].length; i++ ){
						jQuery( key + '#' + struct[ key ][i] ).val('');
					}
				}else{
					jQuery( key + '#' + struct[ key ] ).val('');
				}
			}
		}
	});
}
extra.name = function( selector ){
	var name = '';
	jQuery( document ).ready(function(){
		name = jQuery( selector ).attr( 'name' );
	});
	return name;
}
extra.val = function( selector ){
    var result = '';
    jQuery(document).ready(function(){
        if( jQuery( selector ).attr('type') == 'checkbox' || jQuery( selector ).attr('type') == 'radio' ){
            if( jQuery( selector ).is(':checked') ){
                result = jQuery( selector ).val();
            }else{
                result = '';
            }
        }else{
            result = jQuery( selector ).val();
        }
    });
    
    return result;
}


extra.sort = function( group , name ){
    var data = new Array();
    jQuery( document ).ready(function(){
        jQuery( 'input.' + group + '.index' ).each(function( i ){
            data[i] = { 'name' : name , 'value' : jQuery(this).val() };
        });

        jQuery.post( ajaxurl , { "action" : "extra_sort" , "group" : group , "data" : data } ,
            function( result ){
                jQuery( '#container_' + group ).html( result );
            }
        );
    });
}

function init_ui_slider(obj_selector){
    jQuery(obj_selector).each(function (i) {
        //jQuery(this).slider({
        //     range: "min",
        //     min: jQuery(this).data('min'),
        //     max: jQuery(this).data('max'),
        //     value: jQuery(this).data('val') ,
        //     slide: function (event, ui) {
        //        jQuery(this).next('span.slider_val').text(ui.value);
        //        jQuery(this).prev('.slider_value').val(ui.value);
        //     },
        //
        //     change: function (event, ui) {
        //
        //     }
        //});
    });
}

//function doCosmoImportDummy(){
//	var flo_folder = jQuery('#opt-import_one_click-select:selected');
//	console.log(flo_folder );
//    jQuery.ajax({
//        url: ajaxurl,
//        data: '&action=importDummyData&importDummyNonce='+MyAjax.importDummyNonce,
//        type: 'POST',
//        dataType: "json",
//        cache: false,
//        success: function (json) {
//
//
//        },
//        error: function (xhr) {
//
//
//        }
//    });
//}

jQuery(document).ready(function(){


    jQuery( ".reset-cosmo-options" ).click(function() {
        if(confirm('Click OK to reset. All settings will be lost and replaced with default settings!')){

            jQuery('.options-reset-msg-div').show();
            
            jQuery.ajax({
                url: ajaxurl,
                data: '&action=resetOptions',
                type: 'POST',
                /*dataType: "json",*/
                cache: false,
                success: function (json) { 
                    
                    location.reload();    
                },
                error: function (xhr) {
                    console.log(xhr);

                    
                }
            });
        }
    });
	jQuery('.copy_text').click(function(){
		var text = jQuery(this).text();
		var $this = jQuery(this);
		var $input = jQuery('<input style="width: 220px" readonly="readonly" type=text>');
		$input.prop('value', text);
		$input.insertAfter(jQuery(this));
		$input.focus();
		$input.select();
		$this.hide();
		$input.focusout(function(){
			$this.show();
			$input.remove();
		});
	});
  
    
});

jQuery(window).load(function(){
    // init fanctbox

    jQuery("a[data-fancybox-group^='prettyPhoto']").click(function(e){

        e.preventDefault();
    });
    if(jQuery('.video-lightbox-hint').length > 0){
        var video_url,a;
        jQuery('.video-lightbox-hint').each(function(){
            video_url = jQuery(this).attr('href');
            video_url = video_url.replace("https://youtu.be/", "https://www.youtube.com/embed/");
            video_url = video_url.replace("https://www.youtube.com/watch?v=", "https://www.youtube.com/embed/");

            if(video_url.indexOf("youtube")>-1){
                if(video_url.indexOf("autoplay") == -1) {
                    jQuery(this).attr('href', video_url + '?autoplay=1');
                }
            }
            else{
                if(video_url.indexOf("doc_iframe") == -1) {
                    a = jQuery('<a>', {href: video_url});
                    video_url = video_url.replace(a.prop('hash'), '')
                    jQuery(this).attr('href', video_url + '?doc_iframe=1/' + a.prop('hash'));
                }
            }
        });
        a = jQuery('<a>', {href: jQuery(this).attr('href')});
        jQuery(".video-lightbox-hint").fancybox({
            type: "iframe",
            openEffect : 'fade',
            closeEffect : 'fade',
            height: '90%',
            width: '70%',
            helpers: {
                overlay: {
                    locked: false
                }
            }

        });
        jQuery(".img-lightbox-hint").fancybox({

            closeClick : true ,
            //margin : 60,
        });
    }else{
        jQuery(".img-lightbox-hint").fancybox({
            helpers: {
                overlay: {
                    locked: false
                }
            },
            closeClick : true ,
            margin :  jQuery('#header .header-containe-wrapper').height() + 60,
        });
    }

});

function importDummyData(){

    var folder_name = jQuery('#flo_minimal-import_one_click-select option:selected').val();
    if( jQuery.trim(folder_name).length ){
        if(confirm('Are you sure you want to import Dummy data? This will change your current content and settings.')){
            jQuery('.import-demo-spinner').show();
            jQuery('.import-demo-spinner').css({
                'visibility':'visible'
            });

            jQuery('.import-response').show();


            jQuery.ajax({
                url: ajaxurl,
                data: '&action=importDummyData&folder='+folder_name,
                type: 'POST',
                dataType: "json",
                cache: false,
                success: function (json) {

                    jQuery('.import-response').html(json.message);
                    jQuery('.import-demo-spinner').hide();

                },
                error: function (xhr) {
                    jQuery('.import-demo-spinner').hide();
                }
            });
        }
    }else{
        alert('Select please the demo version you want to import.');
    }


}



// funtion used to trigger the Import of the demo settings
function importDemoSettings(){
    var folder_name = jQuery('#opt-quick_import_options-select option:selected').val();

    if( jQuery.trim(folder_name).length ){
        if(confirm('Are you sure you want to import the Demo settings? This will change your current settings.')){
            jQuery('.import-demo-spinner').show();
            jQuery('.import-demo-spinner').css({
                'visibility':'visible'
            });

            jQuery('.import-response').show();


            jQuery.ajax({
                url: ajaxurl,
                data: '&action=importDemoSettings&folder='+folder_name,
                type: 'POST',
                dataType: "json",
                cache: false,
                success: function (json) {

                    jQuery('.import-response').html(json.message);
                    jQuery('.import-demo-spinner').hide();

                    // reload the page
                    
                    window.onbeforeunload = null; // disble the promt alert that requires the aprovement before the page reload
                    
                    location.reload(); // reload the page to make sure the imported options are not overwriten when the save changes is clicked

                },
                error: function (xhr) {
                    jQuery('.import-demo-spinner').hide();
                }
            });
        }
    }else{
        alert('Select please the demo settings you want to import.');
    }
}
