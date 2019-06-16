<?php
/**
 * @package Hello
 */

get_header(); ?>

		<?php // show the single project only when on single page ?>
		<?php if( is_project() ) : ?>

		<div id="primary" role="main" class="clearfix">
			<div class="content">

				<?php get_template_part( 'loop', 'single' ); ?>

			</div><!-- .content -->
		</div><!-- #primary -->

		<div id="complementary" role="complementary" class="clearfix">
			<div class="content">

				<?php $next_post = get_next_post(); ?>
				<?php if (!empty( $next_post )): global $post; $post = $next_post; setup_postdata( $post ); ?>

					<?php get_template_part( 'content' ); ?>

				<?php endif; ?>
			</div><!-- .content -->
		</div><!-- #complementary -->

	<?php else : ?>

		<div id="complementary" role="complementary" class="clearfix">
			<div class="content">

			<?php // also show the projects list on a single page ?>
			<?php // use query_projects to use the same template ?>
			<?php if( is_project() ) : ?>

					<?php query_projects(); ?>

			<?php endif; ?>

			<?php get_template_part( 'loop' ); ?>

			<?php // reset query ?>
			<?php if( is_project() ) : ?>

				<?php wp_reset_query(); ?>

			<?php endif; ?>
			</div><!-- .content -->
		</div><!-- #complementary -->

<?php endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
