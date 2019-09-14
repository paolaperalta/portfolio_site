/**
 * Created by seriived on 9/19/14.
 */


//used in customizer
function change_select(obj){
	var str = "";
	jQuery("option:selected", obj).each(function () {
		str = jQuery(this).val();
		if (str === 'post') {
			jQuery('.to_change ').show();
			jQuery('.lbl_to_change').show();
			jQuery('.to_change ').find('div.galleries').addClass('cats_hd').removeClass('cats_sh');
			jQuery('.to_change ').find('div.pages').addClass('cats_hd').removeClass('cats_sh');
			jQuery('.to_change ').find('div.posts').removeClass('cats_hd').addClass('cats_sh');
		} else if (str === 'gallery') {
			jQuery('.to_change ').show();
			jQuery('.lbl_to_change').show();
			jQuery('.to_change ').find('div.pages').addClass('cats_hd').removeClass('cats_sh');
			jQuery('.to_change ').find('div.galleries').removeClass('cats_hd').addClass('cats_sh');
			jQuery('.to_change ').find('div.posts').removeClass('cats_sh').addClass('cats_hd');
		} else if (str === 'page') {
			jQuery('span.ttl').text("Select pages: ");
			jQuery('.to_change ').show();
			jQuery('.lbl_to_change').show();
			jQuery('.to_change ').find('div.posts').removeClass('cats_sh').addClass('cats_hd');
			jQuery('.to_change ').find('div.galleries').removeClass('cats_sh').addClass('cats_hd');
			jQuery('.to_change ').find('div.pages').addClass('cats_sh');
		}
	});
}




