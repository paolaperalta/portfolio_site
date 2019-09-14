<?php

class post {
    static $post_id = 0;
    
    function filter_where( $where = '' ) {
        global $wpdb;
        if( self::$post_id > 0 ){
            $where .= " AND  ".$wpdb->prefix."posts.ID < " . self::$post_id;
        }
        return $where;
    }
    static function search(){
        
        $query = isset( $_GET['params'] ) ? (array)json_decode( stripslashes( $_GET['params'] )) : exit;
        $query['s'] = isset( $_GET['term'] ) ? $_GET['term'] : exit;
        $query['post_type'] = isset( $_GET['params'] ) ? $_GET['params'] : exit;
        global $wp_query;
        $result = array();
        
        $wp_query = new WP_Query( $query );
        
        if( $wp_query -> have_posts() ){
           
            foreach( $wp_query -> posts as $post ){
                
                $a_json_row["suggestions"] = $post -> post_title;
                $a_json_row["data"] =  $post -> ID;
                $a_json_row["label"] = $post -> post_title;
                array_push($result, $a_json_row);
            }
        }
        
        echo json_encode( $result );
        exit();
    }
    
    

    

    
	  
        
        

                

    }
?>
