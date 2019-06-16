<?php
/**
 * @package Hello
 */

get_header(); ?>

	<div id="primary" role="main" >
		<div class="content">

			<article id="single-post-0" class="post error404 not-found">
				<header class="entry-header">
					<div class="header-group">
						<div class="group-content">
							<h1 class="entry-title"><?php _e( 'Well this is somewhat embarrassing, isn&rsquo;t it? It seems we can&rsquo;t find what you&rsquo;re looking for.', 'hello' ); ?></h1>
						</div>
					</div>
				</header><!-- .entry-header -->

			</article><!-- #post-0 -->

		</div><!-- .content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
