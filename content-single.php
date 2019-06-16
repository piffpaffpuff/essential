<?php
/**
 * @package Hello
 */
?>

<article id="single-post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="header-group">
			<h2 class="entry-title split-text" data-scroll><?php the_title(); ?></h2>
		</div>
		<div class="header-group">

			<div class="entry-column">
				<div class="meta-description" data-scroll>
					<?php if(!empty($post->post_content)) : ?><?php the_content(); ?><?php endif; ?>

						<?php hello_project_taxonomy('type', __('Type:', 'hello')); ?>
						<?php hello_project_taxonomy('task', __('Tasks:', 'hello')); ?>
						<?php hello_project_taxonomy('agency', __('Agency:', 'hello')); ?>
						<?php hello_project_awards(); ?>
						<?php hello_project_related_people(__('Collaboration with:', 'hello')); ?>

				</div>
			</div>
			<?php $url = hello_project_get_website(); ?>
			<?php if(!empty($url)) : ?>
				<h3 class="meta-website"><a href="<?php echo $url; ?>" target="_blank"><?php _e('Visit Site', 'hello'); ?> <img src="<?php echo get_stylesheet_directory_uri() . "/images/link.svg"; ?>" class="meta-website-icon"></a></h3>
			<?php endif; ?>
		</div>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<div class="content-group">
			<div class="entry-images clearfix">
				<?php hello_media_list('col-12', 'data-scroll'); ?>
			</div>
		</div>
	</div><!-- .entry-content -->
	<div class="entry-footer">
	</div><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
