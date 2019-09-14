<?php

    /**
     * Redux Framework is free software: you can redistribute it and/or modify
     * it under the terms of the GNU General Public License as published by
     * the Free Software Foundation, either version 2 of the License, or
     * any later version.
     * Redux Framework is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
     * GNU General Public License for more details.
     * You should have received a copy of the GNU General Public License
     * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
     *
     * @package     ReduxFramework
     * @subpackage  Field_Info
     * @author      Daniel J Griffiths (Ghost1227)
     * @author      Dovy Paukstys
     * @version     3.0.0
     */

// Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

// Don't duplicate me!
    if ( ! class_exists( 'ReduxFramework_info' ) ) {

        /**
         * Main ReduxFramework_info class
         *
         * @since       1.0.0
         */
        class ReduxFramework_info {

            /**
             * Field Constructor.
             * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
             *
             * @since       1.0.0
             * @access      public
             * @return      void
             */
            function __construct( $field = array(), $value = '', $parent ) {
                $this->parent = $parent;
                $this->field  = $field;
                $this->value  = $value;
            }

            /**
             * Field Render Function.
             * Takes the vars and outputs the HTML for the field in the settings
             *
             * @since       1.0.0
             * @access      public
             * @return      void
             */
            public function render() {

                $defaults    = array(
                    'title'  => '',
                    'desc'   => '',
                    'notice' => false,
                    'style'  => ''
                );
                $this->field = wp_parse_args( $this->field, $defaults );

                if ( empty( $this->field['desc'] ) && ! empty( $this->field['default'] ) ) {
                    $this->field['desc'] = $this->field['default'];
                    unset( $this->field['default'] );
                }

                if ( empty( $this->field['desc'] ) && ! empty( $this->field['subtitle'] ) ) {
                    $this->field['desc'] = $this->field['subtitle'];
                    unset( $this->field['subtitle'] );
                }

                if ( empty( $this->field['desc'] ) ) {
                    $this->field['desc'] = "";
                }

                if ( empty( $this->field['raw_html'] ) ) {
                    if ( $this->field['notice'] == true ) {
                        $this->field['class'] .= ' redux-notice-field';
                    } else {
                        $this->field['class'] .= ' redux-info-field';
                    }

                    if ( empty( $this->field['style'] ) ) {
                        $this->field['style'] = 'normal';
                    }

                    $this->field['style'] = 'redux-' . $this->field['style'] . ' ';
                }

                $indent = ( isset( $this->field['sectionIndent'] ) && $this->field['sectionIndent'] ) ? ' form-table-section-indented' : '';

                echo '</td></tr></table><div id="info-' . $this->field['id'] . '" class="' . $this->field['style'] . $this->field['class'] . ' redux-field-' . $this->field['type'] . $indent . '">';

                if ( ! empty( $this->field['raw_html'] ) && $this->field['raw_html'] ) {
                    echo $this->field['desc'];
                } else {
                    if ( isset( $this->field['title'] ) && ! empty( $this->field['title'] ) ) {
                        $this->field['title'] = '<b>' . $this->field['title'] . '</b><br/>';
                    }

                    if ( isset( $this->field['icon'] ) && ! empty( $this->field['icon'] ) && $this->field['icon'] !== true ) {
                        echo '<p class="redux-info-icon"><i class="' . $this->field['icon'] . ' icon-large"></i></p>';
                    }

                    if ( isset( $this->field['raw'] ) && ! empty( $this->field['raw'] ) ) {
                        echo $this->field['raw'];
                    }

                    if ( ! empty( $this->field['title'] ) || ! empty( $this->field['desc'] ) ) {
                        echo '<p class="redux-info-desc">' . $this->field['title'] . $this->field['desc'] . '</p>';
                    }
                }
                if ( isset( $this->field['doc_iframe'] ) && ! '' == $this->field['doc_iframe'] ) {
                    $hint_id = mt_rand(0,99999);
                    $doc_iframe = $this->field['doc_iframe'];
                    if(is_array($doc_iframe)){
                        $doc_iframe_content =
                            '<div style="float:right" class="header_icon" title="'.__('See how it looks on the site','flotheme').'" >
                                    <div class="video_wrap">
                                    <p class="how_it_works">CHECK HOW IT WORKS</p>';
                        foreach($doc_iframe as $img){
                            $doc_iframe_content .= '

                                    <a href="'.$img.'" data-fancybox-type="iframe"
                                data-fancybox-group="prettyPhoto_'.$hint_id.'" title="'.__('See how it looks on the
                                site','flotheme').'" class="video-lightbox-hint" target="_blank">';
                        }
                        $doc_iframe_content .= '<span class="dashicons dashicons-admin-page"></span>
                                            </a></div></div>';
                    }else{
                        if( isset($doc_iframe) && strlen($doc_iframe) ){
                            $doc_iframe_content =
                                '<div style="float:right" class="header_icon" title="'.__('See how it looks on the site','flotheme').'" >
                                    <div class="video_wrap">
                                    <p class="how_it_works">CHECK HOW IT WORKS</p>
                                        <a href="'.$doc_iframe.'" data-fancybox-type="iframe" data-fancybox-group="prettyPhoto_'.$hint_id.'" class="video-lightbox-hint">
                                            <span class=" dashicons dashicons-admin-page"></span>
                                        </a>
                                    </div>
                                </div>';
                        }else{
                            $doc_iframe_content = '';
                        }
                    }
                }else{
                    $doc_iframe_content = '';
                }
                if ( isset( $this->field['video_iframe'] ) && ! '' == $this->field['video_iframe'] ) {
                    $hint_id = mt_rand(0,99999);
                    $video_iframe = $this->field['video_iframe'];
                    if(is_array($video_iframe)){
                        $video_iframe_content =
                            '<div style="float:right" class="header_icon" title="'.__('See how it looks on the site','flotheme').'" >
                                    <div class="video_wrap">
                                    <p class="how_it_works">CHECK HOW IT WORKS</p>';
                        foreach($video_iframe as $img){
                            $video_iframe_content .= '<a href="'.$img.'"
                                data-fancybox-type="iframe"
                                data-fancybox-group="prettyPhoto_'.$hint_id.'" title="'.__('See how it looks on the
                                site','flotheme').'" class="video-lightbox-hint" target="_blank">';
                        }
                        $video_iframe_content .= '<span class="dashicons dashicons-video-alt3"></span>
                                            </a></div></div>';
                    }else{
                        if( isset($video_iframe) && strlen($video_iframe) ){
                            $video_iframe_content =
                                '<div style="float:right" class="header_icon" title="'.__('See how it looks on the site','flotheme').'" >
                                    <div class="video_wrap">
                                    <p class="how_it_works">WATCH HOW IT WORKS</p>
                                        <a href="'.$video_iframe.'" data-fancybox-type="iframe" data-fancybox-group="prettyPhoto_'.$hint_id.'" class="video-lightbox-hint" >
                                            <span class=" dashicons dashicons-video-alt3"></span>
                                        </a>
                                    </div>
                                </div>';
                        }else{
                            $video_iframe_content = '';
                        }
                    }
                }else{
                    $video_iframe_content = '';
                }
                echo $doc_iframe_content . $video_iframe_content;

                echo '</div><table class="form-table no-border" style="margin-top: 0;"><tbody><tr style="border-bottom:0; display:none;"><th style="padding-top:0;"></th><td style="padding-top:0;">';
            }

            /**
             * Enqueue Function.
             * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
             *
             * @since       1.0.0
             * @access      public
             * @return      void
             */
            public function enqueue() {
                if ($this->parent->args['dev_mode']) {
                    wp_enqueue_style(
                        'redux-field-info-css',
                        ReduxFramework::$_url . 'inc/fields/info/field_info.css',
                        array(),
                        time(),
                        'all'
                    );
                }
            }
        }
    }