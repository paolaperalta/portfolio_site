<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package options_sample
 */

global $flo_options;

ob_start();
ob_clean();
get_sidebar('footer-first');
$f1 = ob_get_clean();

ob_start();
ob_clean();
get_sidebar('footer-global');
$f_global = ob_get_clean();

ob_start();
ob_clean();
get_sidebar('footer-third');
$f3 = ob_get_clean();

ob_start();
ob_clean();
get_sidebar('footer-fullscreen');
$ff = ob_get_clean();

ob_start();
ob_clean();
get_sidebar('footer-second');
$f2 = ob_get_clean();

ob_start();
ob_clean();
get_sidebar('footer-fifth');
$fw1 = ob_get_clean();

ob_start();
ob_clean();
get_sidebar('footer-fullwidth');
$fw2 = ob_get_clean();
?>

<footer class="main-footer">

			

	<?php if ($f1 || $f2 || $f3 || $fw1 || $fw2): ?>
		<div class="default-content row">
			<?php if ($fw1): ?>
				<div class="block medium-12 columns footer-full-width-area" style="border-right: none">
					<?php echo $fw1;?>
				</div>
			<?php endif;?>

			<div class="block-widgets ">
				<?php if ($f1): ?>
					<div class="block">
						<?php echo $f1;?>
					</div>
				<?php endif ?>

				<?php if ($f2): ?>
					<div class="block">
						<?php echo $f2;?>
					</div>
				<?php endif ?>

				<?php if ($f3): ?>
					<div class="block" style="border-right: none">
						<?php echo $f3;?>
					</div>
				<?php endif ?>
			</div>

			<?php if ($fw2): ?>
				<div class="block medium-12 columns footer-full-width-area below" style="border-right: none">
					<?php echo $fw2;?>
				</div>
			<?php endif;?>
		</div>
	<?php endif;?>
	<div class="copyright row">
		<div class="large12">
			<?php
			echo $f_global;
			echo str_replace('%year%', date('Y'), $flo_options['flo_minimal-editor']); ?>
			<?php
			do_action( 'flo_footer_credits');
			?>
		</div>
	</div>
</footer>
</div>
</div>
<?php
echo $flo_options['flo_minimal-tracking_code'];
wp_footer();
?>
</body>

</html>
