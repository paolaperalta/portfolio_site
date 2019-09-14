<?php global $there_is_no_header_actions; ?>

<div class="header-menu <?php echo $there_is_no_header_actions ? 'no-header-actions' : ''; ?>">
    <?php
    $menu_class = 'nav-menu';
    if (isset($menu_locations['primary'])) {
        $the_menu_object = wp_get_nav_menu_object($menu_locations['primary']);
    }
    if (isset($the_menu_object->slug)) {
        add_filter('wp_nav_menu_' . $the_menu_object->slug . '_items', 'flo_add_menu_to_nav', 10, 2);
    }
    if (isset($the_menu_object->slug)) {
        echo menu('primary', array('number-items' => options::get_value('menu', 'header'), 'current-class' => 'active', 'type' => 'category', 'class' => $menu_class, 'menu_id' => 'menu', 'nr_items_per_column' => 999));
    } else {
        $nr_items_per_column = 9999;
        echo menu('primary', array('number-items' => options::get_value('menu', 'header'), 'submenu-class' => 'menu-item-has-children', 'current-class' => 'active', 'type' => 'category', 'class' => $menu_class, 'menu_id' => 'desktop_menu', 'nr_items_per_column' => $nr_items_per_column));
    }
    ?>
</div>