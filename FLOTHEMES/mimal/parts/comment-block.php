<?php
global $flo_options;
$page_comments = '';
$en_comments = $flo_options['flo_minimal-comments']['Enabled'];
if(is_page() && isset($flo_options['flo_minimal-page_comments'])):$page_comments = $flo_options['flo_minimal-page_comments'];endif;
if(is_single()):$page_comments = '1';endif;

?>
<?php if ( (comments_open() || get_comments_number() ) && $page_comments == '1' && count($en_comments) > 1) : ?>
    <?php foreach($en_comments as $key=>$comment): ?>
        <?php if($key == 'wp'): ?>
            <div class="comments">
                <h6 class="title text-center <?php echo get_comments_number() > 0 ? 'com-coll' : '' ?>"><?php comments_number(); ?></h6>
                <div class="comment-list">
                    <?php echo comments_template( '', true ); ?>
                </div>
            </div>
        <?php endif ?>
                    
        <?php if($key == 'facebook'): ?>
            <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-numposts="5" data-width="100%"></div>
        <?php endif; ?>             
    <?php endforeach;?>
<?php endif;?>
