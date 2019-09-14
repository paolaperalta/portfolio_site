<?php
class layout{
	static $size = array(
			'large' => 'small-12 medium-12 columns',
			'medium' => 'small-12 medium-9 columns'
	);
	static function side( $side = 'right_sidebar' , $post_id = 0 , $template = null ){
		global $cat_array,$flo_options,$sidebar_sharing, $meta_repeater_show;
		$words_width = array( 1 => '1', 2 => '2', 3 => '3', 4 => '4',  5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10', 11 => '11', 12 => '12' );

			$sidebar_width = 4;

		$sidebar_width_class = $words_width[$sidebar_width];
		$content_width_class = $words_width[12-$sidebar_width];
		$position = false;
		if( strlen( $side ) ){
			if( $post_id > 0 ){
				$layout = meta::get_meta( $post_id , 'layout' );
				if( isset( $layout['type'] ) && !empty( $layout['type'] ) && $layout['type'] !='full_width'){
					$result = $layout['type'];
				}else{
					$result = null;
				}
			}else{
				if( strlen( $template ) ){
					$result = $flo_options['flo-'.$template];
				}else{
					$result = $side.'_sidebar';
				}
			}
			if( $side == 'left' ){
				$pull = 12-$sidebar_width_class;
				$classes = 'sidebar_'.$side.' small-12 medium-'.$sidebar_width_class.' medium-pull-'.$pull.' columns top-separator';

			}else{
				$classes = 'sidebar_'.$side.' small-12 medium-'.$sidebar_width_class.' columns';
			}
			if( $result == $side.'_sidebar' ){
				if (is_single() || is_page() || is_404()) {
					$column_class = ''.$sidebar_width_class.' columns';
				}else{
					$column_class = '';
				}
				echo '<div id="content-sidebar" class="content-sidebar widget-area ' . $classes . ' columns page-side-bar post-sidebar" role="complementary">';
				echo '<div class="inner">';
				if($post_id > 0){
					$meta_repeater = meta::get_meta( $post_id , 'flo_repeater_metabox' );
				}
				if($post_id > 0){
					$meta_repeater = meta::get_meta( $post_id , 'flo_repeater_demo' );
					if(isset($meta_repeater) && $meta_repeater != ''){
						$meta_repeater_show = true;
						foreach($meta_repeater as $field_repeater){
							echo '<div class="widget-block">
                                          <label class="widget-title">'.$field_repeater['title'].'</label>';
							echo '<article class="content">'.$field_repeater['description'].'</article>';

							echo "</div>";
						}
					}else{
						$meta_repeater_show = false;
					}
					$en_comments = $flo_options['flo_minimal-comments']['Enabled'];
				}

				echo'<section id="widgets" class="widgets">';
				if( isset( $layout['sidebar'] ) && !empty( $layout['sidebar'] ) ){

					if(dynamic_sidebar( $layout['sidebar'] ) ){

					}
				}else{
					$layout = $flo_options['flo-'.$template.'-sidebar'];
					//                            $layout = options::get_value( 'layout' , $template . '_sidebar' );
					if( !empty( $layout ) ){
						if(dynamic_sidebar( $layout ) ){

						}
					}else{
						get_sidebar( );
					}

				}

				echo '</section></div>';
				echo'</div>';

				$position = true;
			}elseif($result == $side.'_sidebar' ){
				if (is_single() || is_page() || is_404()) {
					$column_class = ''.$sidebar_width_class.' columns';
				}else{
					$column_class = '';
				}

				echo '<div id="content-sidebar" class="content-sidebar widget-area ' . $classes . ' columns page-side-bar post-sidebar" role="complementary">';
				echo '<div class="inner">';
				if($post_id > 0){
					$meta_repeater = meta::get_meta( $post_id , 'flo_repeater_demo' );
					if(isset($meta_repeater) && $meta_repeater != ''){
						$meta_repeater_show = true;
						foreach($meta_repeater as $field_repeater){
							echo '<div class="widget-block">
                                          <label class="widget-title">'.$field_repeater['title'].'</label>';
							echo '<article class="content">'.$field_repeater['description'].'</article>';
							echo "</div>";
						}
					}else{
						$meta_repeater_show = false;
					}
					$en_comments = $flo_options['flo_minimal-comments']['Enabled'];
				}
				echo '<section id="widgets" class="widgets">';

				$layout = $flo_options['flo-'.$template.'-sidebar'];
				//                            $layout = options::get_value( 'layout' , $template . '_sidebar' );
				if( !empty( $layout ) ){
					if(dynamic_sidebar( $layout ) ){

					}
				}else{
					get_sidebar( );
				}
				echo '</section></div>';
				echo'</div>';
				$position = true;
			}
		}

		return $position;
	}

	static function length( $post_id = 0 , $template = null ){
		global $flo_options;
		$layout = meta::get_meta( $post_id , 'layout' );
		if( isset( $layout['type'] ) && !empty( $layout['type'] ) && $layout['type'] == 'full_width' ) {
			$length = self::$size['large'];
		}else{
			if( strlen( $template ) ){
				if( isset( $layout['type'] ) && !empty( $layout['type'] ) && $layout['type'] != 'full_width' ) {
					$result = $layout['type'].'_sidebar';
				}else{
					if(isset($flo_options['flo-'.$template])){
						$result = $flo_options['flo-'.$template];
					}else {
						$result = 'full_width';
					}
				}

				$words_width = array( 1 => '1', 2 => '2', 3 => '3', 4 => '4',  5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10', 11 => '11', 12 => '12' );

				$sidebar_width = 4;


				$content_width_class = $words_width[12-$sidebar_width];
				$push = 12-$content_width_class;

				if(isset($result) &&  $result != 'full_width'){
					if($result == 'left_sidebar'){
						self::$size['medium'] = $result.' medium-'.$content_width_class.' medium-push-'.$push.' columns ';

					}elseif($result == 'right_sidebar'){
						self::$size['medium'] = $result.' medium-'.$content_width_class.' columns ';
					}
				}
				if(isset($layout) &&  isset($layout['type']) && $layout['type'] != 'full_width'){
					if($layout['type'] == 'left_sidebar'){
						self::$size['medium'] = $layout['type'].' medium-'.$content_width_class.' medium-push-'.$push.' columns ';

					}elseif($layout['type'] == 'right_sidebar'){

						self::$size['medium'] = $layout['type'].' medium-'.$content_width_class.' columns ';
					}
				}

				if( $result == 'full_width' ){
					if( isset( $layout['type'] ) && $layout['type'] != 'full_width' ){
						$length = self::$size['medium'];
					}else{
						$length = self::$size['large'];
					}
				}else{
					$length = self::$size['medium'];
				}
			}
		}
		return $length;
	}

}
?>
