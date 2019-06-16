<?php
/**
 * @package Hello
 */
?>
<?php $post_counter = 0; ?>
<?php if ( have_posts() ) : ?>

	<?php
		/* Start the Loop */
	?>
	<?php
		/* remove any linebreak between the loop and
		the first html tag. like this there won't be
		any inline space when display: 'inline-block';
		is used in the css */
	?>
	<?php while ( have_posts() ) : the_post(); $post_counter++; ?><?php get_template_part( 'content' ); ?><?php endwhile; ?>

<?php else : ?>

	<article id="post-0" class="post no-results not-found">
		<header class="entry-header">
			<h1 class="entry-title is-hidden"><?php _e( 'Nothing Found', 'hello' ); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'hello' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->

<?php endif; ?>
