<?php
    /**
     * The template used for displaying page content in page.php
     *
     * @package options_sample
     */
    global $flo_options, $social_title,$show_header,$title_color;
    $post_id = $post->ID;

    $meta = meta::get_meta($post_id, 'settings');
    $header_page = meta::get_meta($post_id, 'flo_post_header_type');
    $show_header = $meta['page_title'];
    $flo_title_color = meta::get_meta($post->ID, 'flo_posts_title_color');
    if(isset($flo_title_color) && $flo_title_color && $flo_title_color != ''){
        $title_color = 'style="color: '.$flo_title_color.'"';
    }else{
        $title_color = '';
    }
?>

<?php
    $email = get_post_meta($post_id, 'flo_contacts_email', true);
    $thx_msg = get_post_meta($post_id, 'flo_contacts_thx_msg', true);
    if($thx_msg == ''){
        $thx_msg = 'The email was sent!';
    }
    $shortcode = get_post_meta($post_id, 'flo_contacts_custom_shortcode', true);
    $title = get_post_meta($post_id, 'flo_contacts_form_title', true);
    $description = get_post_meta($post_id, 'flo_contacts_form_description', true);
    $layout = get_post_meta($post_id, 'flo_contacts_layout', true);
    $social_title = get_post_meta($post_id, 'flo_contacts_social_links_title', true);
    $contact_me_title = get_post_meta($post_id, 'flo_contacts_contact_me_title', true);
    $contact_me_phone = get_post_meta($post_id, 'flo_contacts_contact_me_phone', true);
    $contact_me_enable_social_links = get_post_meta($post_id, 'flo_contacts_enable_social_links', true);
    $use_user_email = get_post_meta( $post_id, 'flo_contacts_use_user_email', true );

    if ($layout == 'full_width') {
        $content_class = 'medium-8 medium-offset-2 a columns ';
        $sidebar_class = 'medium-8 medium-offset-2 columns end text-center';
    } else {
        $content_class = 'columns medium-8 medium-push-4 ';
        $sidebar_class = 'columns medium-4 medium-pull-8 sidebar_left';
    }
?>
<?php
if(isset($meta) && isset($meta['include_before_page_content_sidebar']) &&
    $meta['include_before_page_content_sidebar'] == 'yes'):
    dynamic_sidebar($meta['sidebar_before']);
endif;
?>
<?php
    if (has_post_thumbnail($post->ID) && !post_password_required()) {
        $feat_enabled = true;
        $src = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full'); //get img URL
        $img_url = aq_resize($src, 9999, '810', false, true, true); //crop img

        if (isset($img_url) && $img_url != '') {
            $page_header_type =  $header_page  ? $header_page : $flo_options['flo_minimal-page_header_layout'];

            if ($page_header_type == "1") {
                get_template_part('/parts/page-headers/page-header-full-image');
            } elseif ($page_header_type == '2') {
                get_template_part('/parts/page-headers/page-header-full-small-image-center');
            } elseif ($page_header_type == '3') {
                get_template_part('/parts/page-headers/page-header-only-small-image');
            }
        }
    } else {
        $img_url = '';
    }

    $show_page_header = $show_header == 'yes' && ($header_page == '3' || ( !has_post_thumbnail($post->ID) && !post_password_required() ));
?>

<?php ?>

<div class="page-content with-sidebar">
    <div class="layout row">

        <?php if ($show_page_header):?>
            <div class="page-header" <?php echo $title_color;?>>
                <h1 class="entry-title title" > <?php the_title(); ?> </h1>

                <?php if (flo_subtitle($post->ID)): ?>
                    <h4 class="sub-title"> <?php echo flo_subtitle($post->ID);?> </h4>                
                <?php endif ?>
            </div>
        <?php endif; ?>


        <div class="<?php echo $content_class; ?> content <?php echo $layout; ?>">
        
            <?php if (get_the_content()): ?>
                <div class="article-content">
                    <?php the_content();?>
                </div>
            <?php endif ?>

            <?php if ($layout == "full_width"): ?>
                <aside class="widget">
                    <?php if (isset($contact_me_title) && $contact_me_title != ''): ?>
                        <h5 class="widget-title"><?php echo $contact_me_title; ?></h5>
                        <div class="content">
                            <p>
                                <?php if (isset($contact_me_phone) && $contact_me_phone != ''):echo $contact_me_phone; endif; ?>
                                <br>
                                <?php if (isset($email) && $email != ''):echo $email; endif; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </aside>
            <?php endif ?>
            <?php if(isset($shortcode) && $shortcode != ''):?>
                <?php echo do_shortcode($shortcode);?>
            <?php else:?>
                <form id="flo-contact-form" method="post">
                    <div class="field-group">
                        <input type="text" name="cosmo-name" placeholder="<?php _e('Name', 'flotheme'); ?>"
                               aria-required="true"></div>
                    <div class="field-group">
                        <input type="email" name="cosmo-email" placeholder="<?php _e('Email', 'flotheme'); ?>"
                               aria-required="true"></div>
                    <div class="field-group">
                        <input type="text" name="cosmo-phone" placeholder="<?php _e('Phone', 'flotheme'); ?>"></div>
                    <div class="field-group">
                    <textarea name="cosmo-message" cols="30" rows="10" id="cosmo-message"
                              placeholder="<?php _e('Message', 'flotheme'); ?>" aria-required="true"></textarea>
                    </div>
                    <input type="hidden" name="cosmo-contact-email" value="<?php echo $email; ?>">
                    <input type="hidden" name="use_user_email" value="<?php echo $use_user_email; ?>">
                    <input type="hidden" name="thx_msg" value="<?php echo urlencode($thx_msg); ?>">

                    <div class="field-group text-center">
                        <input type="button" value="<?php _e('Submit form', 'flotheme'); ?>" id="cosmo-send-msg"
                               name="btn_submit"
                               onclick="floSendMail( '#flo-contact-form' , 'div#cosmo_contact_response' );"></div>
                    <div id="cosmo_contact_response"></div>
                </form>
            <?php endif; ?>

        </div>

        <?php
            ob_start();
            ob_clean();
        ?>
            <?php if ($layout != "full_width"): ?>
                <aside class="widget">
                    <?php if (isset($contact_me_title) && $contact_me_title != ''): ?>
                        <h5 class="widget-title"><?php echo $contact_me_title; ?></h5>
                        <div class="content">
                            <p>
                                <?php if (isset($contact_me_phone) && $contact_me_phone != ''):echo $contact_me_phone; endif; ?>
                                <br>
                                <?php if (isset($email) && $email != ''):echo $email; endif; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </aside>
            <?php endif ?>

            <?php if (isset($contact_me_enable_social_links) && $contact_me_enable_social_links == '1'): ?>
                <?php echo get_template_part('/parts/social_links'); ?>
            <?php endif; ?>
        <?php
            $contact_sidebar_content = ob_get_clean();
        ?>
        <?php if (strlen(trim($contact_sidebar_content))): ?>
            <div class="side-bar <?php echo $sidebar_class; ?> <?php echo $layout; ?>">
                <div class="page-side-bar post-sidebar ">
                    <?php echo $contact_sidebar_content; ?>
                </div>
            </div>
        <?php endif ?>
        
    </div>
</div>
