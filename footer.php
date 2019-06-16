<?php
/**
 * @package Hello
 */
?>


	<footer id="colophon" role="contentinfo">
		<div class="content">
			<div class="entry-header">
			</div><!-- .entry-header -->
			<div class="entry-content">
				<div class="side bio">
					<?php hello_user_bio(); ?>
				</div>
				<div class="side contact">
					<?php hello_user_links(); ?>
				</div>
			</div><!-- .entry-content -->
		</div><!-- #about -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
