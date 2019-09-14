<?php
    class options{
		static $menu;
		static $register;
		static $default;
		static $fields;

        static function menu( ){

            if( is_array( self::$menu ) && !empty( self::$menu) ){
                

                foreach( self::$menu as $main => $items ){
                    
                    foreach( $items as $slug => $item ){
                        
                        switch( $main ){ 
                            default :{
								if( isset( $item['type'] ) ){
									if( $item['type'] == 'main' ){
										add_menu_page( $item['main_label'] , 'Flotheme' , 'administrator' , $main . '__' . $slug  , array( get_class() , $main . '__' . $slug ) , get_template_directory_uri() . '/lib/images/flothemes.ico' );
                                        
                                        //call_user_func_array( get_class() . '::' . $main . '__' . $slug, array_slice( array( 'name' , 'arguments' ) , 0, (int) 2 ) );
										$main_slug =  $main . '__' . $slug;
									}else{
                                        add_submenu_page( $main_slug , $item['label'] , $item['label'] , 'administrator' , $main . '__' . $slug , array( get_class() , $main . '__' . $slug )  );
									}
								}else{ 
                                    add_submenu_page( $main_slug , $item['label'] , $item['label'] , 'administrator' , $main . '__' . $slug , array( get_class() , $main . '__' . $slug )  );
								}
                                break;
                            }
                        }
                    }
                }
            }
        }

        static function flothemes__general(){
            self::CallMenu( 'flothemes__general' );
        }

        static function CallMenu( $name ) {

            $slug           = $name;
            $items 			= explode( '__' , $slug );

            if( !isset( $items[1] ) ){
                exit();
            }

            $label          = isset( self::$menu[ $items[0] ][$items[1]]['label'] ) ? self::$menu[ $items[0] ][$items[1]]['label'] : '';
            $title          = isset( self::$menu[ $items[0] ][$items[1]]['title'] ) ? self::$menu[ $items[0] ][$items[1]]['title'] : '';
            $description    = isset( self::$menu[ $items[0] ][$items[1]]['desctiption'] ) ? self::$menu[ $items[0] ][$items[1]]['desctiption'] : '';
            $help_link_title    = isset( self::$menu[ $items[0] ][$items[1]]['help_link_title'] ) ? self::$menu[ $items[0] ][$items[1]]['help_link_title'] : '';
            $help_link    = isset( self::$menu[ $items[0] ][$items[1]]['help_link'] ) ? self::$menu[ $items[0] ][$items[1]]['help_link'] : '';
            $help_link_icon_class = isset( self::$menu[ $items[0] ][$items[1]]['help_link_icon_class'] ) ? self::$menu[ $items[0] ][$items[1]]['help_link_icon_class'] : '';

            $update         = isset( self::$menu[ $items[0] ][$items[1]]['update'] ) ? self::$menu[ $items[0] ][$items[1]]['update'] : true ;

            includes::load_css(  );
            includes::load_js(  );
            echo '<div class="admin-page clearfix">';
            self::get_header( $items[0] , $items[1] );
            self::get_page( $title , $slug , $description , $update , $help_link_title, $help_link , $help_link_icon_class);
            echo '</div>';
        }

		static function get_header( $item , $current ){
			$result = '';
            $menu = self::$menu[ $item ];

			if(BRAND == ''){
				$brand_logo = get_template_directory_uri().'/images/flothemes-medium-white.png';
			}else{
				$brand_logo = get_template_directory_uri().'/images/flothemes.png';
			}

			$ct = wp_get_theme();

			$result .= '<div class="mythemes-intro">';
            $result .= '<img src="'.$brand_logo.'" />';
			$result .= '<span class="theme">'.$ct->title.' '.__('version' , 'flotheme').': '.$ct->version.'</span>';
            $result .= '</div>';

			if( is_array( $menu ) ){
                $result .= '<div class="div-table"><div class="div-row">'; // These two divs are closed in get_page() function.
				$result .= '<div class="admin-menu">';
				$result .= '<ul>';
				foreach( $menu as $slug => $info){
                    $result .= '<li '. self::get_class( $slug , $current ) .'><a href="' . self::get_path( $item . '__' . $slug ) . '">' . get_item_label( $info['label'] ) . '</a></li>';
				}
				$result .= '</ul>';
				$result .= '</div>';
			}

            echo $result;
		}

        static function get_class( $slug , $current ){

            if( $current == $slug ){
                if( substr( $slug , 0 , 1 ) == '_' ){
                    $slug = substr( $slug , 1 , strlen( $slug ) );
                }

                $slug = str_replace( '_' , '-' , $slug  );

                if($slug == 'advertisement'){
                    $slug = 'cosmo-pub';
                }
                return 'class="current ' . $slug . '"';
            }else{
                if( substr( $slug , 0 , 1 ) == '_' ){
                    $slug = substr( $slug , 1 , strlen( $slug ) );
                }

                $slug = str_replace( '_' , '-' , $slug  );

                if($slug == 'advertisement'){
                    $slug = 'cosmo-pub';
                }
                return ' class="' . $slug . '"';
            }

        }

        static function get_path( $slug ){
            $path = '?page=' . $slug;
            return $path;
        }

        static function get_page( $title , $slug ,  $description = '' , $update = true , $help_link_title, $help_link, $help_link_icon_class){
?>
            <div class="admin-content">
<?php
                if(isset($_GET['settings-updated']) && $_GET['settings-updated'] = 'true'){
?>

                    <div id="message" class="updated">
                        <p><strong><?php _e('Settings saved.','flotheme') ?></strong></p>
                    </div>
<?php
                }
?>
                <div class="title">
                    <h2>
                        <?php
                            echo $title;

                            if(isset($help_link_title) && strlen($help_link_title)){

                                if(isset($help_link) && strlen($help_link)){
                                    echo '<span class="link_title "><i class="'.$help_link_icon_class.' " ></i><a href="'.$help_link.' " target="_blank" >'.$help_link_title.'</a></span>';
                                }else{
                                    echo '<span class="link_title "><i class="'.$help_link_icon_class.' "> </i>'.$help_link_title.'</span>';
                                }

                            }
                        ?>

                    </h2>
                    <?php
                        if( strlen( $description ) ){
                    ?>
                            <p><?php echo $description; ?></p>
                    <?php
                        }
                    ?>
                </div>

            <?php
                if( $update ){
            ?>
                    <form action="options.php" method="post">
            <?php

                }
                        settings_fields( $slug );
						$items = explode( '__' , $slug );

                        echo self::get_fields( $items[1] );
                if( $update ){
            ?>
                        <div class="standard-generic-field submit">
                            <div class="field">
                                <input type="button" class=" button-primary reset-cosmo-options left" value="<?php _e('Options reset','flotheme'); ?>" />
                                <input type="submit" value="<?php _e( 'Update Settings' , 'flotheme' ); ?>" class="right" />
                            </div>
                            <div class="options-reset-msg-div">
                                <p class="cosmo-box tick hidden1 options-reset-msg" style="margin-left: 0px;"><span class="cosmo-ico"></span><?php _e('Options reset','flotheme'); ?></p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </form>
            <?php
                }else{
            ?>
                    <div class="record submit"></div>
            <?php
                }
            ?>
			</div>
            </div> <!-- end .div-table --> <?php //THIS DIV IS OPENED FROM get_header() function ?>
            </div> <!-- end .div-row --> <?php //THIS DIV IS OPENED FROM get_header() function ?>
<?php
        }

        static function get_fields( $group ){
            $result = '';
            if( isset( self::$fields[ $group ] ) ){
                foreach( self::$fields[ $group ] as $side => $field ){
                    if(is_array($field)){
                        $field['topic'] = $side;
                        $field['group'] = $group;
                        if( !isset( $field['value'] ) ){
                            $field['value'] = self::get_value( $group , $side );
                        }

                        $field['ivalue'] = self::get_value( $group , $side );
                    }
                    /* special for upload-id*/
                    if( isset( $field['type'] ) ){
                        $type = explode( '--' , $field['type'] );
                        if( isset( $type[1] ) && $type[1] == 'upload-id' ){
							$option = self::get_value( $group );
                            $value_id = isset( $option[ $side .'_id' ] ) ? $option[ $side .'_id' ] : 0;
                            $field['value_id'] = $value_id;
                        }
                    }

                    $result .= fields::layout( $field );
                }
            }

            return $result;
        }

        static function get_value( $group , $side = null , $id = null){
            $g = $group;
            $s = $side;
            $i = $id;

            $v = @get_option( $g );
            if( is_array( $v ) ){
                if( strlen( $s ) ){
                    if( isset( $v[ $s ] ) ){
                        if( is_int( $i ) ){
                            if( isset( $v[ $s ][ $i ] ) ){
                                return $v[ $s ][ $i ];
                            }else{
                                if( isset( options::$default[ $g ][ $s ][ $i ] )){
                                    return options::$default[ $g ][ $s ][ $i ];
                                }else{
                                    return '';
                                }
                            }
                        }else{
                            return $v[ $s ];
                        }
                    }else{
                        if( isset( options::$default[ $g ][ $s ])){
                            return options::$default[ $g ][ $s ];
                        }else{
                            return '';
                        }
                    }
                }else{
                    return $v;
                }
            }else{
                if( strlen( $s ) ){
                    if( isset( options::$default[ $g ][ $s ] ) ){
                        if( is_int( $i ) ){
                            if( isset( options::$default[ $g ][ $s ][ $i ] ) ){
                                return options::$default[ $g ][ $s ][ $i ];
                            }else{
                                return '';
                            }
                        }else{
                            return options::$default[ $g ][ $s ];
                        }
                    }else{
                        return '';
                    }
                }else{
                    if( isset( options::$default[ $g ])){
                        return options::$default[ $g ];
                    }else{
                        return '';
                    }
                }
            }
        }

        static function flothemes__home_page(){
            self::CallMenu( 'flothemes__home_page' );
        }

        static function flothemes__layout(){
            self::CallMenu( 'flothemes__layout' );
        }

        static function flothemes__sliders(){
            self::CallMenu( 'flothemes__sliders' );
        }
        
        static function flothemes__styling(){
            self::CallMenu( 'flothemes__styling' );
        }

        static function flothemes__typography(){
            self::CallMenu( 'flothemes__typography' );
        }

        static function flothemes__colors(){
            self::CallMenu( 'flothemes__colors' );
        }

        static function flothemes__imagesizes(){
            self::CallMenu( 'flothemes__imagesizes' );
        }

        static function flothemes__likes(){
            self::CallMenu( 'flothemes__likes' );
        }

        static function flothemes__conference(){
            self::CallMenu( 'flothemes__conference' );
        }

        static function flothemes__labels(){
            self::CallMenu( 'flothemes__labels' );
        }

        static function flothemes__header_settings(){
            self::CallMenu( 'flothemes__header_settings' );
        }
		
        static function flothemes__content_settings(){
            self::CallMenu( 'flothemes__content_settings' );
        }

        static function flothemes__blog_post(){
            self::CallMenu( 'flothemes__blog_post' );
        }

        static function flothemes__footer_settings(){
            self::CallMenu( 'flothemes__footer_settings' );
        }

        static function flothemes__advertisement(){
            self::CallMenu( 'flothemes__advertisement' );
        }

        static function flothemes__social(){
            self::CallMenu( 'flothemes__social' );
        }
		  
        static function flothemes___social(){
            self::CallMenu( 'flothemes___social' );
        }

        static function flothemes__slider(){
            self::CallMenu( 'flothemes__slider' );
        }
        
		static function flothemes__upload(){
            self::CallMenu( 'flothemes__upload' );
        }

        static function flothemes___sidebar(){
            self::CallMenu( 'flothemes___sidebar' );
        }

        static function flothemes___customfonts(){
            self::CallMenu( 'flothemes___customfonts' );
        }

        static function flothemes__custom_css(){
            self::CallMenu( 'flothemes__custom_css' );
        }

        static function flothemes__stylos(){
            self::CallMenu( 'flothemes__stylos' );
        }

		static function flothemes__flothemes(){
            self::CallMenu( 'flothemes__flothemes' );
        }

        static function flothemes__io(){
            self::CallMenu( 'flothemes__io' );
        }

        static function register( ){
            if( is_array( self::$register ) && !empty( self::$register ) ){
                foreach( self::$register as $page => $groups ){
                    if( is_array( $groups ) && !empty( $groups ) ){
                        foreach( $groups as $group => $side ){
                            if( substr( $group , 0 , 1 ) != '_'){
                                register_setting( $page . '__' . $group , $group );
                            }
                        }
                    }
                }
            }
        }

        static function box(){
            if( is_array( self::$menu ) && !empty( self::$menu ) ){
                foreach( self::$menu  as $key => $value ){
                    switch( count( $value )  ){
                        case 7 : {
                            $value[0]( $value[1] , $value[2] , $value[3] , $value[4] , $value[5] , $value[6] );
                            break;
                        }
                    }
                }
            }
        }

        static function get_digit_array( $to , $from = 0 , $twodigit = false ){
            $result = array();
            for( $i = $from; $i < $to + 1; $i ++ ){
                if( $twodigit ){
                    $i = (string)$i;
                    if( strlen( $i ) == 1 ){
                        $i = '0' . $i;
                    }
                    $result[$i] = $i;
                }else{
                    $result[$i] = $i;
                }
            }

            return $result;
        }

        static function logic( $group , $side = null , $id = null ){
 
            $values = self::get_value( $group , $side , $id );
            if( !is_array( $values ) ){
                if( $values == 'yes' ){
                    return  true;
                }

                if( $values == 'no' ){
                    return false;
                }
            }

            return $values;
        }
        
    
    }



?>