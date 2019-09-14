<?php
global $type,$list_width;
if ($type == 'list_content_width_view' || $type == 'list_full_width_view' || $type == 'list_full_content_view'): ?>
    <?php
//var_dump($type);die;
    if ($type == 'list_content_width_view') {
        $list_width = ' with-layout ';
    } elseif ($type == 'list_full_width_view') {
        $list_width = ' full-width ';
    } elseif ($type == 'list_full_content_view') {
        $list_width = ' with-layout_full list_full_content_view_class ';
    } else {
        $list_width = ' with-layout_full ';
    }
    ?>
<div class="all-posts <?php echo $list_width; ?> text-center">
        <div class="layout">
<?php endif; ?>