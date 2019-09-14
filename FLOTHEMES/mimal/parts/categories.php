<?php
global $flo_options, $post_type_c;

if (isset($post_type_c)) {
	if($post_type_c == 'post'){
		$taxonomy = 'category';
		$taxonomies_to_include = meta::get_meta($post->ID, '_cmb2_minimal_category_p');
	}elseif($post_type_c == 'gallery'){
		$taxonomy = 'gallery-category';
		$taxonomies_to_include = meta::get_meta($post->ID, '_cmb2_minimal_category_g');
	}else{
		$taxonomy = 'category';
	}

} else {
	if($post->post_type == 'post'){
		$taxonomy = 'category';
	}elseif($post->post_type = 'gallery'){
		$taxonomy = 'gallery-category';
	}else{
		$taxonomy = 'category';
	}
}

if(isset($post_type_c) && ($post_type_c == 'post' || $post_type_c == 'gallery')){
	$tax_terms = get_terms($taxonomy,array('hide_empty'=> true, 'include'=> $taxonomies_to_include));
}else{
	$tax_terms = get_terms($taxonomy,array('hide_empty'=> true));
}

?>
<div class="category-select">
	<a href="#" class="toggle">
		<span class="label">select category</span>
	</a>
	<div class="category-list">
		<div class="layout row">
			<?php
			$iterator = 1;
			$iterator_2 = 1;
			foreach ($tax_terms as $tax_term) {
				$count_in_the_col = count($tax_terms) / 3;
				if ($iterator == 1):?>
					<div class="medium-4 columns">
					<ul>
				<?php endif; ?>

				<li class="menu-item"><a href="<?php echo esc_attr(get_term_link($tax_term, $taxonomy)); ?>"><?php echo $tax_term->name; ?></a></li>

				<?php
				if ($iterator == ceil($count_in_the_col) || $iterator_2 == count($tax_terms)):?>
					</ul>
					</div>
				<?php endif; ?>
				<?php
				if ($iterator == ceil($count_in_the_col) ) :
					$iterator = 1;
				 else :
					$iterator++;
				endif;
				?>
			<?php
				$iterator_2++;
			}
			?>
		</div>
	</div>
</div>
