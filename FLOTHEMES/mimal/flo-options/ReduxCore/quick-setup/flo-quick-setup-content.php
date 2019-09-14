<?php
	global $dummy_data_folders, $flo_options;
?>
<div class="flo-setup-wizard">
	<h1><?php _e('Setup Wizard','flotheme'); ?></h1>

	<div class="flo-step">
		<div class="step-title">
			<?php _e('Step 1.','flotheme'); ?>
		</div>
		<div class="title">
			<?php _e('Install the recommended plugins.','flotheme'); ?>
		</div>

		<span class="hint"> <?php _e('This step is optional','flotheme'); ?></span>
		<br/>
		<?php
			echo sprintf(__('We recommend a few plugins which are necessary or useful. %s
				Review please the recommended plugins and install only those you need. %s
				If you are not sure what you need, you can leave this for later. %s%s','flotheme'), '<br/>','<br/>','<br/>','<br/>');

			echo sprintf(__('%sInstall and activate%s the recommended plugins','flotheme'),'<a href="'.get_dashboard_url().'themes.php?page=install-required-plugins" target="_blank">','</a>' );
		?>

	</div>

	<div class="flo-step">
		<div class="step-title">
			<?php _e('Step 2.','flotheme'); ?>
		</div>
		<div class="title">
			<?php _e('Import the demo data','flotheme'); ?>
		</div>

		<span class="hint"> <?php _e('This step is optional','flotheme'); ?></span>
		<br/>

		<?php
			echo sprintf(__('Here you can import the demo data to your site. Doing this will make your site look like the demo site.
				It helps you to understand better the theme and build something similar to our demo quiker. Then you can edit the demo content 
				and add your own. And after you are done, make sure to delete remaining demo Pages and Blog posts.%s%s

				Importing the demo data may take some time. Do not close this window until the process is done. %s%s

				%s Important: %s If you have an exiting website, %s do not import the dummy data%s, doing that will mix your content with the demo content and it will be a mess. %s %s

				Before importing the content, please install and activate %s Widget Importer Exporter%s plugin if you want to import all the demo widgets. Also you may need to use %s Jetpack%s plugin with its %s Widget Visibility%s extension.',

				'flotheme'), '<br/>','<br/>','<br/>', '<br/>', '<b>', '</b>', '<b class="underline red">', '</b>', '<br/>', '<br/>','<a href="https://wordpress.org/plugins/widget-importer-exporter/" target="_blank">', '</a>','<a href="https://wordpress.org/plugins/jetpack/" target="_blank">','</a>','<a href="http://jetpack.me/support/widget-visibility/" target="_blank">','</a>' );

			
		?>

		<br/><br/><br/>

		<div class="actions-container">
		
			<select id="flo_minimal-import_one_click-select"  class="redux-select-item" >
				<option data-group="" value="">Select the demo you want to import</option>
				<?php
					foreach ($dummy_data_folders as $key => $value) {
				?>
						<option data-group="" value="<?php echo $key; ?>"><?php echo $value; ?></option>
				<?php
					}
				?>

			</select>
			<br/>

			<input type="button" class="import-demo-content generic-record-button"
			value=" <?php _e('Import dummy data', 'flotheme') ?>" onclick="importDummyData();">

			<div class="spinner-container">
				<span class="spinner import-demo-spinner" ></span>
			</div>
			<div class="import-response response-box"><?php _e('Please be patient, the process may take some time.', 'flotheme'); ?></div>
		</div>
	</div>

	<div class="flo-step">
		<div class="step-title">
			<?php _e('Step 3.','flotheme'); ?>
		</div>
		<div class="title">
			<?php _e('Home page','flotheme'); ?>
		</div>

		<span class="hint"> <?php _e('This step is optional','flotheme'); ?></span>
		<br/>
		<br/>

		<div class="actions-container">
			<select  class="redux-select-item home-page-creation" >
				<option value="">Select and option</option>
				<option value="automatically"><?php _e("Automatically create a home page called Home",'flotheme'); ?></option>
				<option value="manually"><?php _e("Set one of the existing pages as the Home page ",'flotheme'); ?></option>
			</select>
			<?php wp_dropdown_pages( array('class' => 'home-pages-list', 'show_option_none' => __('Select the home page','flotheme')) ); ?>
			<br/>
			<input type="button" class=" generic-record-button "
			value=" <?php _e('Set the home page', 'flotheme') ?>" onclick="floSetHomePage();">

			<div class="spinner-container">
				<span class="spinner wizard-home-page-spinner" ></span>
			</div>

			<div class="wizard-home-page-response response-box"></div>
		</div>
	</div>

	<div class="flo-step">
		<div class="step-title">
			<?php _e('Step 4.','flotheme'); ?>
		</div>
		<div class="title">
			<?php _e('Blog page','flotheme'); ?>
		</div>

		<span class="hint"> <?php _e('This step is optional','flotheme'); ?></span>
		<br/>
		<br/>

		<div class="actions-container">
			<select  class="redux-select-item blog-page-creation" >
				<option value="">Select and option</option>
				<option value="automatically"><?php _e("Automatically create a blog page called Blog",'flotheme'); ?></option>
				<option value="manually"><?php _e("Set one of the existing pages as the Blog page ",'flotheme'); ?></option>
			</select>
			<?php wp_dropdown_pages( array('class' => 'blog-pages-list', 'show_option_none' => __('Select the blog page','flotheme')) ); ?>
			<br/>
			<input type="button" class=" generic-record-button  "
			value=" <?php _e('Set the blog page', 'flotheme') ?>" onclick="floSetBlogPage();">

			<div class="spinner-container">
				<span class="spinner wizard-blog-page-spinner" ></span>
			</div>

			<div class="wizard-blog-page-response response-box"></div>
		</div>
	</div>

	<div class="flo-step">
		<div class="step-title">
			<?php _e('Step 5.','flotheme'); ?>
		</div>
		<div class="title">
			<?php _e('Menu options','flotheme'); ?>
		</div>

		
		<br/>

		<?php
			$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		?>
		<div class="actions-container">
			<select  class="redux-select-item menu-creation" >
				<option value="">Select and option</option>
				<option value="automatically">
					<?php _e("Automatically create the menu from existing pages",'flotheme'); ?>
				</option>
				<?php if (sizeof($menus)): ?>
					<option value="manually"><?php _e("Set one of the existing menus as the Primary menu ",'flotheme'); ?></option>
				<?php endif ?>

			</select>
			<?php

				if(sizeof($menus)){
				?>
				<select  class="redux-select-item main-menu-select" >
					<option value="">Select a menu</option>
				<?php
					foreach ($menus as $key => $menu) {
					?>
						<option value="<?php echo $menu->term_id; ?>"><?php echo $menu->name; ?></option>
					<?php

					}
				?>
				</select>
				<?php

				}

			?>
			<br/>
			<input type="button" class=" generic-record-button "
			value=" <?php _e('Set the primary menu', 'flotheme') ?>" onclick="floSetMainMenu();">

			<div class="spinner-container">
				<span class="spinner wizard-menu-spinner"></span>
			</div>

			<div class="wizard-menu-response response-box"></div>
		</div>
	</div>

	<div class="flo-step quick-styling">
		<div class="step-title">
			<?php _e('Step 6.','flotheme'); ?>
		</div>
		<div class="title">
			<?php _e('Quick styling.','flotheme'); ?>
		</div>

		<br/>
		<div class="style-options">
			<div class="title-label">
				<h4 class="dot"><?php _e('Upload the main logo image','flotheme'); ?></h4>
			</div>
			<div class="options">
				<?php

					$logo_data = array();

					// Note. for the other themes replace the prefix
					if(isset($flo_options['flo-logo_image_desktop'])){

						$logo_data = $flo_options['flo-logo_image_desktop'];
					}

					quick_setup_image_uploader_field( $logo_data, 'logo');
				?>
				<div class="wizard-logo-response response-box success">
					<?php _e('The logo was updated succesfully','flotheme'); ?>
				</div>
			</div>

			<div class="delimiter"></div>

			<div class="title-label">
				<h4 class="dot"><?php _e('Upload custom favicon','flotheme'); ?></h4>
			</div>
			<div class="options">
				<?php

					$fav_ico_data = array();

					// Note. for the other themes replace the prefix
					if(isset($flo_options['flo_minimal-favicon'])){

						$fav_ico_data = $flo_options['flo_minimal-favicon'];
					}

					quick_setup_image_uploader_field( $fav_ico_data, 'fav_ico');
				?>
				
				<div class="fav-ico response-box error">
					<?php  
						echo sprintf(__("Please use 'ico' type media file If you don't have a favicon, you can generate one using %s this service %s",'flotheme'), "<a href='http://www.convertico.com/' target='_blank'>",'</a>');

					?>
				</div>
				<div class="wizard-favico-response response-box success">
					<?php _e('The favicon updated succesfully','flotheme'); ?>
				</div>
			</div>
			<div class="delimiter"></div>

			<div class="title-label">
				<h4 class="dot"><?php _e('Select the style kit','flotheme'); ?></h4>
			</div>
			<div class="options">

				<?php

					$predefined_stylesheet = array(
		                'default' => ReduxFramework::$_url . 'assets/img/icons/stylesheet_mimal.png',
		                'style-blue.css' => ReduxFramework::$_url . 'assets/img/icons/stylesheet_mimal_blue.png',
		                'style-red.css' => ReduxFramework::$_url . 'assets/img/icons/stylesheet_mimal_red.png',
		            );


					flo_quick_setup_radio_img($predefined_stylesheet);
				?>
				<div class="wizard-style-kit-response response-box success">
					<?php _e('The stylekit was updated succesfully','flotheme'); ?>
				</div>
			</div>
		</div>

	</div>

	<div class="flo-step permalinks">
		<div class="step-title">
			<?php _e('Step 7.','flotheme'); ?>
		</div>
		<div class="title">
			<?php _e('Permalinks structure.','flotheme'); ?>
		</div>

		<span class="hint"> <?php _e('This step is optional','flotheme'); ?></span>
		<br/>
		<div class="style-options">
			<div class="title-label">
				<h4 class="permalinks-title dot"><?php _e('Enable pretty permalinks','flotheme'); ?></h4>
				<span class="hint">
					<?php _e("Set the permalinks to 'Post name' option",'flotheme');  ?>
					<br/>
					<?php
					echo sprintf(__('For more permalinks options you can go %s here %s.','flotheme'),
						'<a href="'.get_dashboard_url().'options-permalink.php" target="_blank">','</a>'
					);
				?>
				</span>
			</div>
			<div class="options">
				<input type="checkbox" name="pretty_permalinks" class="flo_pretty_permalinks" value="1">
				
			</div>
			<div class="wizard-permalinks-response response-box success">
				<?php _e('The permalinks structure was updated succesfully','flotheme'); ?>
			</div>
		</div>

	</div>
</div>