jQuery( document ).ready(function() {
var gen_table = '';

    gen_table = jQuery('.inline_tr_spacing').parents('.form-table');
    jQuery('.inline_tr_spacing').each(function(){
        jQuery(this).parents('tr').addClass('inline_tr');
    })

    jQuery(".inline_tr").first().addClass('first_spacing_tr').find('th').addClass('first_spacing');
    jQuery(".inline_tr").last().addClass('last_spacing_tr');




    var i = 1;
    jQuery(".inline_tr").each(function(){

        jQuery(this).wrap('<div class="wrap_inner wrap_'+i+'" style="float: left"></div>');
        if(i == 1){
            jQuery(this).find('fieldset').prepend('<span class="add-on"><i class="el-icon-arrow-up icon-large"></i></span>');

        }else if(i == 2){
            jQuery(this).find('fieldset').prepend('<span class="add-on"><i class="el-icon-arrow-right icon-large"></i></span>');
        }else if(i == 3){
            jQuery(this).find('fieldset').prepend('<span class="add-on"><i class="el-icon-arrow-down icon-large"></i></span>');
        }else if(i == 4){
            jQuery(this).find('fieldset').prepend('<span class="add-on"><i class="el-icon-arrow-left icon-large"></i></span>');
            i = 0;
        }
        i = i+1;
    })

    jQuery('.wrap_1 , .wrap_2 , .wrap_3 , .wrap_4').wrapAll('<table class="cust_table"></table>');
    jQuery('.wrap_4').after('<div style="clear: both"></div>');
    jQuery('.wrap_2 , .wrap_3 , .wrap_4').find('th').remove();
    var table = '';
    table = jQuery('.cust_table');
    jQuery('.cust_table').remove();
    gen_table.after(table);
})