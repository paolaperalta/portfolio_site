jQuery( document ).ready(function(){
    jQuery('.home-page-creation').change(function() {

        if(jQuery(this).val() == 'manually'){
            jQuery('.home-pages-list').show();
        }else{
            jQuery('.home-pages-list').hide();
        }
    });

    jQuery('.blog-page-creation').change(function() {

        if(jQuery(this).val() == 'manually'){
            jQuery('.blog-pages-list').show();
        }else{
            jQuery('.blog-pages-list').hide();
        }
    });

    jQuery('.menu-creation').change(function() {

        if(jQuery(this).val() == 'manually'){
            jQuery('.main-menu-select').show();
        }else{
            jQuery('.main-menu-select').hide();
        }
    });


    /*
     * действие при нажатии на кнопку загрузки изображения
     * вы также можете привязать это действие к клику по самому изображению
     */
    jQuery('.quick_upload_image_button').click(function () {

        jQuery('.fav-ico.response-box').hide();

        var send_attachment_bkp = wp.media.editor.send.attachment,
            button = jQuery(this),
            img_type = jQuery(this).data('img_type');

        wp.media.editor.send.attachment = function (props, attachment) {
            console.log(attachment.mime);
            wp.media.editor.send.attachment = send_attachment_bkp;

            if(img_type == 'fav_ico'){
                if( attachment.mime == 'image/x-icon'){
                    jQuery(button).parent().prev().attr('src', attachment.url);
                    flo_quick_fav_ico_update(attachment); // call the function that will save the options
                }else{
                    jQuery('.fav-ico.response-box').show();
                }

            }else{
                jQuery(button).parent().prev().attr('src', attachment.url);
                //jQuery(button).prev().val(attachment.id);

                flo_quick_logo_update(attachment); // call the function that will save the oprions
            }

        }
        wp.media.editor.open(button);
        return false;
    });

    /*
     * удаляем значение произвольного поля
     * если быть точным, то мы просто удаляем value у input type="hidden"
     */
    jQuery('.quick_remove_image_button').click(function () {
        var r = confirm("Are you sure?");
        if (r == true) {
            var src = jQuery(this).parent().prev().attr('data-src');
            jQuery(this).parent().prev().attr('src', src);
            jQuery(this).prev().prev().val('');
        }
        return false;
    });

    // style kits radio buttons on change action
    jQuery('input[type=radio][name=flo_style_kit]').change(function() {
        console.log(this.value);

        // call the function that makes the Ajax request to update the Style Kit options
        flo_quick_update_style_kit(this.value); 

    });

    jQuery('.flo_pretty_permalinks').change(function() {

        if(jQuery(this).attr('checked') == 'checked' ){

            // call the function that makes the Ajax request to update the Permilink structure
            flo_quick_update_pemalins();
        }

    });
    
});


function flo_quick_fav_ico_update(attachment){
    //console.log(attachment);
    var attachment_id = attachment.id,
        attachment_url = attachment.url;


    jQuery('.wizard-favico-response').hide();

    jQuery.ajax({
        url: ajaxurl,
        data: '&action=quick_set_fav_ico&attachment_id='+attachment_id+'&attachment_url='+attachment_url,
        type: 'POST',
        dataType: "json",
        cache: false,
        success: function (json) {

            jQuery('.wizard-favico-response').show();

        },
        error: function (xhr) {
//            jQuery('.wizard-home-page-spinner').hide();
            console.log(xhr);
        }
    });
}

function flo_quick_logo_update(attachment){

    var attachment_id = attachment.id,
        attachment_url = attachment.url,
        attachment_thumbnail,
        attachment_width = attachment.sizes.full.width,
        attachment_height = attachment.sizes.full.height;

        if(attachment.sizes.thumbnail && attachment.sizes.thumbnail.url){
            attachment_thumbnail = attachment.sizes.thumbnail.url;
        }else{
            // that happens when the uploaded logo is smaller than the thembnail size
            attachment_thumbnail = attachment.sizes.full.url;
        }


    jQuery('.wizard-logo-response').hide();

    jQuery.ajax({
        url: ajaxurl,
        data: '&action=quick_set_logo&attachment_id='+attachment_id+'&attachment_url='+attachment_url+'&attachment_thumbnail='+attachment_thumbnail+'&attachment_width='+attachment_width+'&attachment_height='+attachment_height,
        type: 'POST',
        dataType: "json",
        cache: false,
        success: function (json) {

            jQuery('.wizard-logo-response').show();

        },
        error: function (xhr) {
//            jQuery('.wizard-home-page-spinner').hide();
            console.log(xhr);
        }
    });
}

