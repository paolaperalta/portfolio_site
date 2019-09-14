<?php
    class widget_socialicons extends WP_Widget {

        function __construct() {

            $widget_ops = array( 'classname' => 'flo-widget widget_socialicons' , 'description' => __( 'Social networks' , 'flotheme' ) );
            parent::__construct( 'widget_cosmo_socialicons' , _TN_ . ' : ' . __( 'Social networks' , 'flotheme' ) , $widget_ops );
        }

        function widget( $args , $instance ) {

            /* prints the widget*/
            extract($args, EXTR_SKIP);

            if( isset( $instance['title'] ) ){
                $title = $instance['title'];
            }else{
                $title = '';
            }
			echo $before_widget;

            if( !empty( $title ) ){
                echo $before_title . $title . $after_title;
            }

        ?>
        <?php
            echo '<ul class="social-links">';
	        flo_get_social_icons( flo_get_available_social_services() , false);
            echo '</ul>';
               
            echo $after_widget;
        }

        function update( $new_instance, $old_instance) {

            /*save the widget*/
            $instance = $old_instance;
            $instance['title']              = strip_tags( $new_instance['title'] );

            return $instance;
        }

        function form($instance) {

            /* widget form in backend */
            $instance       = wp_parse_args( (array) $instance, array( 'title' => '', 'only_text' => 0) );
            $title          = strip_tags( $instance['title'] );
    ?>

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','flotheme') ?>:
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
                </label>
            </p>

	        <span class="hint">
                <?php echo sprintf(__('All the social profile settings can be set %s here %s','flotheme'), '<a href="admin.php?page=_flo_options&tab=10" target="blank">','</a>' ); ?>
            </span>
			
    <?php
        }
    }
?>
