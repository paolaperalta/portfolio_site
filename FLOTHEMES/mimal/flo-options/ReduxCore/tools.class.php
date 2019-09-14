<?php
    class tools{
        static function primary_class( $post_id , $template, $return_just_class = false ){
            if($return_just_class){
                return layout::length( $post_id , $template  );
            }else{
                echo 'class="' . layout::length( $post_id , $template  ) . '"';    
            }
            
        }
        
    }
?>