<?php
    class resources{
        static $type;
        static $labels;
        static $taxonomy;
		static $box;
        static function register(){
            global $flo_options,$reduxConfig;
            if( !empty( self::$type ) ){
                foreach( self::$type as $res => $args ){
                    if( empty( $args )  ){
                        self::box( $res );
                    }else{
                        $label = self::$labels[ $res ];
                        $args['labels'] = $label;
                        //$args['rewrite'] = array( 'slug' => $res , 'with_front' => false );
                        unset( $args['__on_front_page'] );
                        if( isset( $args['rewrite'] ) ){
                            if( isset ( $args['rewrite']['slug'] ) && ( strlen( $args['rewrite']['slug'] ) > 1 ) ){
                                $args['has_archive'] = $args['rewrite']['slug'];
                            }else{
                                $args['has_archive'] = $res;
                            }
                        }else{
                            $args['has_archive'] = $res;
                        }
                        register_post_type( $res , $args );
                        self::taxonomy( $res );
                        self::box( $res );
                    }
                }
            }
        }

		static function box( $res ){
			if( isset( self::$box[ $res ] ) ){
				foreach( self::$box[ $res ] as $box => $args ){
                    add_action('admin_init', array( get_class() , 'addbox_' . $res . '_' . $box ) , 1 );
				}
			}
		}
		//add_meta_box(	'gallery-type-div', __('Gallery Type','flotheme'),  'gallery_type_metabox', 'gallery', 'normal', 'low');

        static function taxonomy( $res ){
            if( isset( self::$taxonomy[ $res ] ) ){
                foreach( self::$taxonomy[ $res ] as $tax => $args ){
                    register_taxonomy( $res . '-' . $tax , array( $res ) , $args );
                }
            }
        }

        /* replace callStatic  with Callbox */

        static function post_layout(){
            self::CallBox( 'post_layout' );
        }

        static function  CallBox( $name , $args = null ) {
			global $post;
            $items = explode( '_' , $name );
            if( $items[0] == 'addbox' ){
                foreach( self::$box[ $items[1] ] as $box => $args ){
                    add_meta_box( $items[1] . '_' . $box , $args[0] , array( get_class() , $items[1] . '_' . $box ) , $items[1] , $args[1] , $args[2] );
                    if( isset( $_POST[ $box ] ) ){
                        if( isset( $args[ 'update' ] ) && $args[ 'update' ] ){
                            $new_value = $_POST[ $box ];
                            if( is_array( $args['content'] ) ){
                                foreach( $args['content'] as $name => $fields ){
                                    if(isset($fields['type'])){
                                        $type = explode( '--' , $fields['type'] );
                                        if( isset( $type[1] ) && $type[1] == 'checkbox' ){
                                            if( !isset( $new_value[ $name ] ) ){
                                                $new_value[ $name ] = '';
                                            }
                                        }
                                    }

                                }
                            }

                            if( isset( $_POST[ 'post_ID' ] ) ){

								$metadata=Array();

								meta::set_meta( $_POST[ 'post_ID' ] , 'format' , $metadata );
                                meta::set_meta( $_POST[ 'post_ID' ] , $box , $new_value );

                            }

                        }
                    }
                }
            }else{
                if( isset( self::$box[ $items[0] ][ $items[1] ][ 'callback' ] ) ){

                    if( self::$box[ $items[0] ][ $items[1] ][ 'callback' ][0] == 'get_meta_records' ){
                        $fn_result =  meta::get_meta_records( $post -> ID , $items );

                        if( !empty( $fn_result ) ){
                            $classes = "postbox";
                        }else{
                            $classes = '';
                        }

                        echo '<div id="box_' . $items[0] .'_'. $items[1] .'" class="' . $classes . '" >';
                        echo $fn_result;
                        echo '</div>';

                    }else{
                        $fn = self::$box[ $items[0] ][ $items[1] ][ 'callback' ][0];
                        $fn_result = $fn( $post -> ID , self::$box[ $items[0] ][ $items[1] ][ 'callback' ][1] ) ;

                        if( !empty( $fn_result ) ){
                            $classes = "postbox";
                        }else{
                            $classes = '';
                        }

                        echo '<div id="box_' . $items[0] .'_'. $items[1] .'" class="' . $classes. '" >';
                        echo $fn_result;
                        echo '</div>';

                    }

                }

                if( isset( self::$box[ $items[0] ][ $items[1] ][ 'includes' ] ) ){
                    include get_template_directory(). '/lib/php/' . self::$box[ $items[0] ][ $items[1] ][ 'includes' ];
                }

                if( isset( self::$box[ $items[0] ][ $items[1] ][ 'content' ] ) ){

                    if( isset( self::$box[ $items[0] ][ $items[1]][ 'box'  ] ) ){
                        $box = self::$box[ $items[0] ][ $items[1]][ 'box'  ];
                    }else{
                        $box = $items[1];
                    }

					echo '<div id="form' . $box . '">';


                    foreach( self::$box[ $items[0] ][ $items[1]][ 'content'  ] as $side => $field ){
                        $field['side'] 		= $side;
                        $field['box']  		= $box;
						$field['res']  		= $items[0];
						$field['post_id']  	= $post -> ID;
                        $field['pos']  		= self::$box[ $items[0] ][ $items[1]][1];

                        $meta  = meta::get_meta( $post -> ID , $box );

                        $value = isset( $meta[ $side ] ) ? $meta[ $side ] : '';

                        if( !isset( $field['value'] ) ){
                            $field['value'] = $value;
                        }

                        if( !empty( $value ) ){
                            $field['ivalue'] = $value;
                        }

                        /* special for upload-id*/
                        $type = explode( '--' , $field['type'] );
                        if( isset( $type[1] ) && $type[1] == 'upload-id' ){
                            $value_id = isset( $meta[ $side .'_id' ] ) ? $meta[ $side .'_id' ] : 0;
                            $field['value_id'] = $value_id;
                        }

                        $field['topic']  	= $side;
						$field['group']  	= $box;

                        echo fields::layout( $field );
                    }
					echo '</div>';
                }
            }
        }

        static function post_settings(){
            self::CallBox( 'post_settings' );
        }

        static function addbox_post_cosmoembed(){
            self::CallBox( 'addbox_post_cosmoembed' );
        }

        static function post_cosmoembed(){
            self::CallBox( 'post_cosmoembed' );
        }

        static function page_layout(){
            self::CallBox( 'page_layout' );
        }

        static function page_settings(){
            self::CallBox( 'page_settings' );
        }

        static function addbox_gallery_gallerytype(){
            self::CallBox( 'addbox_gallery_gallerytype' );
        }

        /*----------------------------*/

        static function gallery_gallerytype(){
            self::CallBox( 'gallery_gallerytype' );
        }

        static function addbox_page_gallerySelectSettings(){
            self::CallBox( 'addbox_page_gallerySelectSettings' );
        }
        /*----------------------------*/
        
        /*----------------------------*/

        static function page_gallerySelectSettings(){
            self::CallBox( 'page_gallerySelectSettings' );
        }
        
        static function page_blogTemplateSettings(){
            self::CallBox( 'page_blogTemplateSettings' );
        }

        static function addbox_page_blogTemplateSettings(){
            self::CallBox( 'addbox_page_blogTemplateSettings' );
        }
        
        static function page_shopTemplateSettings(){
            self::CallBox( 'page_shopTemplateSettings' );
        }
        
        static function addbox_page_shopTemplateSettings(){
            self::CallBox( 'addbox_page_shopTemplateSettings' );
        }

        static function addbox_page_galleryTemplateSettings(){
            self::CallBox( 'addbox_page_galleryTemplateSettings' );
        }
        
        static function page_galleryTemplateSettings(){
            self::CallBox( 'page_galleryTemplateSettings' );
        }

        static function addbox_page_slideshowSettings(){
            self::CallBox( 'addbox_page_slideshowSettings' );
        }

        static function page_contactFormEmail(){
            self::CallBox( 'page_contactFormEmail' );
        }
        
        static function addbox_page_contactFormEmail(){
            self::CallBox( 'addbox_page_contactFormEmail' );
        }

        static function page_slideshowSettings(){
            self::CallBox( 'page_slideshowSettings' );
        }

        static function addbox_post_layout(){
            self::CallBox( 'addbox_post_layout' );
        }

        static function addbox_post_settings(){
            self::CallBox( 'addbox_post_settings' );
        }

        static function addbox_page_layout(){
            self::CallBox( 'addbox_page_layout' );
        }

        /*slideshow*/

        static function addbox_page_settings(){
            self::CallBox( 'addbox_page_settings' );
        }

        static function slideshow_box(){
            self::CallBox( 'slideshow_box' );
        }

        static function slideshow_slidesettings(){
            self::CallBox( 'slideshow_slidesettings' );
        }

	    static function slideshow_slidesettings_orientation(){
		    self::CallBox( 'slideshow_slidesettings_orientation' );
	    }

        static function addbox_slideshow_box(){
            self::CallBox( 'addbox_slideshow_box' );
        }

        static function addbox_slideshow_slidesettings(){
            self::CallBox( 'addbox_slideshow_settings' );
        }

        /*mosaic meta boxes*/
        
	    static function addbox_slideshow_slidesettings_orientation(){
            self::CallBox( 'addbox_slideshow_slidesettings_orientation' );
        }
        
        static function flobanner_bannerSettings(){
            self::CallBox( 'flobanner_bannerSettings' );
        }

        static function addbox_flobanner_box(){
            self::CallBox( 'addbox_flobanner_box' );
        }

        static function addbox_flobanner_bannerSettings(){
            self::CallBox( 'addbox_flobanner_bannerSettings' );
        }
    }
?>
