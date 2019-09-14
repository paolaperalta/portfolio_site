<?php
global $flo_options,$social_title;
if(isset($flo_options['flo_minimal-social']) && $flo_options['flo_minimal-social'] != ''):
?>
<div class="block">
    <h5 class="title"><?php if(isset($social_title) && $social_title != ''):echo $social_title; else : echo _('Social media','flotheme');endif;?></h5>

    <div class="content">
        <ul class="social-links">
            <?php
            echo flo_get_social_icons(flo_get_available_social_services(), false);
            ?>
        </ul>
    </div>
</div>

<?php endif;?>
