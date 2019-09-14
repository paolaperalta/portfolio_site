<?php
/* social sharing  */
global $flo_options;
if (isset($flo_options) && isset($flo_options['flo_minimal-social_sharing']) && $flo_options['flo_minimal-social_sharing'] == '1'):?>
    <div class="share">
        <h6 class="title"><?php echo __('Share post', 'flotheme'); ?></h6>
        <ul class="social-links">
            <li>
                <a href="http://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink($post->ID); ?>"
                   target="_blank" class="min-icon-soc-facebook"></a>
            </li>
            <li>
                <a href="http://pinterest.com/pin/create/link/?url=<?php echo get_permalink($post->ID); ?>&amp;title=<?php echo urlencode($post->post_title); ?>" target="_blank" class="min-icon-soc-pinterest"></a>
            </li>
            <li>
                <a href="http://www.tumblr.com/share/link?url=<?php echo get_permalink($post->ID); ?>&name=<?php echo urlencode($post->post_title); ?>&description=<?php echo urlencode($post->post_excerpt); ?>"
                   target="_blank" class="min-icon-soc-tumblr"></a>
            </li>
            <li>
                <a href="http://twitter.com/home?status=<?php echo urlencode($post->post_title); ?>+<?php echo get_permalink($post->ID); ?>"
                   target="_blank" class="min-icon-soc-twitter"></a>
            </li>
        </ul>
    </div>
<?php endif; ?>