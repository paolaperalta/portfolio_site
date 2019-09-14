<?php

class widget_about_image_block extends WP_Widget
{

	function __construct() {
		$widget_ops = array('classname' => 'widget_about_image_block', 'description' => __(" Image", 'flotheme'));
		parent::__construct('widget_cosmo_about_image_block', _TN_ . ': ' . __("Image", 'flotheme'), $widget_ops);
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
		if (isset($instance['link'])) {
			$link = $instance['link'];
		} else {
			$link = '';
		}
		if (isset($instance['image'])) {
			$image = $instance['image'];
		} else {
			$image = array();
		}

		$image_src = '';

		if (isset($image) && is_numeric($image)) {
			$attachment_info = wp_get_attachment_image_src($image, 'full'); // get the image attachment from image ID
			$image_src       = $attachment_info[0];
		}



		?>
		<aside class="widget widget_about_widget_block">
			<!-- NOTE   Add this class if image exists class="author-has-thumbnail" -->
			<article class="<?php if (strlen($image_src))
				echo 'author-has-thumbnail'; ?>">
				<header>
					<h3 class="author-name" style="text-align: center">
						<?php if (strlen($link)){ ?>
						<a href="<?php echo $link ?>">
							<?php } ?>
							<?php echo $title; ?>
							<?php if (strlen($link)){ ?>
						</a>
					<?php } ?>
					</h3>
					<!-- NOTE   If image exist - show div .about-author-bg -->
					<?php if (strlen($image_src)) { ?>
						<div class="about-author-bg">
							<?php if (strlen($link)){ ?>
							<a href="<?php echo $link ?>">
								<?php } ?>
								<img class="polaroid" src="<?php echo $image_src; ?>" alt="">
								<?php if (strlen($link)){ ?>
							</a>
						<?php } ?>
						</div> <!-- end .about-author-bg -->
					<?php } ?>
				</header>
			</article>
		</aside>


	<?php
	}

	function update($new_instance, $old_instance)
	{

		/*save the widget*/
		$instance = $old_instance;
		//		print_r($new_instance);die;
		$instance['title']     = strip_tags($new_instance['title']);
		$instance['image']     = strip_tags($new_instance['image']);
		$instance['link']      = strip_tags($new_instance['link']);
//		foreach ($new_instance['about'] as $about) {
//			if ($about != '') {
//				$instance['about'][] = $about;
//			}
//		}

		return $instance;
	}


	function form($instance)
	{

		/* widget form in backend */
		$instance  = wp_parse_args((array)$instance, array('title' => '', 'sub_title' => '', 'link' => '', 'image' => '', 'descr' => '', 'about' => array(), 'color' => '', 'like_text' => ''));
		$title     = strip_tags($instance['title']);
		$image     = strip_tags($instance['image']); //  image ID
		$link      = strip_tags($instance['link']);
//		if (isset($instance['about'])) {
//			$about = $instance['about'];
//		} else {
//			$about = array();
//		}


		if (isset($image) && is_numeric($image)) {
			$attachment_info = wp_get_attachment_image_src($image, 'thumbnail'); // get the image attachment from image ID
			$image_src       = $attachment_info[0];
			$image_id        = $image;

		}

		$placeholder_img_src = get_template_directory_uri() . "/img/placeholder.png";

		wp_enqueue_media(); // need this for the image uploader
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'flotheme') ?>:
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>"/>
			</label>
		</p>
		<!-- /*////////////////////////////////////////*/*/*/*/*/ -->
		<p class="form-field">
			<label><?php _e('Image:', 'flotheme'); ?></label>
            <span class="meta-box-field fvisible hidden " style="display: inline;">
                <input type="hidden" class="hidden-id" name="<?php echo $this->get_field_name('image_url'); ?>"
                       value="<?php if (isset($image_src) && !empty($image_src))
	                       echo esc_attr($image_src); ?>">

                <input type="hidden" class="hidden-image-id" name="<?php echo $this->get_field_name('image'); ?>"
                       value="<?php if (isset($image_id) && !empty($image_id))
	                       echo esc_attr($image_id); ?>">
                
                <a href="#" class="upload_image_button" onclick="flo_upload_image(jQuery(this));" title="Click on the image to upload a new one">
	                <img src="<?php if (isset($image_src) && !empty($image_src))
		                echo esc_attr($image_src); else echo $placeholder_img_src; ?>" class="upload-thumb"/>
                </a>
                <a href="javascript:void(0);" onclick="  jQuery(this).parent().find('.hidden-id').val(''); jQuery(this).parent().find('img').attr('src','<?php echo $placeholder_img_src; ?>');">Remove</a>
                <br>
                
            </span>
		</p>
		<!-- /*////////////////////////////////////////*/*/*/*/*/ -->

		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link URL', 'flotheme') ?>:
				<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>"/>
			</label>
		</p>
		<script type="text/javascript">
			function fix__i__(obj) {
				var n = jQuery(obj).parents('.widget').find('input.multi_number').val();
				if (n.length && n != '' && n.length > 0) {
					jQuery(obj).parents('.widget-content').find('select, input, textarea').each(function (index, element) {
						var id = jQuery(element).attr('id');
						var name = jQuery(element).attr('name');
						if (id && id.length && id.length > 0) {
							jQuery(element).attr('id', id.replace('__i__', n));
						}
						if (name && name.length && name.length > 0) {
							jQuery(element).attr('name', name.replace('__i__', n));
						}
					});
				}
			}
			var image_field;
			jQuery(function ($) {
				$(document).on('click', 'input.select-img', function (evt) {
					image_field = $(this).siblings('.img');
					tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
					return false;
				});
				window.send_to_editor = function (html) {
					imgurl = $('img', html).attr('src');
					image_field.val(imgurl);
					tb_remove();
				}
			});
			var text;
			jQuery('.widget-top').click(function () {
				var id = jQuery(this).parents('.widget').attr('id');
				if (id.indexOf('about') !== -1) {
					jQuery('.widgets-chooser-sidebars li').each(function () {
						text = jQuery(this).text();
						jQuery(this).show();
					});
				} else {
					jQuery('.widgets-chooser-sidebars li').each(function () {
						text = jQuery(this).text();
						jQuery(this).show();
						if (text == 'About') {
							jQuery(this).hide();
						}
					});
				}
			});

			function flo_upload_image(obj) {

				// Uploading files
				var image_gallery_frame;


				// If the media frame already exists, reopen it.
				if (image_gallery_frame) {
					image_gallery_frame.open();
					return;
				}

				// Create the media frame.
				image_gallery_frame = wp.media.frames.downloadable_file = wp.media({
					// Set the title of the modal.
					title: 'Add attachment',
					button: {
						text: 'Add this attachment',
					},
					multiple: false
				});

				// When an image is selected, run a callback.
				image_gallery_frame.on('select', function () {

					var selection = image_gallery_frame.state().get('selection');

					selection.map(function (attachment) {

						attachment = attachment.toJSON();

						if (attachment.id) {
							jQuery(obj).parent().find('.hidden-id').val(attachment.url); // add the image URL in the hidden input

							jQuery(obj).parent().find('.hidden-image-id').val(attachment.id); // add the image ID in the hidden input

							jQuery(obj).parent().find('img').attr("src", attachment.url);

						}

					});


				});

				// Finally, open the modal.
				image_gallery_frame.open();

			}
		</script>
	<?php
	}
}


?>
