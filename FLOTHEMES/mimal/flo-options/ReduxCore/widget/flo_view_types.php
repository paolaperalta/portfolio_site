<?php

class widget_flo_view_types extends WP_Widget
{

	function __construct()
	{
		$widget_ops = array('classname' => 'flo_view_types', 'description' => __('Flo Posts Types', 'flotheme'));
		parent::__construct('widget_cosmo_flo_view_types', _TN_ . ' : ' . __('Flo Posts Types', 'flotheme'), $widget_ops);
	}

	function widget($args, $instance)
	{
		/* prints the widget*/
		extract($args, EXTR_SKIP);

		if (isset($instance['title'])) {
			$title = $instance['title'];
		} else {
			$title = '';
		}

		if (isset($instance['select_view_type'])) {
			$select_view_type = $instance['select_view_type'];
		} else {
			$select_view_type = '';
		}
		if (isset($instance['post_type'])) {
			$post_type = $instance['post_type'];
		} else {
			$post_type = '';
		}
		if (isset($instance['category_p'])) {
			$category_p = $instance['category_p'];
		} else {
			$category_p = '';
		}
		if (isset($instance['page_ids'])) {
			$page_ids = $instance['page_ids'];
		} else {
			$page_ids = '';
		}
		if (isset($instance['category_g'])) {
			$category_g = $instance['category_g'];
		} else {
			$category_g = '';
		}
		if (isset($instance['number_posts'])) {
			$number_posts = $instance['number_posts'];
		} else {
			$number_posts = '';
		}
		if (isset($instance['number_columns'])) {
			$number_columns = $instance['number_columns'];
		} else {
			$number_columns = '';
		}
		if (isset($instance['gutter'])) {
			$gutter = $instance['gutter'];
		} else {
			$gutter = '';
		}


		if (isset($instance['pagination'])) {
			$pagination = $instance['pagination'];
		} else {
			$pagination = '';
		}

		if($category_p){
			$cat_p ='';
			if(is_array($category_p)){

				foreach($category_p as $cat){
					$cat_p .= $cat.",";
				}
			}else{
				$cat_p = $category_p;
			}
		}else{
			$cat_p = '';
		}
		if($category_g){
			$cat_g ='';
			if(is_array($category_g)){
				foreach($category_g as $cat){
					$cat_g .= $cat.",";
				}
			}else{
				$cat_g = $category_g;
			}
		}else{
			$cat_g = '';
		}
		if($page_ids){
			$pgs ='';
			if(is_array($page_ids)){
				foreach($page_ids as $cat_page){
					$pgs .= $cat_page.",";
				}
			}else{
				$pgs = $page_ids;
			}
		}else{
			$pgs = '';
		}
		if ($select_view_type != '') {
			?>
				<?php if ( (isset($image_src) && $image_src !='') || (isset($title) && $title != '') ): ?>
					<div class="block heading-title">
						<div class="row">
							<article style="text-aling:center;" class="content">
								<?php if(isset($image_src) && $image_src !=''){?><img src="<?php echo $image_src;?>" alt=""><?php }?>
								<?php if(isset($title) && $title != ''){?><h3> <?php echo $title;?></h3><?php }?>
							</article>
						</div>
					</div>
				<?php endif ?>
				
			<?php

			echo do_shortcode('
				[flo_list_posts post_type="' . $post_type . '" category_p="' . $cat_p . '"
				page_ids="'.$pgs.'" category_g="' . $cat_g . '" view_type="' . $select_view_type . '" number_columns="' . $number_columns . '" number_posts="' . $number_posts . '" gutter="' . $gutter . '" ][/flo_list_posts]'
			);
		}
	}

	function update($new_instance, $old_instance)
	{
		/*save the widget*/
		$instance = $old_instance;

		$instance['title']               = strip_tags($new_instance['title']);

		$instance['post_type']           = strip_tags($new_instance['post_type']);
		$instance['select_view_type']    = strip_tags($new_instance['select_view_type']);
		$instance['number_posts']        = strip_tags($new_instance['number_posts']);
		$instance['number_columns']      = strip_tags($new_instance['number_columns']);
		$instance['gutter']              = strip_tags($new_instance['gutter']);

		if(isset($new_instance['category_p'][""])){
			$instance['category_p']              = $new_instance['category_p'][""];
		}elseif(isset($new_instance['category_p'])){
			$instance['category_p']              = $new_instance['category_p'];
		}
		if(isset($instance['category_g'][""])){
			$instance['category_g']              = $new_instance['category_g'][""];
		}else{
			$instance['category_g']              = $new_instance['category_g'];
		}
		if(isset($instance['page_ids'][""])){
			$instance['page_ids']              = $new_instance['page_ids'][""];
		}else{
			$instance['page_ids']              = $new_instance['page_ids'];
		}
		return $instance;
	}

