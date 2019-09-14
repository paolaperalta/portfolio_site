<?php
    class fields {

        //public $help_img_path = get_template_directory_uri().'/lib/images/help-lightbox/';   // use this when images are stored in the theme
        public $help_img_path = 'http://flothemes.com/wp-content/uploads/dashboard-images/fiji/'; // use this when images are stored externaly


            
        static function layout( $field ){
            /* return field attributes */
            if( !is_array( $field ) || empty( $field ) ){
                return '';
            }

            foreach( $field as $attribut => $attribut_value ){
                $$attribut = $attribut_value;
            }

            /* if no specified type */
            if( !isset( $type ) ){
                return '';
            }

            /* return layout type from field type */
            $field_side = explode( '--' ,  $type );
            $layout_type = $field_side[ 0 ];

            /* generate label for field with $id */
            $field_id = isset( $id ) && strlen( $id ) ? $id  : '';

            $id = strlen( $field_id ) ? 'id="' . $field_id . '"' : '';

            $label_id = strlen( $field_id ) ? 'for="' . $field_id . '"' : '';
            if( (isset( $help_img) && strlen($help_img)) || (isset($doc_hint) && is_array($doc_hint) ) ){
                //add_thickbox();
                $hint_id = mt_rand(0,99999);
                if( isset($help_img) && strlen($help_img) ){

                    $obj = new fields();

                    $img_url = $obj->help_img_path . $help_img; 

                    $help_img_content = '<a href="'.$img_url.'" data-fancybox-group="prettyPhoto_'.$hint_id.'" title="'.__('See how it looks on the site','flotheme').'" class="img-lightbox-hint" target="_blank">
                                            <span class="dashicons dashicons-editor-help"></span>
                                        </a>';
                }else{
                    $help_img_content = '';
                }

                if(isset($doc_hint) && is_array($doc_hint) ){
                    // FOR link to simple documentation use this class : 'dashicons dashicons-admin-page'
                    // FOR link to Video documentation use this class : 'dashicons dashicons-video-alt3'    

                    /*
                        $doc_hint is an array in the following format:
                        
                        'doc_hint' => array(
                                        'doc_hint_url' => 'https://flothemes.zendesk.com/hc/en-us',    // this is the link to the docs or video
                                        'doc_hint_class' => 'dashicons dashicons-admin-page',  // this is the dashicon class ('dashicons dashicons-admin-page'  OR 'dashicons dashicons-video-alt3' )
                            )
                    */
                    $doc_hint_content = '<a href="'.$doc_hint['doc_hint_url'].'" target="_blank">
                                            <span class="'.$doc_hint['doc_hint_class'].'"></span>
                                        </a>';
                }else{
                    $doc_hint_content = '';
                }


                if(isset($doc_iframe) && is_array($doc_iframe)){

                    // For playing video in a iframe

                    /*
                    'doc_iframe' => array(
                                'iframe_url' => 'http://www.youtube.com/embed/eM8Ss28zjcE?autoplay=1',    // this is the link to the youtube embed  i.e. http://www.youtube.com/embed/eM8Ss28zjcE?autoplay=1
                                'doc_iframe_class' => 'dashicons dashicons-video-alt3',  // this is the dashicon class 
                    )
                    */
                    $doc_iframe_content = '<a href="'.$doc_iframe['iframe_url'].'" data-fancybox-type="iframe" class="img-lightbox-hint">
                                                <span class="'.$doc_iframe['doc_iframe_class'].'"></span>
                                            </a>';
                    
                }else{
                    $doc_iframe_content = '';
                }
                
                $img_hint = '<span class="flo-help-icons">
                                ' . $help_img_content . $doc_hint_content . $doc_iframe_content .'
                            </span>';
            }else{
                $img_hint = '';
            }
            $label = isset( $label ) ? '<h3 ' . $label_id . '>' . $label .'</h3>' : '';

            $group = isset( $group ) ? $group : '';
            $topic = isset( $topic ) ? $topic : '';
            $index = isset( $index ) ? $index : '';

            $id     = isset( $id ) ? 'id="' . $id . '"' : '';

            $cid    = isset( $cid ) ? 'id="'.$cid.'"' : '';

            $hc     = isset( $hclass ) ? $hclass : '';
            $hint   = isset( $hint ) ? '<div class="generic-hint ' . $hc . '">' . $hint . '</div>': '' ;
            $help   = isset( $help ) ? '<span class="generic-help" ' .  self::action( $help )  . '></span>': '' ;
   
            $classes = isset( $classes ) ? $classes : '';

            /* reset field type */
            $field['type'] = $field_side[ 1 ];

            $field_type    = str_replace( 'm-' , '' , $field_side[ 1 ] );

            $result = '';

            
            switch ($field['type']) {
                case 'title':
                    $filed_type_class = ' standard-generic-title ';       
                    break;
                case 'delimiter':
                    $filed_type_class = ' standard-generic-delimiter ';       
                    break;
                default:
                    $filed_type_class = ' ';
                    break;
            }
            switch( $layout_type ){
                /*
                    fields layout type
                    --------------------------------------------------
                    cd--*   - HTML Code
                    no--*   - not use layout
                    ni--*   - not input type
                    st--*   - sdandard layout
                    sh--*   - short layoutsult .
                    ln--*   - in line layout

                    * - field type
                 */

                /* code type layout */
                case 'cd' : {
                    $result .= $content;
                    break;
                }
                /* without layout  */
                case 'no'  :{
                    $result .= self::field( $field );
                    break;
                }
                /* not input type  */
                case 'ni' : {
                    $result .= '<div class="standard-generic-field generic-field-' . $group . ' ' . $classes . $filed_type_class . '">';
                    $result .= $img_hint;
                    $result .= '<div class="generic-field full" ' . $cid . '>' . self::field( $field ) . $help . '</div>';
                    $result .= $hint;
                    $result .= '<div class="clear"></div>';
                    $result .= '</div>';
                    break;
                }
                /* standard layout  */
                case 'st' : {
                    
                    $result .= '<div class="standard-generic-field generic-field-' . $group . ' ' . $classes . $filed_type_class . '">';
                    $result .= $img_hint;
                    $result .= '<div class="generic-label">'. $label .'</div>';
                    $result .= '<div class="generic-field generic-field-' . $field_type  . '" ' . $cid . '>' . self::field( $field ) . $help . '</div>';
                    $result .= $hint;
                    $result .= '<div class="clear"></div>';
                    $result .= '</div>';
                    break;
                }
                /* short layout */
                case 'sh' : {
                    $result .= '<div class="short-generic-field generic-field-' . $group . ' ' . $classes . $filed_type_class .'">';
                    $result .= '<div class="generic-label">'. $label .'</div>';
                    $result .= '<div class="generic-field generic-field-' . $field_type  . '" ' . $cid . '>' . self::field( $field ) . $help . $hint . '</div>';
                    $result .= '</div>';
                    break;
                }
                /* in line layout */
                case 'ln' : {
                    $result .= '<span class="inline-generic-field generic-field-' . $group . ' ' . $classes . $filed_type_class .'">';
                    $result .= '<span class="generic-label">'. $label .'</span>';
                    $result .= '<span class="generic-field generic-field-' . $field_type  . '" ' . $cid . '>' . self::field( $field ) . $help . $hint . '</span>';
                    $result .= '</span>';
                    break;
                }

                case 'ex' : {
                    $result .= '<div class="extra-generic-group extra-generic-' . $group . '" ' . $cid . '>';
                    $result .= extra::get( $group );
                    $result .= '</div>';
                    break;
                }
            }

            return $result;
        }

        static function action( $action , $type ){

            if( empty( $action ) ){
                return '';
            }

            $result = '';
            switch( $type ){
                case 'text' : {
                    $result = 'onkeyup="javascript:' . $action . ';"';
                    break;
                }
                case 'radio-icon' : {
                    $result = 'onclick="javascript:act.radio_icon(\'' . $action['group'] . '\' , \'' . $action['topic'] . '\' ,  \'' . $action['index'] . '\' );"';
                    break;
                }
                case 'textarea' : {
                    $result = 'onkeyup="javascript:' . $action . ';"';
                    break;
                }
                case 'radio' : {
                    $result = 'onclick="javascript:' . $action . ';"';
                    break;
                }
                case 'checkbox' : {
                    $result = 'onclick="javascript:' . $action . ';"';
                    break;
                }

                case 'search' : {
                    $result = 'onchange="javascript:' . $action . ';"';
                    break;
                }
                case 'select' : {
                    $result = 'onchange="javascript:' . $action . ';"';
                    break;
                }
                case 'logic-radio' : {
                    $result = 'onclick="javascript:' . $action . ';"';
                    break;
                }
                case 'm-select' : {
                    $result = 'onchange="javascript:' . $action . ';"';
                    break;
                }
                case 'button' : {
                    $result = 'onclick="javascript:' . $action . ';"';
                    break;
                }
                case 'digit-like' : {
                    $result = 'onclick="javascript:' . $action . ';"';
                    break;
                }
                case 'meta-save' : {
                    $result = 'onclick="javascript:meta.save(\'' . $action['res'] . '\' , \'' . $action['group'] . '\' , '.$action['post_id'].' , \''.$action['selector'].'\' );meta.clear(\'.generic-' . $action['group'] . '\');"';
                    break;
                }
                case 'attach' : {
                    $result = 'onclick="javascript:meta.save_data(\'' . $action['res'] . '\' , \'' . $action['group'] . '\' , extra.val(\''.$action['attach_selector'].'\') , [ { \'name\' : \''.$action['group'].'[idrecord][]\' , \'value\' : ' . $action['post_id'] . ' }] , \''.$action['selector'].'\' );"';
                    break;
                }
                case 'upload' : {
                    $result = 'onclick="javascript:act.upload(\'input#' . $action . '\' );"';
                    break;
                }
                case 'generate' : {
                    $result = 'onclick="javascript:act.generate( \'' . $action . '\' );"';
                    break;
                }
                case 'upload-id' : {
					if(isset($action['upload_url']) && $action['upload_url'] != ''){
						$upload_url =  $action['upload_url'];
					}else{
						$upload_url =  '';
					}
                    $result = 'onclick="javascript:act.upload_id(\'' . $action['group'] . '\' , \'' . $action['topic'] . '\' , \''.$action['index'].'\',\''.$upload_url.'\' );"';
                    break;
                }

                case 'extern-upload-id' : {
					if(isset($action['upload_url']) && $action['upload_url'] != ''){
						$upload_url =  $action['upload_url'];
					}else{
						$upload_url =  '';
					}
                    $result = 'onclick="javascript:act.extern_upload_id(\'' . $action['group'] . '\' , \'' . $action['topic'] . '\' , \''.$action['index'].'\',\''.$upload_url.'\' );"';
                    break;
                }

			  case "":
			  break;
            }

            return $result;
        }

        static function field( $field ){
            /* return field attributes */
            foreach( $field as $attribut => $attribut_value ){
                $$attribut =  $attribut_value;
            }

            $name       = isset( $single ) ?  $topic : $group . '[' . $topic . ']';
            $name_id    = isset( $single ) ?  $topic . '_id' : $group . '[' . $topic . '_id]';
            $iname      = isset( $topic ) ? $topic : '';
            $classes    = isset( $iclasses ) ? $iclasses  : '';
            $field_id   = isset( $id ) ? $id  : '';

            $id         = strlen( $field_id ) ? 'id="' . $field_id . '"' : '';
            $result_id  = strlen( $field_id ) ? 'id="' . $field_id . '_result"' : '';

            $group = isset( $group ) ? $group : '';
            $topic = isset( $topic ) ? $topic : '';
            $index = isset( $index ) ? $index : '';

            /* field classes */
            $fclasses   = 'generic-' . $group . ' generic-' . $topic . ' ' . $group . '-' . $topic . ' ' . $group . '-' . $topic . '-' . $index;

            $action = isset( $action ) ? $action : '';

            $result = '';

            switch( $type  ){
                /* no input type */
                case 'delimiter' : {
                    $result .= '<hr>';
                    break;
                }
                case 'title' : {
	                $obj = new fields();
                    if(isset($title)){
                        if(isset($help_img) && strlen($help_img)){
                            $hint_id = mt_rand(0,99999);
                            $img_hint = '<span class="flo-help-icons">
                                            <a href="'.$obj->help_img_path.'/'.$help_img.'" data-fancybox-group="prettyPhoto_'.$hint_id.'" class="img-lightbox-hint">
                                                <span class="icon-help-circled"></span>
                                            </a>
                                        </span>';

                        }else{
                            $img_hint = '';
                        }

                        $result .= '<h3 class="generic-record-title '  . $fclasses .  '" >' . $title . '</h3>';
                    }

                    break;
                }
                case 'import_demo' : {
                    $result .= '<input type="button" class="import-demo-content generic-record-button  button-primary  " value="'.__('Import dummy data', 'flotheme').'" onclick="importDummyData();"> <div class="spinner-container"><span class="spinner import-demo-spinner" ></span></div><div class="import-response">'.__('Please be patient, the process may take some time.','flotheme').'</div>';
                    $result .= '<div class="import-warning" style="margin-top: 10px;">'.__('Before importing Dummy Data (demo content and settings) you must be aware that if you have an existing site, it will overwrite your current settings.','flotheme').'</div>';

                    break;
                }
                case 'hint' : {
                    $result .= $value;
                    break;
                }
                case 'preview' : {
                    $result .= $content;
                    break;
                }
                case 'image' : {
                    $width  .= isset( $width ) ? ' width="' . $width . '" ' : '';
                    $heigt  .= isset( $heigt ) ? ' height="' . $height . '" ' : '';
                    $result .= '<div class="generic-record-icon '  . $fclasses .  '" ><img src="' . $src  . '" ' . $width . $height . ' class="generic-record  '  . $fclasses .  '"/></div>';
                    break;
                }

                case 'color-picker' : {
                    /*if hte value is not set yet and the ivalue (initial value) is set, then the ivalue will be used as default value*/
                    if(!(strlen(trim($value))) && isset($ivalue)){
                        $value = $ivalue;
                    }

                    $result .= '<input type="text" name="' . $name . '" value="' .  $value . '" class="generic-record settings-color-field '  . $fclasses .  ' ' . $classes . '" />';
                    break;
                }

                case 'm-color-picker' : {
                    $result .= '<input type="text" name="' . $name . '[]" value="' .  $value . '" class="generic-record settings-color-field '  . $fclasses .  ' ' . $classes . '" />';
                    break;
                }

                case 'extra' : {
                    $result .= '<div id="container_' . $group . '">' . extra::get( $group ) . '</div>';
                    break;
                }

                case 'post-upload' : {
                    $result .= '<a class="thickbox" href="media-upload.php?post_id=' . $post_id  . '&type=image&TB_iframe=1&width=640&height=381">' . $title . '</a>';
                    break;
                }

				case 'link' : {
                    $result .= '<a href="' . $url  . '">' . $title . '</a>';
                    break;
                }

                case 'callback' : {
                    $result .= '<span ' . $id . '> -- </span>';
                    break;
                }

                case 'slider' :{
                    $result .= '<div class="fvisible field">';

                    $result .= '<div  class="input">';
                    $result .= '<input  type="hidden" id="' . $id . '" class="slider_value '.$classes.'" name="' . $name . '" value="' . stripslashes( $value ) . '" />';
                    $result .= '<div class="ui_slider" data-val="'.stripslashes( $value ).'" data-min="1" data-max="100" ></div> <span class="slider_val" >'.stripslashes( $value ).'</span>';

                    // if(isset($hint)){
                    //     $result .= '<span class="hint">'.$hint.'</span>';
                    // }
                    $result .= '</div>';
                    $result .= '<div class="clear"></div>';
                    $result .= '</div>';
                    $result .= '<script>init_ui_slider(\'.ui_slider\');</script>';

                    break;
                }

                case 'radio-icon' : {
                    if( is_array( $value ) && !empty( $value ) ){
                        $path   = isset( $path ) ? $path : '';
                        $in_row = isset( $in_row ) ? $in_row : 8;
                        $i = 0; //deb::e($action_show);
                        foreach( $value  as $index => $icon ){
                            if( $i == 0 ){
                                $result .= '<div>';
                            }
                                if( isset( $ivalue ) &&  $ivalue ==  $index ){
                                        $s = 'checked="checked"';
                                        $sclasses = 'selected';
                                }else{
                                        $s = '';
                                        $sclasses = '';
                                }
                                $action1['group'] = $group;
                                $action1['topic'] = $topic;
                                $action1['index'] = $index;

                                $data_show = '';
                                $data_hide = ''; //deb::e($icon);
                                if(isset($action_show) && isset($action_show[$index])){
                                    $data_show = " data-show='". $action_show[$index] ."' "; // the classes of the elements we want to show when this elem is selected
                                }

                                if(isset($action_hide) && isset($action_hide[$index])){
                                    $data_hide = " data-hide='". $action_hide[$index] ."' "; // the classes of the elements we want to hide when this elem is selected
                                }

                                $result .= '<div class="generic-input-radio-icon ' . $index . ' hidden">';
                                $result .= '<input type="radio" value="'. $index . '" '.$data_show.' '.$data_hide.' name="' . $name . '" ' . self::action( $action, 'logic-radio' ) . ' class="generic-record radio-icon-input  hidden ' . $fclasses . $index. ' ' . $classes . '" ' . $id . ' ' . $s . '>';
                                $result .= '</div>';
                                $result .= '<img ' . self::action( $action1, 'radio-icon' ) . ' title="' . $index . '" class="pattern-texture '. $sclasses . ' ' . $fclasses . $index. '" alt="' . $icon . '" src="' . get_template_directory_uri() . '/flo-options/ReduxCore/assets/img/' . $path . $icon . '" />';
                            $i++;
                            if( $i % $in_row == 0 ){
                                $i = 0;
                                $result .='<div class="clear"></div></div>';
                            }
                        }

                        if( $i % $in_row != 0){
                            $result .='<div class="clear"></div></div>';
                        }
                    }
                    break;
                }
                case 'logic-radio' : {
                    if( $value == 'yes' ){
                        $c1 = 'checked="checked"';
                        $c2 = '';
                    }else{
                        if( $value == 'no' ){
                            $c1 = '';
                            $c2 = 'checked="checked"';
                        }else{
                            if( isset( $cvalue ) ){
                                if( $cvalue == 'yes' ){
                                    $c1 = 'checked="checked"';
                                    $c2 = '';
                                }else{
                                    $c1 = '';
                                    $c2 = 'checked="checked"';
                                }
                            }else{
                                $c1 = '';
                                $c2 = 'checked="checked"';
                            }
                        }
                    }

                    $result  = '<input type="radio" value="yes" name="' . $name . '" class="generic-record  '  . $fclasses .  ' ' . $classes . ' yes" ' . $id . ' ' . $c1 . ' ' . self::action( $action , 'logic-radio' ) . ' /> ' . __( 'Yes' , 'flotheme' ) . '&nbsp;&nbsp;&nbsp;';
                    $result .= '<input type="radio" value="no" name="' . $name . '" class="generic-record  '  . $fclasses .  ' ' . $classes . ' no" ' . $id . ' ' . $c2 . ' ' . self::action( $action , 'logic-radio' ) . ' /> ' . __( 'No' , 'flotheme' );
                    break;
                }

                case 'label-logic-radio' : {
                    if( $value == 'yes' ){
                        $c1 = 'checked="checked"';
                        $c2 = '';
                    }else{
                        if( $value == 'no' ){
                            $c1 = '';
                            $c2 = 'checked="checked"';
                        }else{
                            if( isset( $cvalue ) ){
                                if( $cvalue == 'yes' ){
                                    $c1 = 'checked="checked"';
                                    $c2 = '';
                                }else{
                                    $c1 = '';
                                    $c2 = 'checked="checked"';
                                }
                            }else{
                                $c1 = '';
                                $c2 = 'checked="checked"';
                            }
                        }
                    }

                    $result  = '<input type="radio" value="yes" name="' . $name . '" class="generic-record  '  . $fclasses .  ' ' . $classes . ' yes" ' . $id . ' ' . $c1 . ' ' . self::action( $action , 'logic-radio' ) . ' /> ' . $rlabel[0] . '&nbsp;&nbsp;&nbsp;';
                    $result .= '<input type="radio" value="no" name="' . $name . '" class="generic-record  '  . $fclasses .  ' ' . $classes . ' no" ' . $id . ' ' . $c2 . ' ' . self::action( $action , 'logic-radio' ) . ' /> ' . $rlabel[1];
                    break;
                }

//                case 'mosaic' : {
//                    $result = flo_get_mosaic_settings_box($number_blocks,$block_class);
//                    break;
//                }

                /* single type records */
                case 'hidden' : {
                    $result .= '<input type="hidden" name="' . $name . '" value="' . $value . '" class="generic-record  '  . $fclasses .  ' ' . $classes . '" ' . $id . '  />';
                    break;
                }
                case 'text' : {
                    $result .= '<input type="text" name="' . $name . '" value="' . $value . '" class="generic-record  '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'text' ) . ' />';
                    break;
                }
                case 'digit' : {
                    if( ( isset( $cvalue) && is_numeric( $cvalue ) ) && ( !isset( $value ) || !is_numeric( $value ) ) ){
                        $val = $cvalue;
                    }else{
                        $val = $value;
                    }
                    $result .= '<input type="text" name="' . $name . '" value="' . $val . '" class="generic-record  digit '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'text' ) . ' />';
                    break;
                }

                case 'digit-like' : {
                    $result .= '<input type="text" name="' . $name . '" value="' . $value . '" class="generic-record  digit like '  . $fclasses .  ' ' . $classes . '" ' . $id . ' />';
                    $result .= '<input type="button" name="' . $name . '" value="' . __( 'Reset Value' , 'flotheme' ) . '" class="generic-record-button  button-primary" ' . self::action( $action , 'digit-like' ) . ' /> <span class="digit-btn result"></span>';
                    break;
                }

                case 'textarea' : {
                    $result .= '<textarea name="' . $name . '" class="generic-record  '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'textarea' ) . '>' . $value . '</textarea>';
                    break;
                }

                case 'radio' : {
                    if( isset( $iname ) && $iname == $value ){
                        $status = ' checked="checked" ' ;
                    }else{
                        $status = '' ;
                    }

                    $name = isset( $single ) ? $iname : $group . '[' . $iname . ']';

                    $result .= '<input type="radio" name="' . $name . '" value="' . $value . '"  ' . $status . ' class="generic-record  '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'radio' ) . ' />';
                    break;
                }

                case 'search' : {
                    if( !empty( $value ) && (int)$value > 0 ){
                        $p = get_post( $value );
                        $title = $p -> post_title;
                        $post_id = $p -> ID;
                    }else{
                        $title = '';
                        $post_id = '';
                    }

                    $result .= '<input type="text" class="generic-record-search" value="' . $title . '" ' . self::action( $action , 'search' ) . '>';
                    $result .= '<input type="hidden" name="' . $name . '" class="generic-record generic-value  '  . $fclasses .  ' ' . $classes . '" ' . $id . ' value="' . $post_id . '" />';
                    $result .= '<input type="hidden" class="generic-params" value="' . urlencode( json_encode( $query ) ) . '" />';
                    break;
                }

                case 'select' : {
                    $result .= '<select  name="' . $name . '" class="generic-record  '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'select' ) . ' >';
                    if( !isset( $ivalue ) && isset( $cvalue ) ){
                        $ivalue = $cvalue;
                    }
                    foreach( $value as $index => $etichet ){
                        if( isset( $ivalue ) && $ivalue == $index ){
                            $status = ' selected="selected" ' ;
                        }else{
                            $status = '' ;
                        }

                        $result .= '<option value="' . $index . '" ' . $status . ' >' . $etichet . '</option>';
                    }
                    $result .= '</select>';
                    break;
                }

                case 'preview-select' : {
                    $result .= '<select  name="' . $name . '" class="generic-record  '  . $fclasses  . ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'select' ) . ' >';
                    if( !isset( $ivalue ) && isset( $cvalue ) ){
                        $ivalue = $cvalue;
                    }
                    if ($ivalue == 'heart') {
                        $new_value = 'icon-like';
                    }else if ($ivalue == 'thumb') {
                        $new_value = 'icon-thumb';
                    }else if ($ivalue == 'star') {
                        $new_value = 'icon-star';
                    }else {
                        $new_value = $ivalue;
                    }
                    foreach( $value as $index => $etichet ){
                        if ($index == 'heart') {
                            $new_index = 'icon-like';
                        }else if ($index == 'thumb') {
                            $new_index = 'icon-thumb';
                        }else if ($index == 'star') {
                            $new_index = 'icon-star';
                        }else {
                            $new_index = $index;
                        }
                        if( isset( $new_value ) && $new_value == $new_index ){
                            $status = ' selected="selected" ' ;
                        }else{
                            $status = '' ;
                        }

                        $result .= '<option value="' . $new_index . '" ' . $status . ' >' . $etichet . '</option>';
                    }
                    $result .= '</select>';

                    $result .= '<div class="preview ' . $new_value . '">';
                    $result .= '</div>';
                break;
                }

                case 'multiple-select' : {
                    $result .= '<select  name="' . $name . '[]" multiple="multiple" class="generic-record  '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'multiple-select' ) . ' style="height:200px !important;" >';
                    foreach( $value as $index => $etichet ){
                        if( isset( $ivalue ) && is_array( $ivalue ) && in_array( $index , $ivalue) ){
                            $status = ' selected="selected" ' ;
                        }else{
                            $status = '' ;
                        }

                        $result .= '<option value="' . $index . '" ' . $status . ' >' . $etichet . '</option>';
                    }
                    $result .= '</select>';
                    break;
                }

                case 'checkbox' : {
                    if( isset( $iname ) && $iname == $ivalue ){
                        $status = ' checked="checked" ' ;
                    }else{
                        $status = '' ;
                    }

                    $result .= '<input type="checkbox" name="' . $name . '" value="' . $iname . '"  ' . $status . ' class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'checkbox' ) . ' />';
                    break;
                }

                case 'button' : {
                    $result .= '<input type="button" name="' . $name . '" value="' . $value . '" class="generic-record-button  button-primary  ' . $classes . '" ' . $id . ' ' . self::action( $action , 'button' ) . ' /> <span class="btn result"></span>';
                    break;
                }

                case 'attach' : {
                    //'action' => "meta.save_data('presentation','speaker' , extra.val('select#field_attach_presentation'), [ { 'name':'speaker[idrecord][]' , 'value' : extra.val('select#field_attach_presentation') } ] );"
                    $action['res'] = $group;
                    $action['group'] = $res;
                    $action['post_id']  = $post_id;
                    $action['attach_selector'] = $attach_selector;
                    if( !isset( $selector ) ){
                        $selector = 'div#' . $res . '_' . $group . ' div.inside div#box_' . $res . '_' . $group;
                    }
                    $action['selector'] = $selector;
                    $result .= '<input type="button" name="' . $name . '" value="' . $value . '" class="generic-record-button  button-primary  ' . $classes . '" ' . $id . ' ' . self::action( $action , 'attach' ) . ' /> <p id="attach_' . $res . '_' . $group . '" class="attach_alert hidden">'.__( ' Attached ' , 'flotheme' ).'</sp>';
                    break;
                }

                case 'meta-save' : {
                    $action['res']      = $res;
                    $action['group']    = $group;
                    $action['post_id']  = $post_id;
                    $action['selector'] = $selector;
                    $result .= '<input type="button" name="' . $name . '" value="' . $value . '" class="generic-record-button  button-primary  ' . $classes . '" ' . $id . ' ' . self::action( $action , 'meta-save' ) . ' />';
                    break;
                }

                case 'upload' : {
                    $result .= '<input type="text" name="' . $name . '"  value="' . $value  . '" class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . ' /><input type="button" class="button-primary" value="'.__('Choose File','flotheme').'" ' . self::action( $field_id , 'upload' ) . ' />';
                    wp_enqueue_media();
                    break;
                }

                case 'generate' : {
                    $result .= '<input type="text" name="' . $name . '"  value="' . $value  . '" class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . ' /><input type="button" class="button-primary" value="'.__('Generate Key','flotheme').'" ' . self::action( '?t=' . security::t().'&amp;n=' . security::n() , 'generate' ) . ' />';
                    break;
                }

                case 'upload-id' :{

                    $action['group'] = $group;
                    $action['topic'] = $topic;
                    $action['index'] = $index;

                    $result .= '<input type="text" name="' . $name . '" value="' . $value . '" class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . '  /><input type="button" class="button-primary" value="'.__('Choose File','flotheme').'" ' . self::action( $field_id , 'upload' ) . ' />';
                    $result .= '<input type="hidden" name="' . $name_id . '" id="' . $field_id . '_id"  class="generic-record generic-single-record '  . $fclasses .  '" value="' . $value_id . '"/>';
                    wp_enqueue_media();
                    break;
                }

                /* multiple type records */
                case 'm-hidden' : {
                    $result .= '<input type="hidden" name="' . $name . '[]" value="' . $value . '" class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . '  />';
                    break;
                }
                case 'm-text' : {
                    $result .= '<input type="text" name="' . $name . '[]" value="' . $value . '" class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'text' ) . ' />';
                    break;
                }
                case 'm-digit' : {
                    $result .= '<input type="text" name="' . $name . '[]" value="' . $value . '" class="generic-record digit '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'text' ) . ' />';
                    break;
                }
                case 'm-textarea' : {
                    $result .= '<textarea name="' . $name . '[]" class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'textarea' ) . '>' . $value . '</textarea>';
                    break;
                }

                case 'm-radio' : {
                    if( isset( $iname ) && $iname == $value ){
                        $status = ' checked="checked" ' ;
                    }else{
                        $status = '' ;
                    }

                    $name = isset( $single ) ? $iname : $group . '[' . $iname . ']';

                    $result .= '<input type="radio" name="' . $name . '[]" value="' . $value . '"  ' . $status . ' class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'radio' ) . ' />';
                    break;
                }

                case 'm-search' : {
                    if( !empty( $value ) && is_numeric($value) && (int)$value > 0 ){
                        $p = get_post( $value );
                        $title = $p -> post_title;
                        $post_id = $p -> ID;
                    }else if( is_array($value) && isset($value[0]) &&  (int)$value[0] > 0 ){
                        $p = get_post( $value[0] );
                        $title = $p -> post_title;
                        $post_id = $p -> ID;
                    }else{
                        $title = '';
                        $post_id = '';
                    }

                    $unique_id = mt_rand(0,9999);
                    $result .= '<input type="text"  class="generic-record-search u-class-'.$unique_id.' " value="' . $title . '" ' . self::action( $action , 'search' ) . '> <span class="icon-close clear-input" title="Delete this value" onclick="jQuery(\'.u-class-'.$unique_id.'\').val(\'\')"></span> ';
                    $result .= '<input type="hidden" name="' . $name . '[]" class="generic-record generic-value u-class-'.$unique_id.' '  . $fclasses .  ' ' . $classes . '" ' . $id . ' value="' . $post_id . '" />';
                    $result .= '<input type="hidden" class="generic-params" value="' . urlencode( json_encode( $query ) ) . '" />';
                    break;
                }

                case 'm-select' : {
                    $result .= '<select  name="' . $name . '[]" class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'select' ) . ' >';
                    foreach( $value as $index => $etichet ){
                        if( isset( $ivalue ) && $ivalue == $index ){
                            $status = ' selected="selected" ' ;
                        }else{
                            $status = '' ;
                        }

                        $result .= '<option value="' . $index . '" ' . $status . ' >' . $etichet . '</option>';
                    }
                    $result .= '</select>';
                    break;
                }

                case 'm-multiple-select' : {
                    $result = '<select  name="' . $name . '[]" multiple="multiple" class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'multiple-select' ) . ' >';
                    foreach( $value as $index => $etichet ){
                        if( isset( $ivalue ) && is_array( $ivalue ) && in_array( $index , $ivalue) ){
                            $status = ' selected="selected" ' ;
                        }else{
                            $status = '' ;
                        }

                        $result .= '<option value="' . $index . '" ' . $status . ' >' . $etichet . '</option>';
                    }
                    $result .= '</select>';
                    break;
                }

                case 'm-checkbox' : {
                     if( isset( $iname ) && $iname == $value ){
                        $status = ' checked="checked" ' ;
                    }else{
                        $status = '' ;
                    }

                    $result .= '<input type="checkbox" name="' . $name . '[]" value="' . $value . '"  ' . $status . ' class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . ' ' . self::action( $action , 'checkbox' ) . ' />';
                    break;
                }
                case 'm-upload' : {
                    $result .= '<input type="text" name="' . $name . '[]"  value="' . $value  . '" class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . ' /><input type="button" class="button-primary" value="'.__('Choose File','flotheme').'" ' . self::action( $field_id , 'upload' ) . ' />';
                    break;
                }

                case 'm-upload-id' :{

                    $action['group'] = $group;
                    $action['topic'] = $topic;
                    $action['index'] = $index;

                    $result .= '<input type="text" name="' . $name . '[]" value="' . $value . '" class="generic-record '  . $fclasses .  ' ' . $classes . '" ' . $id . '  /><input type="button" class="button-primary" value="'.__('Choose File','flotheme').'" ' . self::action( $field_id , 'upload' ) . ' />';
                    $result .= '<input type="hidden" name="' . $name_id . '[]" id="' . $field_id . '_id"  class="generic-record '  . $fclasses .  '" />';

                    wp_enqueue_media();
                    break;
                }
            }

            return $result;
        }
        
        static function months_array( ){
            $result = array(
                '01' =>  __( 'January' , 'flotheme' ),
                '02' =>  __( 'February', 'flotheme' ),
                '03' =>  __( 'March' , 'flotheme' ),
                '04' =>  __( 'April', 'flotheme' ),
                '05' =>  __( 'May', 'flotheme' ),
                '06' =>  __( 'June', 'flotheme' ),
                '07' =>  __( 'July', 'flotheme' ),
                '08' =>  __( 'August', 'flotheme' ),
                '09' =>  __( 'September', 'flotheme' ),
                '10' =>  __( 'October', 'flotheme' ),
                '11' =>  __( 'November', 'flotheme' ),
                '12' =>  __( 'December', 'flotheme' )
            );

            return $result;
        }

        static function monts_days_array( $month , $year  ){
            $days = date( 't' , mktime( 0 , 0 , 0 , $month, 0 , $year, 0 ) );
            return self::digit_array( $days , 1 , true );
        }

        static function digit_array( $to , $from = 0 , $twodigit = false ){
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

        static function post_metabox_help_img($help_img){
            
            $hint_id = mt_rand(0,99999);            
            $obj = new fields();

            $img_url = $obj->help_img_path . $help_img; 

            $img_hint = '<span class="flo-help-icons">
                            <a href="'.$img_url.'" data-fancybox-group="prettyPhoto_'.$hint_id.'" class="img-lightbox-hint">
                                <span class="icon-help-circled"></span>
                            </a>
                        </span>';
            return $img_hint;          
        }
    }
?>
