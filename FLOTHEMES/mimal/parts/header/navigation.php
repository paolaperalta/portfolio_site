<?php global $flo_options, $there_is_no_header_actions;?>
<nav class="main-navigation">
  <div class="logo desktop">
      <?php echo flo_get_logo(); ?>
  </div>

  <?php
    $show_search = isset($flo_options['flo_minimal-enable_search_in_header']) && $flo_options['flo_minimal-enable_search_in_header'] == '1';

    ob_start();
    ob_clean();
    get_sidebar('header-translation');
    $header_translation = ob_get_clean();


    $there_is_no_header_actions = !($show_search || $header_translation);

  ?>
    
  
  <?php get_template_part('parts/header/menu'); ?>


  <?php if ($show_search || $header_translation): ?>
      <div class="header-actions">
               
              <?php if ($header_translation): ?>
                  <div class="language-select block-action">
                      <?php  echo $header_translation; ?>
                  </div>
              <?php endif ?>
              
              <?php if ($show_search): ?>
                  <div class="search block-action">
                      <a href="#" class="show-search min-icon-search-icon">
                        <label class="mobile">Search</label>
                      </a>
                  </div>
              <?php endif ?>
              
      </div>
  <?php endif ?>
</nav>