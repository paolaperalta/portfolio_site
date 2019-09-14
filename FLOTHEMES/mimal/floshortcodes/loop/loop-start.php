<?php
/**
 * Posts Loop Start
 *
 */

global $view_type_c, $aditional_classes, $i, $last, $gutter_class, $gutter, $i, $nr_col_c, $nr_of_columns, $last,
       $counter_i, $post, $list_view_width;
$nr_of_columns = $nr_col_c;
if ($view_type_c == 'list_view') {
    $gutter = '';
}
if($post){
    $list_width_option = meta::get_meta($post->ID, '_cmb2_minimal_list_view_width');
}
if ($nr_of_columns == '3') {
    $block_class = 'medium-block-grid-3 large-block-grid3';
} elseif ($nr_of_columns == '4') {
    $block_class = 'medium-block-grid-4 large-block-grid4';
} else {
    $block_class = 'medium-block-grid-3 large-block-grid3';
}
?>

<?php if ($view_type_c == 'grid_view' || $view_type_c == 'orig-size'): ?>
<div class="page portfolio-page">
    <?php else: ?>
    <div class="page blog">
        <?php endif; ?>

        <?php
        global $type;
        $type = $view_type_c;
        get_template_part('parts/list_view_width');
        ?>
                <?php if ($view_type_c == 'grid_view'): ?>
                <div class="squares row">
                    <div class="large-12 columns">
                        <ul class="<?php echo $block_class; ?>">
                            <?php endif; ?>

                            <?php if ($view_type_c == 'orig-size'): ?>
                            <div class="orig-size row">
                                <div class="large-12 columns">
                                    <ul class="<?php echo $block_class; ?>">
                                        <?php endif; ?>