jQuery(function($){
	$(document).ready(function() {



		jQuery("#publish").on('click', function(e){
			if(jQuery('#page_template option:selected').val() == 'templates/template-contact-form.php'){
				if(jQuery('#flo_contacts_email').val() == ''){
					jQuery('#flo_contacts_email').css('border','1px solid red');
					jQuery('#flo_contacts_email').parents('div.cmb-td').append('<span style="color:red"> This field' +
						' required for contact' +
						' form.</span>');

					jQuery('html, body').animate({
						scrollTop: jQuery("#flo_contacts_contact_me_title").offset().top
					}, 1000);
					jQuery('#flo_contacts_email').focus();
					e.preventDefault();
				}
			}
		})
		//customizerConfig - comming from flo_main.php . This is a array of media fields from redux
		if(customizerConfig){
			jQuery.each(customizerConfig, function(index, value){
				if(value && value.length > 0){
					var img = jQuery('#customize-control-flo_options-'+index).find('img');
					// if image isset we change to value from redux
					if(img.length > 0){
						jQuery(img).attr('src',value);
					}else{
						// if image not isset we create html from redux data
						var new_img = '<div class="attachment-media-view attachment-media-view-image portrait"><div class="thumbnail thumbnail-image"><img class="attachment-thumb" src="'+value+'"></div></div>';
						jQuery('#customize-control-flo_options-'+index).find('div.container').html(new_img);
					}
				}
			});
		}
		var elements;
		if(typeof imageSelectElements != 'undefined'){
			elements = imageSelectElements;
		}else{
			elements = [];
		}

		$.each(elements, function(i, val){
			$("#"+val+' label').each(function(){

				var aObj = $(this).first().contents().filter(function() {
					return this.nodeType == 3;
				}),
				a = aObj.text();
				var img = '<img style="max-width: 60px;" src="'+ $.trim(a)+'"/>';
				$(this).append(img);
				aObj.remove();
				$(this).find('input').next().remove();
				$(this).find('input').hide();
			});

			$("#"+val+' input:checked ').parents('label').find('img').css({
				'border': '2px solid grey'
			});

			$("#"+val+' img ').on('click', function () {
				$("#"+val+' img').each(function () {
					$(this).css({
						'border': 'none'
					})
				});
				$(this).css({
					'border': '2px solid grey'
				})
			})
		});

		// in the customizer
		// for the elements with the class 'bottom-separator' we find it's parent and add the class 'li-bottom-separator'
		// this class is used to add border between elements
		if(jQuery('#customize-theme-controls .bottom-separator').length){
			jQuery('#customize-theme-controls .bottom-separator').parents('li.customize-control').addClass('li-bottom-separator');
		}

		// used in Flo Blocks widget to delete the added posts
		jQuery('.multi-search-result').on('click', '.ntdelbutton', function(){
			jQuery(this).parents('span').remove();
		});
        var selected_option = $('.generic-slideshow_select option:selected');
        if (selected_option.val() == 0) {
            $('.flo-slideshow-options').hide();
        } else {
            $('.flo-slideshow-options').show();
        }
        $('.generic-slideshow_type').on('change', function () {
            selected_option = $('.generic-slideshow_select option:selected');
            if (selected_option.val() == '0') {
                $('.flo-slideshow-options').hide();
            } else {
                $('.flo-slideshow-options').show();
            }
        })


        /**
         * Search option 
        **/

        $('.redux_field_th').each(function(){
            var filter = $(this).attr('data-filter');
            if (typeof filter != 'undefined' && filter.length > 2 ) $(this).parents('tr').attr('data-wrap-filter', filter);
        });

        // Reset filter button
        $('#redux-sticky .clear-filter').click(function(){

            $(this).parents('#redux-sticky').find('#redux-option-filter').val('').trigger('input');
        });

        var redux_wrapper = $('#redux-form-wrapper');

        $('#redux-option-filter').on('input', function() {

            // ESC key will reset the form
            $(this).keyup(function(e) {
               if (e.keyCode == 27) $(this).val('').trigger('input');
            });

            var val = $(this).val().trim();

            if ( val.length < 2 ) {
                redux_wrapper.find('tr').removeClass('.in-front');
                redux_wrapper.removeClass('search');
            } else {

                redux_wrapper.addClass('search');
                redux_wrapper.find('tr').removeClass('in-front');

                var words = val.split(' '), selector = '';
                
                // Creating multiple selectors for the same element
                words.forEach(function(word) {   
                    if (word == ' ') return;                 
                    selector +='[data-wrap-filter*='+word+']';
                });

                redux_wrapper.find(selector).addClass('in-front');

                setTimeout(function(){
                        $.redux.initFields();
                }, 2000);
            }

        });
		/**/

	});

	/*
	 * действие при нажатии на кнопку загрузки изображения
	 * вы также можете привязать это действие к клику по самому изображению
	 */
	$('.upload_image_button').click(function(){
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = $(this);
		wp.media.editor.send.attachment = function(props, attachment) {
			$(button).parent().prev().attr('src', attachment.url);
			$(button).prev().val(attachment.id);
			wp.media.editor.send.attachment = send_attachment_bkp;
		}
		wp.media.editor.open(button);
		return false;
	});
	/*
	 * удаляем значение произвольного поля
	 * если быть точным, то мы просто удаляем value у input type="hidden"
	 */
	$('.remove_image_button').click(function(){
		var r = confirm("Are you sure?");
		if (r == true) {
			var src = $(this).parent().prev().attr('data-src');
			$(this).parent().prev().attr('src', src);
			$(this).prev().prev().val('');
		}
		return false;
	});

    var selected_option = $('.generic-slideshow_select option:selected');
    if(selected_option.val() == '0'){
        $('.flo-slideshow-options').hide();
    }else{
        $('.flo-slideshow-options').show();
    }
    $('.generic-slideshow_select').on('change',function(){
        selected_option = $('.generic-slideshow_select option:selected');
        if(selected_option.val() == '0'){
            $('.flo-slideshow-options').hide();
        }else{
            $('.flo-slideshow-options').show();
        }
    })

});



function search_posts_widget(obj){
	var self = obj;
	
	jQuery( self ).autocomplete({

		source: ajaxurl + '?action=search&params=' + jQuery( self ).parents('div').find('input.generic-params').val(),
		minLength:2,

		select: function( event, ui ) {
			if(typeof(ui.item.data ) != 'undefined'){
				jQuery( self ).parents('div').find('input.feat_post_id').val( ui.item.data).trigger('change');
			}

		}

	});
}

function search_multiple_posts(obj,hidden_input_name){
	var the_new_post, self = obj;

	jQuery( self ).autocomplete({

		source: ajaxurl + '?action=search&params=' + jQuery( self ).data('post_type'),
		minLength:2,

		select: function( event, ui ) {
			
			if(typeof(ui.item.data ) != 'undefined'){
				the_new_post = '<span><input type="hidden" name="'+hidden_input_name+'[]" value="'+ui.item.data+'"><a id="post_tag-check-num-0" class="ntdelbutton" tabindex="0">X</a>&nbsp;'+ui.item.label+'</span>';
				
				jQuery( self ).val('');
				jQuery( self ).parents('div').find('.multi-search-result').append( the_new_post ).trigger('change');
				
			}

		}

	});
}