	function form($instance)
	{
		/* widget form in backend */
		$instance = wp_parse_args((array)$instance, array('title'               => '', 'post_type' => '', 'select_view_type' => '', 'category_p' => array(), 'category_g' => array(), 'number_posts' => '', 'number_columns' => '', 'gutter' => '',
		                                                  'pagination' => '', 'page_ids' => array(),
		                                                  ));

		$title                   = strip_tags($instance['title']);

		$post_type               = strip_tags($instance['post_type']);
		$select_view_type        = strip_tags($instance['select_view_type']);
		$number_posts            = strip_tags($instance['number_posts']);
		$number_columns          = strip_tags($instance['number_columns']);
		$gutter                  = strip_tags($instance['gutter']);
		if(isset($instance['category_p'][""])){
			$category_p              = $instance['category_p'][""];
		}else{
			$category_p              = $instance['category_p'];
		}
		if(isset($instance['category_g'][""])){
			$category_g              = $instance['category_g'][""];
		}else{
			$category_g              = $instance['category_g'];
		}
		if(isset($instance['page_ids'][""])){
			$page_ids              = $instance['page_ids'][""];
		}else{
			$page_ids              = $instance['page_ids'];
		}
		if(!esc_attr($post_type)){
			$post_type = 'post';
		}
		wp_enqueue_media(); // need this for the image uploader
		?>
		<p style="color: blue">
			<?php _e('This widget is recommended to be used only in full width sidebars where there is enough room to display the content.', 'flotheme'); ?>
		</p>
		<style type="text/css">
			.cmb2-list li
			{
				display: inline-block;
			}

			.cmb2-list li img
			{
				border: 1px solid #fff;
			}
		</style>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'flotheme') ?>:
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
				       name="<?php echo $this->get_field_name('title'); ?>" type="text"
				       value="<?php echo esc_attr($title); ?>"/>
			</label>
		</p>
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
					<option value="page" <?php if (esc_attr($post_type) == 'page') {
						echo "selected='selected'";
					} ?>>Pages
					</option>
				</select>
			</label>
		</p>
		<?php

		$post_cats              = get_terms('category', array('hide_empty' => true));

