<?php
/*
*	block-below-page-content
*/
global $meta,$dynamic;

ob_start();
ob_clean();

if(isset($meta['sidebar']) && trim($meta['sidebar']) == '' ){
	$meta['sidebar'] = 'below-page-content';
}

if(isset($meta['sidebar']) && $meta['sidebar'] != ''){
$dynamic = $meta['sidebar'];
}

get_sidebar('below-page-content');

$f1 = ob_get_clean();
if( strlen($f1) ){
?>
<div class="below-content-widget-area">
	<div class="below-page-content">
		<?php echo $f1;?>
	</div><!-- end #about-author -->
</div>
<?php } ?>
