<?php
/**
 * @package Hello
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		$link = get_permalink();
		$target = "_self";
		if(hello_project_redirect_to_website()) {
			$link = hello_project_get_website();
			$target = "_blank";
		}
	?>
	<a href="<?php echo $link; ?>" rel="bookmark" target="<?php echo $target; ?>">
		<header class="entry-header">
			<div class="header-group">
				<h3 class="entry-title split-text" data-scroll><?php the_title(); ?></h3>
				<div class="entry-meta">
					<div class="meta-description">
						<?php if(!empty($post->post_content)) : ?><?php the_content(); ?><?php endif; ?>
							
						<?php hello_project_taxonomy('task', __('Tasks:', 'hello')); ?>
						<?php hello_project_taxonomy('type', __('Type:', 'hello')); ?>
					</div>
				</div>
			</div>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php
				$row = "thumbnail-row-even";
				if($wp_query->current_post%2 == 0) {
					$row = "thumbnail-row-odd";
				}
			?>
			<div class="entry-thumbnail <?php echo $row; ?>" data-scroll>
				<?php hello_featured_media('960-540', 'data-scroll'); ?>
			</div>
		</div><!-- .entry-content -->
		<footer class="entry-footer">
		</footer><!-- .entry-footer -->
	</a>
</article><!-- #post-<?php the_ID(); ?> -->
