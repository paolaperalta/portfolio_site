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
 * @subpackage  Field_social_networks
 * @author      Luciano "WebCaos" Ubertini
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @version     3.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Don't duplicate me!
if (!class_exists('ReduxFramework_social_networks')) {

    /**
     * Main ReduxFramework_slides class
     *
     * @since       1.0.0
     */
    class ReduxFramework_social_networks
    {

        /**
         * Field Constructor.
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct($field = array(), $value = '', $parent)
        {
            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;
        }

        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render()
        {

            $defaults = array(
                'show' => array(
                    'title' => true,
                ),
                'content_title' => __('Social Networks', 'flotheme')
            );

            $this->field = wp_parse_args($this->field, $defaults);

            echo '<div class="redux-social_networks-accordion" data-new-content-title="' . esc_attr(sprintf(__('New %s', 'flotheme'), $this->field['content_title'])) . '">';

            $x = 0;

            $multi = (isset ($this->field['multi']) && $this->field['multi']) ? ' multiple="multiple"' : "";

            if (isset ($this->value) && is_array($this->value) && !empty ($this->value)) {

                $slides = $this->value;

                foreach ($slides as $slide) {

                    if (empty ($slide)) {
                        continue;
                    }

                    $defaults = array(
                        'title' => '',
                        'sort' => '',
                        'url' => '',
                        'image' => '',
                        'thumb' => '',
                        'attachment_id' => '',
                        'height' => '',
                        'width' => '',
                        'icon' => '',
                        'roll_over' => '',
                        'select' => array(),
                    );
                    $slide = wp_parse_args($slide, $defaults);

                    if (empty ($slide['thumb']) && !empty ($slide['attachment_id'])) {
                        $img = wp_get_attachment_image_src($slide['attachment_id'], 'full');
                        $slide['image'] = $img[0];
                        $slide['width'] = $img[1];
                        $slide['height'] = $img[2];
                    }

                    echo '<div class="redux-social_networks-accordion-group"><fieldset class="redux-field" data-id="' . $this->field['id'] . '"><h3><span class="redux-social_networks-header">' . $slide['title'] . '</span></h3><div>';


                    echo '<ul id="' . $this->field['id'] . '-ul" class="redux-social_networks-list">';

                    if ($this->field['show']['title']) {
                        $title_type = "text";
                    } else {
                        $title_type = "hidden";
                    }

                    $placeholder = (isset ($this->field['placeholder']['title'])) ? esc_attr($this->field['placeholder']['title']) : __('Title', 'flotheme');
                    echo '<li>
                        <label class="redux_field_th">Social Network Name</label>
                        <input type="' . $title_type . '" id="' . $this->field['id'] . '-title_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][title]' . $this->field['name_suffix'] . '" value="' . esc_attr($slide['title']) . '" placeholder=" Name" class="full-text slide-title" /></li>';
                    echo '<li>
                        <label class="redux_field_th">Social Network URL</label>
                        <input type="' . $title_type . '" id="' . $this->field['id'] . '-url_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][url]' . $this->field['name_suffix'] . '" value="' . esc_attr($slide['url']) . '" placeholder=" Url" class="full-text slide-title" /></li>';
                    echo '<li>
                        <label class="redux_field_th">Icon Image</label>
                        <input type="text" id="' . $this->field['id'] . '-icon_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][icon]' . $this->field['name_suffix'] . '" value="'. esc_attr($slide['icon']) . '" placeholder=" Icon" class="full-text slide-title slide_icon slide_icon_c hidden" /></li>';

                    ?>
                    <li>
                        <img class="redux-social_networks-image" src="<?php echo esc_attr($slide['icon']); ?>"
                             id="<?php echo $this->field['id'] . '-icon_c_' . $x ?>">
                    </li>

                    <li>
                        <input type="button" class="button button-primary c" value="Choose File"
                               onclick="javascript:act.upload('input#<?php echo $this->field['id'] . '-icon_' . $x ?>','<?php echo $this->field['id'] . '-icon_c_' . $x ?>')"/>
                        <button href="#" class="button  remove_image_c">Remove image</button>
                        <div class="description"><em>Not mandatory for the supported services</em></div>
                    </li>
                    <li>
                        <label class="redux_field_th">Icon Hover Image</label>
                    </li>
                    <?php
                    echo '<li><input type="text" id="' . $this->field['id'] . '-roll_over_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][roll_over]' . $this->field['name_suffix'] . '" value="' . esc_attr($slide['roll_over']) . '" placeholder=" roll_over" class="full-text slide-title slide_icon_r hidden" /></li>';
                    ?>
                    <li>
                        <img class="redux-social_networks-image1" src="<?php echo esc_attr($slide['roll_over']); ?>"
                             id="<?php echo $this->field['id'] . '-roll_over_r_' . $x ?>">
                    </li>
                    <li>
                        <input type="button" class="button button-primary r" value="Choose File"
                               onclick="javascript:act.upload('input#<?php echo $this->field['id'] . '-roll_over_' . $x ?>', '<?php echo $this->field['id'] . '-roll_over_r_' . $x ?>')"/>
                        <button href="#" class="button remove_image_r">Remove Image</button>

                        <div class="description"><em>Not mandatory for the supported services</em></div>
                    </li>
                    <?php
                    echo '<li><input type="hidden" class="slide-sort" name="' . $this->field['name'] . '[' . $x . '][sort]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-sort_' . $x . '" value="' . $slide['sort'] . '" />';
                    echo '<input type="hidden" class="upload-thumbnail" name="' . $this->field['name'] . '[' . $x . '][thumb]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-thumb_url_' . $x . '" value="' . $slide['thumb'] . '" readonly="readonly" />';
                    echo '<input type="hidden" class="upload" name="' . $this->field['name'] . '[' . $x . '][image]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-image_url_' . $x . '" value="' . $slide['image'] . '" readonly="readonly" />';

//                    echo '<input type="hidden" class="upload-thumbnail2" name="' . $this->field['name'] . '[' . $x . '][thumb2]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-thumb_url_' . $x . '" value="' . $slide['thumb2'] . '" readonly="readonly" />';
//                    echo '<input type="hidden" class="upload2" name="' . $this->field['name'] . '[' . $x . '][image2]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-image_url_' . $x . '" value="' . $slide['image2'] . '" readonly="readonly" />';

                    echo '<input type="hidden" class="upload-height" name="' . $this->field['name'] . '[' . $x . '][height]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-image_height_' . $x . '" value="' . $slide['height'] . '" />';
                    echo '<input type="hidden" class="upload-width" name="' . $this->field['name'] . '[' . $x . '][width]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-image_width_' . $x . '" value="' . $slide['width'] . '" /></li>';
                    echo '<li><a href="javascript:void(0);" class="button deletion redux-social_networks-remove">' . __('Delete', 'flotheme') . '</a></li>';
                    echo '</ul></div></fieldset></div>';
                    $x++;
                }
            }

            if ($x == 0) {
                echo '<div class="redux-social_networks-accordion-group"><fieldset class="redux-field" data-id="' . $this->field['id'] . '"><h3><span class="redux-social_networks-header">' . esc_attr(sprintf(__('New %s', 'flotheme'), $this->field['content_title'])) . '</span></h3><div>';

                $hide = ' hide';

//                echo '<div class="screenshot' . $hide . '">';
//                echo '<a class="of-uploaded-image" href="">';
//                echo '<img class="redux-social_networks-image" id="image_image_id_' . $x . '" src="" alt="" target="_blank" rel="external" />';
//                echo '</a>';
//                echo '</div>';


                echo '<ul id="' . $this->field['id'] . '-ul" class="redux-social_networks-list">';
                if ($this->field['show']['title']) {
                    $title_type = "text";
                } else {
                    $title_type = "hidden";
                }
                $x = 1;
                $placeholder = (isset ($this->field['placeholder']['title'])) ? esc_attr($this->field['placeholder']['title']) : __('SET TITLE FOR NEW SOCIAL PROFILE', 'flotheme');
                echo '<li>
                        <label class="redux_field_th">Social Network Name</label>
                        <input type="' . $title_type . '" id="' . $this->field['id'] . '-title_' . $x . '"
                        name="' . $this->field['name'] . '[' . $x . '][title]' . $this->field['name_suffix'] . '" value="facebook"
                        placeholder=" Name" class="full-text slide-title" /></li>';
                    echo '<li>
                        <label class="redux_field_th">Social Network URL</label>
                        <input type="' . $title_type . '" id="' . $this->field['id'] . '-url_' . $x . '"
                        name="' . $this->field['name'] . '[' . $x . '][url]' . $this->field['name_suffix'] . '" value="http://facebook.com"
                        placeholder=" Url" class="full-text slide-title" /></li>';
                    echo '<li>';


                echo '<li>
                    <label class="redux_field_th">Icon Image</label>
                    <input type="text" id="' . $this->field['id'] . '-icon_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][icon]' . $this->field['name_suffix'] . '" value="" placeholder=" Icon" class="full-text slide-title slide_icon slide_icon_c hidden" /></li>';

                ?>
                <li>
                    <img class="redux-social_networks-image" src=""
                         id="<?php echo $this->field['id'] . '-icon_c_' . $x ?>">
                </li>

                <li>
                    <input type="button" class="button button-primary c" value="Choose File"
                           onclick="javascript:act.upload('input#<?php echo $this->field['id'] . '-icon_' . $x ?>','<?php echo $this->field['id'] . '-icon_c_' . $x ?>')"/>
                    <button href="#" class="button  remove_image_c">Remove image</button>
                    <div class="description"><em>Not mandatory for the supported services</em></div>
                </li>

                <li>
                    <label class="redux_field_th">Icon Hover Image</label>
                </li>

                <?php
                echo '<li><input type="text" id="' . $this->field['id'] . '-roll_over_' . $x . '" name="' . $this->field['name'] . '[' . $x . '][roll_over]' . $this->field['name_suffix'] . '" value="" placeholder=" roll_over" class="full-text slide-title slide_icon_r hidden" /></li>';
                ?>
                <li>
                    <img class="redux-social_networks-image1" src=""
                         id="<?php echo $this->field['id'] . '-roll_over_r_' . $x ?>">
                </li>
                <li>
                    <input type="button" class="button button-primary r" value="Choose File"
                           onclick="javascript:act.upload('input#<?php echo $this->field['id'] . '-roll_over_' . $x ?>', '<?php echo $this->field['id'] . '-roll_over_r_' . $x ?>')"/>
                    <button href="#" class="button remove_image_r">Remove Image</button>

                    <div class="description"><em>Not mandatory for the supported services</em></div>
                </li>
                <?php
                echo '<li><input type="hidden" class="slide-sort" name="' . $this->field['name'] . '[' . $x . '][sort]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-sort_' . $x . '" value="" />';
                echo '<input type="hidden" class="upload-thumbnail" name="' . $this->field['name'] . '[' . $x . '][thumb]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-thumb_url_' . $x . '" value="" readonly="readonly" />';
                echo '<input type="hidden" class="upload" name="' . $this->field['name'] . '[' . $x . '][image]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-image_url_' . $x . '" value="" readonly="readonly" />';

//                    echo '<input type="hidden" class="upload-thumbnail2" name="' . $this->field['name'] . '[' . $x . '][thumb2]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-thumb_url_' . $x . '" value="' . $slide['thumb2'] . '" readonly="readonly" />';
//                    echo '<input type="hidden" class="upload2" name="' . $this->field['name'] . '[' . $x . '][image2]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-image_url_' . $x . '" value="' . $slide['image2'] . '" readonly="readonly" />';

                echo '<input type="hidden" class="upload-height" name="' . $this->field['name'] . '[' . $x . '][height]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-image_height_' . $x . '" value="" />';
                echo '<input type="hidden" class="upload-width" name="' . $this->field['name'] . '[' . $x . '][width]' . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-image_width_' . $x . '" value="" /></li>';
                echo '<li><a href="javascript:void(0);" class="button deletion redux-social_networks-remove">' . __('Delete', 'flotheme') . '</a></li>';


                echo '</ul></div></fieldset></div>';
            }
            echo '</div><a href="javascript:void(0);" class="button redux-social_networks-add button-primary" rel-id="' . $this->field['id'] . '-ul" rel-name="' . $this->field['name'] . '[title][]' . $this->field['name_suffix'] . '">' . sprintf(__('Add %s', 'flotheme'), $this->field['content_title']) . '</a><br/>';
        }

        /**
         * Enqueue Function.
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue()
        {
            if (function_exists('wp_enqueue_media')) {
                wp_enqueue_media();
            } else {
                wp_enqueue_script('media-upload');
            }

            if ($this->parent->args['dev_mode']) {
                wp_enqueue_style('redux-field-media-css');

                wp_enqueue_style(
                    'redux-field-social_networks-css',
                    ReduxFramework::$_url . 'extensions/social_networks/social_networks/field_social_networks.css',
                    array(),
                    time(),
                    'all'
                );
            }

            wp_enqueue_script(
                'redux-field-media-js',
                ReduxFramework::$_url . 'assets/js/media/media' . Redux_Functions::isMin() . '.js',
                array('jquery', 'redux-js'),
                time(),
                true
            );

            wp_enqueue_script(
                'redux-field-social_networks-js',
                ReduxFramework::$_url . 'extensions/social_networks/social_networks/field_social_networks' . Redux_Functions::isMin() . '.js',
                array('jquery', 'jquery-ui-core', 'jquery-ui-accordion', 'jquery-ui-sortable', 'redux-field-media-js'),
                time(),
                true
            );

        }
    }
}
