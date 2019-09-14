<div data-option="share" class="option share">
	<div class="content">
		<h5 class="title">share gallery:</h5>
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
</div>
