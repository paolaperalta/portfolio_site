/**
 * Created by seriived on 06.02.15.
 */
jQuery(window).load(function(){
    // init fanctbox

    jQuery("a[data-fancybox-group^='prettyPhoto']").click(function(e){
        e.preventDefault();
    });
    jQuery(".img-lightbox-hint").fancybox({

        helpers: {
            overlay: {
                locked: true
            },
        },

        closeClick : true ,

        margin :  jQuery('#header .header-containe-wrapper').height() + 120,



    });
});

