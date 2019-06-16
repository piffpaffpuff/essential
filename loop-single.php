<?php
/**
 * @package Hello
 */
?>

<?php if ( have_posts() ) : ?>

	<?php while ( have_posts() ) : the_post(); ?>
		
		<?php get_template_part( 'content', 'single' ); ?>
		
	<?php endwhile; // end of the loop. ?>

<?php endif; ?>