		$select_post_categories = '<select multiple="multiple" class="widefat select_category post_cats" id="' . $this->get_field_id('category_p') . '" name="' . $this->get_field_name('category_p') . '[]">';
		foreach ($post_cats as $cat_p) {
			if (isset($category_p)) {
				if(is_array($category_p)){
					if (in_array($cat_p->slug, $category_p)) {
						$attr_cat[$cat_p->slug] = "selected='selected'";
					} else {
						$attr_cat[$cat_p->slug] = '';
					}
				}else{
					if($cat_p->slug == $category_p){
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

		$pages              = get_pages();
		$select_pages = '<select multiple="multiple" class="widefat select_pages pages"  id="' . $this->get_field_id('page_ids') . '" name="' . $this->get_field_name('page_ids') . '[]">';
		foreach ($pages as $pg) {

		if (isset($page_ids ) && $page_ids != '') {
				if (in_array($pg->ID, $page_ids)) {
					$attr_cat_p[$pg->ID] = "selected='selected'";
				} else {
					$attr_cat_p[$pg->ID] = '';
				}
			} else {
				$attr_cat_p[$pg->ID] = '';
			}
			$select_pages.= '<option ' . $attr_cat_p[$pg->ID] . ' value="' . $pg->ID . '">' . $pg->post_title . '</option>';
		}
		$select_pages .= '</select>';
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
		<label class="lbl_to_change" for="<?php echo $this->get_field_id('category'); ?>">
		<span class="ttl"><?php if(esc_attr($post_type) != 'page'):_e('Category', 'flotheme');else: _e('Select pages ');endif; ?>:</span>
			<div class="to_change">
				<?php
				if (esc_attr($post_type) == 'post') {
					echo "<div class='posts cats_sh' >" . $select_post_categories . "</div>";
					echo "<div class='galleries cats_hd' >" . $select_gallery_categories . "</div>";
					echo "<div class='pages cats_hd' >" . $select_pages . "</div>";
				} elseif(esc_attr($post_type) == 'gallery') {
					echo "<div class='galleries cats_sh' >" . $select_gallery_categories . "</div>";
					echo "<div class='posts cats_hd' >" . $select_post_categories . "</div>";
					echo "<div class='pages cats_hd' >" . $select_pages . "</div>";
				}elseif(esc_attr($post_type) == 'page') {
					echo "<div class='pages cats_sh' >" . $select_pages . "</div>";
					echo "<div class='posts cats_hd' >" . $select_post_categories . "</div>";
					echo "<div class='galleries cats_hd' >" . $select_gallery_categories . "</div>";
				}
				?>
			</div>
		</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('select_view_type'); ?>"><?php _e('View Type', 'flotheme') ?>:

				<ul class="cmb2-radio-list cmb2-list">
					<li><input type="radio" <?php if (esc_attr($select_view_type) == 'grid_view') {
							echo "checked";
						} ?> class="cmb2-option" name="<?php echo $this->get_field_name('select_view_type'); ?>" id="<?php echo $this->get_field_id('select_view_type'); ?>" value="grid_view" style="display: none;">
						<img title="Grid View" class="pattern-texture grid_view" alt="Grid View" src="<?php echo
						get_template_directory_uri(); ?>/flo-options/ReduxCore/assets/img/pattern/.
						./icons/view_type_1.jpg">
					</li>
					<li><input type="radio" <?php if (esc_attr($select_view_type) == 'orig-size') {
							echo "checked";
						} ?> class="cmb2-option" name="<?php echo $this->get_field_name('select_view_type'); ?>" id="<?php echo $this->get_field_id('select_view_type'); ?>" value="orig-size" style="display: none;">
						<img title="Original Size" class="pattern-texture orig-size" alt="Original Size" src="<?php
						echo get_template_directory_uri(); ?>/flo-options/ReduxCore/assets/img/pattern/../icons/gallery_1.jpg" style="border: none;">
					</li>
					<li><input type="radio" <?php if (esc_attr($select_view_type) == 'list_full_width_view') {
							echo "checked";
						} ?> class="cmb2-option" name="<?php echo $this->get_field_name('select_view_type'); ?>" id="<?php echo $this->get_field_id('select_view_type'); ?>" value="list_full_width_view" style="display: none;">
						<img title="List full width view" class="pattern-texture list_view" alt="List view" src="<?php
						echo
						get_template_directory_uri(); ?>/flo-options/ReduxCore/assets/img/pattern/../icons/blog_layout_1.jpg" style="border: none;">
					</li>

					<li><input type="radio" <?php if (esc_attr($select_view_type) == 'list_content_width_view') {
							echo "checked";
						} ?> class="cmb2-option" name="<?php echo $this->get_field_name('select_view_type'); ?>" id="<?php echo $this->get_field_id('select_view_type'); ?>" value="list_content_width_view" style="display: none;">
						<img title="List content width view" class="pattern-texture list_view" alt="List content
						width view" src="<?php
						echo
						get_template_directory_uri(); ?>/flo-options/ReduxCore/assets/img/pattern/.
						./icons/blog_layout_2.jpg" style="border: none;">
					</li>

				</ul>
				<div style="clear: both"></div>
			</label>
		</p>
		<p class="number_columns">
			<label for="<?php echo $this->get_field_id('number_columns'); ?>"><?php _e('Number of columns', 'flotheme') ?>:
				<select class="widefat" id="<?php echo $this->get_field_id('number_columns'); ?>" name="<?php echo $this->get_field_name('number_columns'); ?>">

					<option value="3" <?php if (esc_attr($number_columns) == '3') {
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
				<input class="widefat" id="<?php echo $this->get_field_id('number_posts'); ?>" name="<?php echo $this->get_field_name('number_posts'); ?>" type="text" value="<?php echo $number_posts; ?>"/>
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
		<script type="text/javascript">
			jQuery('.cmb2-list li').on('click', 'img', function () {
				jQuery(this).parents('ul').find('li img').each(function () {
					jQuery(this).css({
						'border': 'none'
					})
				});
				jQuery(this).parent('li').find('input').click();
				jQuery(this).parent('li').find('img').css(
						{
							'border': '5px solid grey'
						}
				);
			});

			jQuery('.cmb2-radio-list li').find('input').each(function () {
				if (jQuery(this).is(':checked')) {
					jQuery(this).parent('li').find('img').css(
							{
								'border': '5px solid grey'
							}
					);
				}
			});
			var str = "";
			function show_hide() {
				jQuery(".cmb2-radio-list input:checked").each(function () {

					str = jQuery(this).val();
					if (str == 'grid_view') {
						jQuery('.number_columns').show();
						jQuery('.gutter').show();
					}
					else if (str == 'list_full_width_view') {
						jQuery('.number_columns').hide();
						jQuery('.gutter').hide();
					}
					else if (str == 'list_content_width_view') {
						jQuery('.number_columns').hide();
						jQuery('.gutter').hide();
					}
					else if (str == 'orig-size') {
						jQuery('.number_columns').show();
						jQuery('.gutter').show();
					}
				});
			}

			show_hide();

			jQuery(".cmb2-radio-list").on("click", "img", function () {
				show_hide();
			});
		</script>
	<?php
	}
}

?>
