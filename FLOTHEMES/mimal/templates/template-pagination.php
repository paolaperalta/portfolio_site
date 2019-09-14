<?php
global $the_query;

$posts_listing_link = options::get_value('blog_post', 'post_listing_link');

if (is_array($posts_listing_link) && isset($posts_listing_link[0]) && is_numeric($posts_listing_link[0])) {
    $posts_listing_id = $posts_listing_link[0];
} else {
    $posts_listing_id = 0;
}

if (get_query_var('paged')) {
    $current = get_query_var('paged');
} elseif (get_query_var('page')) {
    $current = get_query_var('page');
} else {
    $current = 1;
}
//==========================Pagination==============================
?>

<?php if (isset($the_query) && $the_query->max_num_pages > 1): ?>

    <?php
    $total = $the_query->max_num_pages;

    if ($the_query->max_num_pages > 1) { // if we have more than 1 page
        if ($GLOBALS['wp_rewrite']->using_permalinks()) {
            $pl_args['base'] = user_trailingslashit(trailingslashit(get_pagenum_link(1)) . 'page/%#%/', 'paged');
        } else {
            $pl_args['base'] = '';
        }
    } else {
        $total = 1;
    }

    if ($current > 0 && $current - 1 > 0) {
        $prev = $current - 1;
    } else {
        $prev = $current;
    }
    if ($current < $total && $current + 1 <= $total) {
        $next = $current + 1;
    } else {
        $next = $current;
    }
    if ($total == (int)$current) {
        $next_link = false;
        //        $next_link = '<span class="next link innactive" >' . sprintf(__('next %s', 'flotheme'),$post->post_type) . '</span>';
    } else {
        $next_link = '<a  href="' . get_pagenum_link($next) . '"> next page </a>';
    }
    if ($current == 1) {
        $prev_link = false;
    } else {
        $prev_link = '<a href="' . get_pagenum_link($prev) . '">Prev. Page</a>';
    }
    if ($total > 8) {
        $delim = ' <li class="delim"> ...</li>';
    } else {
        $delim = '';
    }
    $baseURL = get_the_permalink($post->ID);
    ?>
    <div class="pagination">
        <ul>
            <?php if ($prev_link) { ?>
                <li class="nav prev">
                    <?php echo $prev_link; ?>
                </li>
            <?php } ?>
            <?php echo pagination($first = 1, $last = 1, $middle = 6, $baseURL, $the_query); ?>
            <?php if ($next_link) { ?>
                <li class="nav next">
                    <?php echo $next_link; ?>
                </li>
            <?php } ?>
        </ul>
    </div>

<?php elseif (isset($wp_query)): ?>
    <?php
    $total = $wp_query->max_num_pages;
    if ($wp_query->max_num_pages > 1) { // if we have more than 1 page
        if ($GLOBALS['wp_rewrite']->using_permalinks()) {
            $pl_args['base'] = user_trailingslashit(trailingslashit(get_pagenum_link(1)) . 'page/%#%/', 'paged');
        } else {
            $pl_args['base'] = '';
        }
    } else {
        $total = 1;
    }

    if ($current > 0 && $current - 1 > 0) {
        $prev = $current - 1;
    } else {
        $prev = $current;
    }
    if ($current < $total && $current + 1 <= $total) {
        $next = $current + 1;
    } else {
        $next = $current;
    }
    if ($total == (int)$current) {
        $next_link = '<a href="#" class="empty" ></a>';
        //        $next_link = '<span class="next link innactive" >' . sprintf(__('next %s', 'flotheme'),$post->post_type) . '</span>';
    } else {
        $next_link = '<a  href="' . get_pagenum_link($next) . '"> next page</a>';
    }
    if ($current == 1) {
        $prev_link = '<a href="#" class="empty"></a>';
    } else {
        $prev_link = '<a href="' . get_pagenum_link($prev) . '">Prev. page</a>';
    }
    if ($total > 8) {
        $delim = ' <li class="delim"> ...</li>';
    } else {
        $delim = '';
    }

    if ($total > 1):
        if(is_search()):
            $baseURL = site_url().'/';
        else:
            $baseURL = get_pagenum_link();
        endif;
        ?>
        <div class="pagination">
            <ul>
                <?php if ($prev_link) { ?>
                    <li class="nav prev">
                        <?php echo $prev_link; ?>
                    </li>
                <?php } ?>
                <?php echo pagination($first = 1, $last = 1, $middle = 6, $baseURL, $wp_query); ?>
                <?php if ($next_link) { ?>
                    <li class="nav next">
                        <?php echo $next_link; ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php endif; ?>
<?php endif; ?>
