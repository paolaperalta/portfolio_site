<?php

class widget_flo_popular extends WP_Widget
{

	function __construct()
	{
		$widget_ops = array('classname' => 'flo_popular', 'description' => __('Flo Block Posts', 'flotheme'));
		parent::__construct('widget_cosmo_flo_popular', _TN_ . ' : ' . __('Flo Featured Posts', 'flotheme'), $widget_ops);
	}

	function widget($args, $instance)
	{
		/* prints the widget*/
		extract($args, EXTR_SKIP);


		if (isset($instance['post_type'])) {
			$post_type = $instance['post_type'];
		} else {
			$post_type = '';
		}
		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = 'The title';
		}
		if (isset($instance['number_posts'])) {
			$number_posts = $instance['number_posts'];
		} else {
			$number_posts = 4;
		}
		if (isset($instance['number_columns'])) {
			$number_columns = $instance['number_columns'];
		} else {
			$number_columns = 3;
		}
		if (isset($instance['category_p'])) {
			$category_p = $instance['category_p'];
		} else {
			$category_p = '';
		}
		if (isset($instance['category_g'])) {
			$category_g = $instance['category_g'];
		} else {
			$category_g = '';
		}
		if (isset($instance['gutter'])) {
			$gutter = $instance['gutter'];
		} else {
			$gutter = 'default';
		}
		if ($number_columns != '') {
			if ($number_columns == '3') {
				$cur_title_col = 'medium-block-grid-3';
			} elseif ($number_columns == '4') {
				$cur_title_col = 'medium-block-grid-4';
			} else {
				$cur_title_col = 'medium-block-grid-4';
			}
		}

		if($post_type == 'post'){
			$taxonomy = 'category';
			if(!is_array($category_p) && strlen(trim($category_p))){
				$term_name = explode(',',substr($category_p, 0));
			}else{
				$term_name = $category_p;
			}

		}
		if($post_type == 'gallery'){
			$taxonomy = 'gallery-category';
			if(!is_array($category_g) && strlen(trim($category_g))){
				$term_name = explode(',',substr($category_g, 0, -1));
			}else{
				$term_name = $category_g;
			}

		}
		$query_args = array('post_type' => $post_type, 'orderby' => 'title', 'order' => 'DESC', 'posts_per_page' => $number_posts);
		if (strlen($taxonomy) && $term_name) {
			$query_args['tax_query'] = array(
					array(
							'taxonomy' => $taxonomy,
							'field'    => 'slug',
							'terms'    => $term_name
					)
			);
		}
		if (strlen($gutter)) {
			$gutter_class = 'gutter-gutter-' . $gutter;
		} else {
			$gutter_class = '';
		}

		$query = new WP_Query($query_args);
		?>
		<aside class="widget">
			<div class="featured-posts">
				<div class="row">
					<div class="large-12 columns">
						<ul class="<?php echo $cur_title_col; ?>">


							<?php
							foreach ($query->posts as $item){

								if (has_post_thumbnail($item->ID) && !post_password_required()) {
									$img_url1 = wp_get_attachment_url(get_post_thumbnail_id($item->ID), 'full'); //get img URL
									$img_url  = aq_resize($img_url1, 600, 600, true, true, true); //crop img
								}

								if (!isset($img_url) || $img_url == '') {
									$img_url = get_template_directory_uri() . '/img/aq_resize/noimage-600x600.jpg';
								}?>
								<li class="image">
									<figure>
										<a href="<?php echo get_the_permalink($item->ID); ?>"><img src="<?php echo $img_url; ?>" alt=""></a>
									</figure>
								</li>
								<?php
								}
								?>

