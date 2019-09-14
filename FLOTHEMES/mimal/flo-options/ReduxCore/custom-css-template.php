<?php 
	global $flo_options; 

	

	if(isset($flo_options['flo_minimal-list_view-height'])){
		$small_list_view_height = $flo_options['flo_minimal-list_view-height'];
	}else{
		$small_list_view_height = '430';
	}

	if(isset($flo_options['flo_minimal-list_view-width'])){
		$small_list_view_width = $flo_options['flo_minimal-list_view-width'];

		
		$margin_bottom = ($small_list_view_height - 20);
		$margin_bottom = '-'.$margin_bottom . 'px';

		if($small_list_view_width < 800){
			$post_header_min_height_adjustment = 200;
		//	$margin_bottom = '-60%';
		}else if( 800 <= $small_list_view_width && $small_list_view_width < 900){
			$post_header_min_height_adjustment = 180;
		//	$margin_bottom = '-62%';
		}else if( 900 <= $small_list_view_width ){
			$post_header_min_height_adjustment = 190;
		//	$margin_bottom = '-65%';
		}
		
	}

?>
<style class="flo-custom-css">
	<?php if (isset($flo_options['flo_minimal-max_logo_mobile_width']) && $flo_options['flo_minimal-max_logo_mobile_width'] != ''):  ?>
		@media only screen and (max-width: 768px){
			.nav-mobile.mobile .logo img{
				max-width: <?php echo $flo_options['flo_minimal-max_logo_mobile_width']; ?>px;
			}
		}
	<?php endif; ?>
	<?php if ($flo_options['flo-style_sheet'] == ''): ?>
		@media only screen and (min-width: 769px) {
		    header.main-header ul.nav-menu > .menu-item > .header_main-nav_sub-menu:after {
		        background-color: <?php echo $flo_options['flo_minimal-sk-regular-minor-background']; ?>;
		    }
		}
	<?php endif; ?>


	<?php if ($flo_options['flo-style_sheet'] == 'style-blue.css'): ?>
		@media only screen and (min-width: 769px) {
		    header.main-header ul.nav-menu > .menu-item > .header_main-nav_sub-menu:after {
		        background-color: <?php echo $flo_options['flo_minimal-sk-blue-primary-color']; ?>;
		    }
		}

		@media only screen and (max-width: 768px) {
		    .page.blog .all-posts.with-layout .post.style-blue,
		    .hero-image.full-width figure:before {
		        border-color: <?php echo $flo_options['flo_minimal-sk-blue-secondary-color']; ?>;
		    }
		    .page.blog .all-posts.with-layout .post.style-blue:after {
		        background-color: <?php echo $flo_options['flo_minimal-sk-blue-primary-color']; ?>;
		    }
		    .page.blog .all-posts.with-layout figure,
		    .page.blog .all-posts.with-layout .post.style-blue.with-image h2.title:after,
		    .page.blog .all-posts.with-layout .post.style-blue.with-image h2.title:before {
		        background-color: <?php echo $flo_options['flo_minimal-sk-blue-secondary-color']; ?>;
		    }
		}
	<?php elseif ($flo_options['flo-style_sheet'] == 'style-red.css'): ?>
		@media only screen and (min-width: 769px){
		  header.main-header ul.nav-menu > .menu-item > .header_main-nav_sub-menu a:hover {
		    background-color: <?php echo $flo_options['flo_minimal-sk-red-primary-color']; ?>;
		  }
		}

		@media (min-width: 768px){
		  .page.blog .all-posts.full-width .post.style-red a.open-post:hover {
		    background-color: <?php echo $flo_options['flo_minimal-sk-red-primary-color']; ?>;
		    border-color: <?php echo $flo_options['flo_minimal-sk-red-primary-color']; ?>;
		  }

		  .page.blog .all-posts.full-width .post.style-red.with-image .date h6:after {
		    color: <?php echo $flo_options['flo_minimal-sk-red-primary-color']; ?>;
		  }

		  .page.blog .all-posts.full-width .post.style-red.with-image a.open-post:hover {
		    border-color: <?php echo $flo_options['flo_minimal-sk-red-primary-color']; ?>;
		  }

		  .page.blog .all-posts.with-layout .post.style-red.with-image figure {
		    background-color: <?php echo $flo_options['flo_minimal-sk-red-secondary-color']; ?>;
		  }

		  .page.portfolio-page li.image .figure-hover {
		    background-color: <?php echo $flo_options['flo_minimal-sk-red-primary-color']; ?>;
		  }
		}
	<?php endif; ?>

	/*list view content width: custom width*/
	<?php if (isset($small_list_view_width) && is_numeric($small_list_view_width) ):  ?>
		
		.page.blog .all-posts.with-layout .layout{
		    max-width: <?php echo $small_list_view_width ?>px;
		}
		@media only screen and (min-width: 1025px){
		    .page.blog .all-posts.with-layout .post.style-basic.with-image .post-header{
		        min-height: <?php echo ($small_list_view_height + $post_header_min_height_adjustment) ?>px;
		    }

		    .page.blog .all-posts.with-layout .post.style-basic.with-image .post-header{
			    margin-bottom: <?php echo $margin_bottom ?>;
			}
		}

		/*if the screen width is smaller that the list view width we need to recalculate the hover div position. so we'll compute the proportions first */
		@media only screen and (min-width: 1025px) and (max-width: <?php echo $small_list_view_width ?>px){
			.page.blog .all-posts.with-layout .post.style-basic.with-image .post-header{
		        min-height:  calc( 100vw * <?php echo $small_list_view_height ?> / <?php echo $small_list_view_width ?> + <?php echo $post_header_min_height_adjustment ?>px ); 
		    }

		    .page.blog .all-posts.with-layout .post.style-basic.with-image .post-header{
		    	margin-bottom: calc( -1 * ( 100vw * <?php echo $small_list_view_height ?> / <?php echo $small_list_view_width ?> - 50px) );
		    }
		}
	<?php endif; ?>


	<?php echo $flo_options['flo_minimal-custom_css']; ?>

</style>