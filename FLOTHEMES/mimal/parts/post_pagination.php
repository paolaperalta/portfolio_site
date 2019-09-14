<?php
$next_post = get_next_post();
$prev_post = get_previous_post();

if(isset($next_post) && $next_post != ''){
	$next_thumb = get_the_post_thumbnail($next_post->ID);
}else{
	$next_thumb = null;
}
if(isset($next_thumb)){
	$img_url1_next = wp_get_attachment_url(get_post_thumbnail_id($next_post->ID), 'full');
	if($img_url1_next){
		$next_img_url = aq_resize($img_url1_next, '230', '144', true, true,true); //crop img
	}else{
		$next_img_url = null;
	}
}else{
	$next_img_url = null;
}
if(isset($prev_post->ID)) {
	$prev_thumb = get_the_post_thumbnail($prev_post->ID);
}else{
	$prev_thumb = '';
}
if(isset($prev_thumb) && isset($prev_post->ID)){
	$img_url1_prev = wp_get_attachment_url(get_post_thumbnail_id($prev_post->ID), 'full');
	$prev_img_url = aq_resize($img_url1_prev, '230', '144', true, true,true); //crop img
}else{
	$prev_img_url = null;
}
?>
<div class="post-nav">
	<ul>
		<?php if(isset($prev_post) && $prev_post != '' && $prev_post != null):?>
			<li class="prev-post"><a href="<?php echo get_the_permalink($prev_post->ID);?>" class="name">Prev. post</a>
				<div class="content">
					<figure>
						<a href="<?php echo get_the_permalink($prev_post->ID);?>"> <?php if($prev_img_url):?><img src="<?php echo $prev_img_url;?>" alt=""><?php endif;?></a>
					</figure>
					<h6 class="date"><?php echo get_the_date('',$prev_post->ID);?></h6>
					<h4 class="title"><?php echo $prev_post->post_title;?></h4> </div>
			</li>
		<?php endif;?>
		<?php if(isset($next_post) && $next_post != '' && $next_post != null):?>
			<li class="next-post"><a href="<?php echo get_the_permalink($next_post->ID);?>" class="name">Next post</a>
				<div class="content">
					<figure>
						<a href="<?php echo get_the_permalink($next_post->ID);?>"> <?php if($next_img_url):?><img src="<?php echo $next_img_url;?>" alt=""><?php endif;?></a>
					</figure>
					<h6 class="date"><?php echo get_the_date('',$next_post->ID);?></h6>
					<h4 class="title"><?php echo $next_post->post_title;?></h4> </div>
			</li>
		<?php endif;?>
	</ul>
</div>