						</ul>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns">
						<h3 class="title"><?php echo $title;?></h3></div>
				</div>
			</div>
		</aside>
	<?php

	}

	function update($new_instance, $old_instance)
	{
		/*save the widget*/
		$instance = $old_instance;

		$instance['post_type']      = strip_tags($new_instance['post_type']);
		$instance['title']          = strip_tags($new_instance['title']);
		$instance['number_posts']   = strip_tags($new_instance['number_posts']);
		$instance['number_columns'] = strip_tags($new_instance['number_columns']);
		$instance['gutter']         = strip_tags($new_instance['gutter']);
		if (isset($new_instance['category_p'][""])) {
			$instance['category_p'] = $new_instance['category_p'][""];
		} elseif (isset($new_instance['category_p'])) {
			$instance['category_p'] = $new_instance['category_p'];
		}
		if (isset($instance['category_g'][""])) {
			$instance['category_g'] = $new_instance['category_g'][""];
		} else {
			$instance['category_g'] = $new_instance['category_g'];
		}

		return $instance;
	}

	function form($instance)
	{
		/* widget form in backend */
		$instance = wp_parse_args((array)$instance, array('post_type' => '', 'category_p' => array(), 'category_g' => array(), 'number_posts' => '4', 'number_columns' => '4', 'gutter' => '', 'title' => 'Featured Posts'));

		$post_type      = strip_tags($instance['post_type']);
		$title          = strip_tags($instance['title']);
		$number_posts   = strip_tags($instance['number_posts']);
		$number_columns = strip_tags($instance['number_columns']);
		$gutter         = strip_tags($instance['gutter']);
		if (isset($instance['category_p'][""])) {
			$category_p = $instance['category_p'][""];
		} else {
			$category_p = $instance['category_p'];
		}
		if (isset($instance['category_g'][""])) {
			$category_g = $instance['category_g'][""];
		} else {
			$category_g = $instance['category_g'];
		}
		if (!esc_attr($post_type)) {
			$post_type = 'post';
		}
		wp_enqueue_media(); // need this for the image uploader
		?>
		<p>
			<label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type', 'flotheme') ?>:
				<select class="widefat select_post_type" onchange="change_select(jQuery(this))" id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>">
					<option value="post" <?php if (esc_attr($post_type) == 'post') {
						echo "selected='selected'";
					} ?>>Post
					</option>
					<option value="gallery" <?php if (esc_attr($post_type) == 'gallery') {
						echo "selected='selected'";
					} ?>>Gallery
					</option>
				</select>
			</label>
		</p>
		<?php

		$post_cats = get_terms('category', array('hide_empty' => true));

		$select_post_categories = '<select multiple="multiple" class="widefat select_category post_cats" id="' . $this->get_field_id('category_p') . '" name="' . $this->get_field_name('category_p') . '[]">';
		foreach ($post_cats as $cat_p) {
			if (isset($category_p)) {
				if (is_array($category_p)) {
					if (in_array($cat_p->slug, $category_p)) {
						$attr_cat[$cat_p->slug] = "selected='selected'";
					} else {
						$attr_cat[$cat_p->slug] = '';
					}
				} else {
					if ($cat_p->slug == $category_p) {
						$attr_cat[$cat_p->slug] = "selected='selected'";
					} else {
						$attr_cat[$cat_p->slug] = '';
					}
				}
			} else {
				$attr_cat[$cat_p->slug] = '';
			}
			$select_post_categories .= '<option ' . $attr_cat[$cat_p->slug] . ' value="' . $cat_p->slug . '">' . $cat_p->name . '</option>';
		}
		$select_post_categories .= '</select>';


		$gallery_cats              = get_terms('gallery-category', array('hide_empty' => true));
		$select_gallery_categories = '<select multiple="multiple" class="widefat select_category gallery_cats"  id="' . $this->get_field_id('category_g') . '" name="' . $this->get_field_name('category_g') . '[]">';
		foreach ($gallery_cats as $cat_g) {
			if (isset($category_g)) {
				if (in_array($cat_g->slug, $category_g)) {
					$attr_cat[$cat_g->slug] = "selected='selected'";
				} else {
					$attr_cat[$cat_g->slug] = '';
				}
			} else {
				$attr_cat[$cat_g->slug] = '';
			}
			$select_gallery_categories .= '<option ' . $attr_cat[$cat_g->slug] . ' value="' . $cat_g->slug . '">' . $cat_g->name . '</option>';
		}
		$select_gallery_categories .= '</select>';
		?>


		<style type="text/css">
			.cats_hd
			{
				display: none;
			}

			.cats_sh
			{
				display: block;
			}
		</style>
		<label class="lbl_to_change" for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category', 'flotheme') ?>:
			<div class="to_change">
				<?php
				if (esc_attr($post_type) == 'post') {
					echo "<div class='posts cats_sh' >" . $select_post_categories . "</div>";
					echo "<div class='galleries cats_hd' >" . $select_gallery_categories . "</div>";
				} elseif (esc_attr($post_type) == 'gallery') {
					echo "<div class='galleries cats_sh' >" . $select_gallery_categories . "</div>";
					echo "<div class='posts cats_hd' >" . $select_post_categories . "</div>";
				}
				?>
			</div>
		</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'flotheme') ?>:
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/>
			</label>
		</p>
		<p class="number_columns">
			<label for="<?php echo $this->get_field_id('number_columns'); ?>"><?php _e('Number of columns', 'flotheme') ?>:
				<select class="widefat" id="<?php echo $this->get_field_id('number_columns'); ?>" name="<?php echo $this->get_field_name('number_columns'); ?>">
					<option value="3" <?php if (esc_attr($number_columns) == '3' || !$number_columns) {
						echo "selected='selected'";
					} ?>>3
					</option>
					<option value="4" <?php if (esc_attr($number_columns) == '4') {
						echo "selected='selected'";
					} ?>>4
					</option>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number_posts'); ?>"><?php _e('Number of posts', 'flotheme') ?>:
				<input class="widefat" id="<?php echo $this->get_field_id('number_posts'); ?>" name="<?php echo $this->get_field_name('number_posts'); ?>" type="text" value="<?php if (!$number_posts) {
					echo "6";
				} else {
					echo $number_posts;
				} ?>"/>
			</label>
		</p>
		<p class="gutter">
			<label for="<?php echo $this->get_field_id('gutter'); ?>"><?php _e('Gutter', 'flotheme') ?>:
				<select class="widefat" id="<?php echo $this->get_field_id('gutter'); ?>" name="<?php echo $this->get_field_name('gutter'); ?>">
					<option value="gutter-default" <?php if (esc_attr($gutter) == 'default') {
						echo "selected='selected'";
					} ?>>Default 30px
					</option>
					<option value="gutter-0" <?php if (esc_attr($gutter) == 'gutter-0') {
						echo "selected='selected'";
					} ?>>No gutter
					</option>
					<option value="gutter-2" <?php if (esc_attr($gutter) == 'gutter-2') {
						echo "selected='selected'";
					} ?>>Gutter 2px
					</option>
					<option value="gutter-5" <?php if (esc_attr($gutter) == 'gutter-5') {
						echo "selected='selected'";
					} ?>>Gutter 5px
					</option>
					<option value="gutter-10" <?php if (esc_attr($gutter) == 'gutter-10') {
						echo "selected='selected'";
					} ?>>Gutter 10px
					</option>
					<option value="gutter-20" <?php if (esc_attr($gutter) == 'gutter-20') {
						echo "selected='selected'";
					} ?>>Gutter 20px
					</option>
					<option value="gutter-40" <?php if (esc_attr($gutter) == 'gutter-40') {
						echo "selected='selected'";
					} ?>>Gutter 40px
					</option>
					<option value="gutter-50" <?php if (esc_attr($gutter) == 'gutter-50') {
						echo "selected='selected'";
					} ?>>Gutter 50px
					</option>
				</select>
			</label>
		</p>
	<?php
	}
}
wp_reset_query();
wp_reset_postdata();
?>