function floSetHomePage(){
    var home_option = jQuery('.home-page-creation option:selected').val(),
        manually_home_option = jQuery('.home-pages-list option:selected').val();

    jQuery('.wizard-home-page-response').html('');

    if( jQuery.trim(home_option).length && home_option == 'manually' && manually_home_option == '' ){

        alert('Select please a static page from the dropd down that will be used as the Home page.');

    }else if( jQuery.trim(home_option).length ){

        jQuery('.wizard-home-page-spinner').show();
        jQuery('.wizard-home-page-spinner').css({
            'visibility':'visible'
        });


        jQuery.ajax({
            url: ajaxurl,
            data: '&action=set_home_page&home_option='+home_option+'&manually_home_option='+manually_home_option,
            type: 'POST',
            dataType: "json",
            cache: false,
            success: function (json) {

                jQuery('.wizard-home-page-response').html(json.message);
                jQuery('.wizard-home-page-response').show();
                jQuery('.wizard-home-page-spinner').hide();

            },
            error: function (xhr) {
                jQuery('.wizard-home-page-spinner').hide();
                console.log(xhr);
            }
        });
    }else{
        alert('Select please a Home page option from the select above.');
    }
}

function floSetBlogPage(){
    var blog_option = jQuery('.blog-page-creation option:selected').val(),
        manually_blog_option = jQuery('.blog-pages-list option:selected').val();

    jQuery('.wizard-blog-page-response').html('');

    if( jQuery.trim(blog_option).length && blog_option == 'manually' && manually_blog_option == '' ){

        alert('Select please a static page from the dropd down that will be used as the Blog page.');

    }else if( jQuery.trim(blog_option).length ){

        jQuery('.wizard-blog-page-spinner').show();
        jQuery('.wizard-blog-page-spinner').css({
            'visibility':'visible'
        });


        jQuery.ajax({
            url: ajaxurl,
            data: '&action=set_blog_page&blog_option='+blog_option+'&manually_blog_option='+manually_blog_option,
            type: 'POST',
            dataType: "json",
            cache: false,
            success: function (json) {

                jQuery('.wizard-blog-page-response').html(json.message);
                jQuery('.wizard-blog-page-response').show();
                jQuery('.wizard-blog-page-spinner').hide();

            },
            error: function (xhr) {
                jQuery('.wizard-blog-page-spinner').hide();
                console.log(xhr);
            }
        });
    }else{
        alert('Select please a Blog page option from the select above.');
    }
}

function floSetMainMenu(){
    var menu_option = jQuery('.menu-creation option:selected').val(),
        manually_menu_option = jQuery('.main-menu-select option:selected').val();

    jQuery('.wizard-menu-response').html('');
    jQuery('.wizard-menu-response').hide();

    if( jQuery.trim(menu_option).length && menu_option == 'manually' && manually_menu_option == '' ){

        alert('Select please a menu from the dropd down that will be used as the Main menu.');

    }else if( jQuery.trim(menu_option).length ){

        jQuery('.wizard-menu-spinner').show();
        jQuery('.wizard-menu-spinner').css({
            'visibility':'visible'
        });


        jQuery.ajax({
            url: ajaxurl,
            data: '&action=set_main_menu&menu_option='+menu_option+'&manually_menu_option='+manually_menu_option,
            type: 'POST',
            dataType: "json",
            cache: false,
            success: function (json) {

                jQuery('.wizard-menu-response').html(json.message);
                jQuery('.wizard-menu-response').show();
                jQuery('.wizard-menu-spinner').hide();

            },
            error: function (xhr) {
                jQuery('.wizard-menu-spinner').hide();
                console.log(xhr);
            }
        });
    }else{
        alert('Select please the method used to create the Main menu from the drop down.');
    }
}


function flo_style_kit_radio_icon(style_kit, style_kit_class){
    jQuery('.stylekit-type' ).removeClass( 'selected' );

    jQuery('.'+style_kit_class+' .radio-icon-input').click();
    console.log(jQuery('.'+style_kit_class+' .radio-icon-input').length);
//console.log(jQuery('.stylekit-type.'+style_kit_class).length);
    jQuery('.stylekit-type.'+style_kit_class).addClass('selected');
}

function flo_quick_update_style_kit(style_kit){
    jQuery('.wizard-style-kit-response').hide();

    jQuery.ajax({
        url: ajaxurl,
        data: '&action=quick_update_style_kit&style_kit='+style_kit,
        type: 'POST',
        dataType: "json",
        cache: false,
        success: function (json) {

            console.log(json.message);
            jQuery('.wizard-style-kit-response').show();

        },
        error: function (xhr) {
            console.log(xhr);
        }
    });
}

function flo_quick_update_pemalins(){

    jQuery('.wizard-permalinks-response').hide();

    jQuery.ajax({
        url: ajaxurl,
        data: '&action=quick_update_pemalins',
        type: 'POST',
        dataType: "json",
        cache: false,
        success: function (json) {

            console.log(json.message);
            jQuery('.wizard-permalinks-response').show();

        },
        error: function (xhr) {
            console.log(xhr);
        }
    });
}