<?php
/**
 * Posts Loop End
 *
 */
global $view_type_c;
if($view_type_c == 'grid_view' || $view_type_c == 'orig-size'):?>
          </ul>
        </div>
    </div>
</div>
<?php else:?>
    </div>
</div>
<?php endif; ?>
<?php wp_reset_query();wp_reset_postdata();
// need to check all , I am not sure that's needed
    $view_type_c = $aditional_classes = $i = $last = $gutter_class = $gutter = $i = $nr_col_c = $nr_of_columns = $last
    = $counter_i = $post = $list_view_width = null;
?>
<div class="clearfix"></div>
