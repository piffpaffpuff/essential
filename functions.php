<?php
/**
 * Theme basic functions
 *
 * @package Hello
 */

/**
 * Theme - Setup for the theme
 */
function hello_setup() {
	//remove_theme_support('automatic-feed-links');
	remove_theme_support('post-formats');

	// add thumbnail support
	add_theme_support('automatic-feed-links');

	// add translation support
    load_theme_textdomain('hello', get_template_directory() . '/languages');

	// add image sizes
	add_image_size('crop-4-4', 280, 280, true);
	add_image_size('crop-8-4', 560, 320, true);

	add_image_size('col-full', 1920, 0, false);
	add_image_size('col-16', 1240, 0, false);
	add_image_size('col-12', 920, 0, false);
	add_image_size('col-8', 600, 0, false);
	add_image_size('col-6', 440, 0, false);
	add_image_size('col-4', 280, 0, false);

	//add_image_size('row-2', 0, 160, false);
	//add_image_size('row-4', 0, 280, false);

	// add some extra meta fields to the projects writepanel
	//add_project_field(__('Reference Number'), __('reference_number'), 15);
}
add_action('after_setup_theme', 'hello_setup', 20);

/**
 * Theme - JPEG Image compression
 */
function hello_jpeg_quality( $quality ) {
	return 95;
}
add_filter('jpeg_quality', 'hello_jpeg_quality');

/**
 * Theme - add menus
 */
function hello_register_menus() {
	register_nav_menus(
		array(
			'header-menu' => __( 'Header Menu' ),
			'footer-menu' => __( 'Footer Menu' )
		)
	);
}
add_action( 'init', 'hello_register_menus' );

/**
 * Projects - Get article color
 */
function hello_project_background_color() {
	$meta = get_project_meta('background_color');

	if(empty($meta) || strtolower($meta) == '#ffffff' || strtolower($meta) == '#fff' ) {
		echo '';
	} else {
		echo 'background-color: ' . $meta;
	}
}


/**
 * Projects - featured media
 */
function hello_featured_media($size = 'thumbnail', $attributes = '', $post_id = null) {
	global $projects;

	$attachment = get_project_featured_media($post_id);

	?>
 	<?php if(isset($attachment)) : ?>
 		<?php if(is_array($size)) : ?>
	 		<?php
	 		$src = '';
		 	$src_set = array();
	 		foreach($size as $size_set) {
	 			if(isset($size_set['size'])) {
		 			// overwrite the size when the attachment has set a custom one
					if(!empty($attachment->default_size)) {
						$size_set['size'] = $attachment->default_size;
					}

	 				// build the srcset
		 			$attachment_src = wp_get_attachment_image_src($attachment->ID, $size_set['size']);
		 			$src_set[] = $attachment_src[0] . ' ' . $size_set['query'];

		 			// use the largest image as fallback
		 			$src = $attachment_src[0];
	 			}
	 		}
	 		$src_set = implode(', ', $src_set);
	 		?>
	 		<img src="<?php echo $src; ?>" srcset="<?php echo $src_set; ?>" <?php echo $attributes; ?> alt="" />
 		<?php else : ?>
	 		<?php
		 	// overwrite the size when the attachment has set a custom one
			if(!empty($attachment->default_size)) {
				$size = $attachment->default_size;
			}
		 	$attachment_src = wp_get_attachment_image_src($attachment->ID, $size);
		 	?>
	 		<img src="<?php echo $attachment_src[0]; ?>" <?php echo $attributes; ?> alt="" />
 		<?php endif; ?>
 	<?php endif; ?>
 	<?php
}

/**
 * Projects - media list
 */
function hello_media_list($size = 'thumbnail', $attributes = '', $post_id = null) {
	global $projects;

	?>
	<ul class="project-media">
		<?php
			/* remove any linebreak between the loop and
			the first html tag. like this there won't be
			any inline space when display: 'inline-block';
			is used in the css */
			$counter = 0;
		?>
		<?php foreach(get_project_content_media($post_id) as $attachment) : ?><li<?php if(!empty($attachment->default_size)) : ?> class="<?php echo $attachment->default_size; ?>"<?php endif; ?>>
			<?php if($projects->media->is_web_image($attachment->post_mime_type)) : ?>
				<?php
				// overwrite the size when the attachment has set a custom one
				$media_size = $size;
				// if(!empty($attachment->default_size)) {
				// 	$media_size = $attachment->default_size;
				// } else {
				// 	$media_size = $size;
				// }

				if($counter%2 == 0) {
					$media_position = "media-position-left";
				} else {
					$media_position = "media-position-right";
				}
				?>
				<?php $attachment_src = wp_get_attachment_image_src($attachment->ID, $media_size); ?>
				<?php $url = get_project_meta('website'); ?>
				<img src="<?php echo $attachment_src[0]; ?>" alt="" class="clearfix <?php echo $media_position; ?>" <?php echo $attributes; ?> />
			<?php endif; ?>
		</li><?php $counter++; endforeach; ?>
	</ul>
	<?php
}

/**
 * Projects - the project year
 */
function hello_project_year($flat = false) {
	?>
	<span><?php echo get_project_meta('year'); ?></span>
	<?php
}

/**
 * Projects - Show taxonomies
 */
function hello_project_taxonomy($key, $label = null) {
	$terms = get_project_taxonomy($key, false);

	if(!empty($terms) && !isset($terms->errors) && sizeof($terms) > 0) : $size = sizeof($terms);	?>
		<?php if(empty($label)) : ?>
			<?php foreach($terms as $index => $term) : ?>
				<span><?php echo $term->name; ?></span><?php if($index < $size - 1) : ?>, <?php endif; ?>
			<?php endforeach; ?>
		<?php else : ?>
			<div class="meta-<?php echo $key; ?>">
				<h3><?php echo $label; ?></h3>
				<ul class="taxonomy-<?php echo $key; ?>">
				<?php foreach($terms as $index => $term) : ?>
					<?php $url = get_project_term_meta($term->term_id, 'website'); ?>
					<li><?php if(!empty($url)) : ?><a href="<?php echo $url; ?>" target="_blank"><?php endif; ?><?php echo $term->name; ?><?php if(!empty($url)) : ?></a><?php endif; ?><?php if($index == $size - 1) : ?>.<?php else : ?>, <?php endif; ?></li>
				<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	<?php endif;
}

/**
 * Projects - Get Website
 */
function hello_project_get_website() {
	$url = get_project_meta('website');
	return $url;
}

/**
 * Projects - Redirect to Website
 */
function hello_project_redirect_to_website() {
	$redirect = get_project_meta('redirect');
	if($redirect == 1 && !empty(hello_project_get_website())) {
		return true;
	} else {
		return false;
	}
}

/**
 * Projects - Show the people that are related to a project
 */
function hello_project_related_people($label = null) {
	if(!function_exists("get_related_people")) {
		return;
	}

	$related_people = get_related_people();
	$size = sizeof($related_people);

	if($related_people) : ?>
		<?php if(empty($label)) : ?>
			<?php foreach($related_people as $index => $related_person) : ?>
				<span><?php echo $related_person->post_title; ?></span><?php if($index < $size - 1) : ?>, <?php endif; ?>
			<?php endforeach; ?>
		<?php else : ?>
			<div class="meta-people">
				<h3><?php echo $label; ?></h3>
				<ul class="people-list">
					<?php foreach($related_people as $index => $related_person) : ?>
						<?php $url = get_person_website(); ?>
						<li><?php if(!empty($url)) : ?><a href="<?php echo $url; ?>" target="_blank"><?php endif; ?><?php echo $related_person->post_title; ?><?php if(!empty($url)) : ?></a><?php endif; ?><?php if($index == $size - 1) : ?>.<?php else : ?>, <?php endif; ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
	<?php endif;
}

/**
 * Projects - Get award name
 */
function hello_get_award_name($award) {
	$output = '';

	// only add the award if the name is not empty
	if(!empty($award['taxonomies']['project_award_name']['name'])) {
		$output .= $award['taxonomies']['project_award_name']['name'];
	} else {
		return $output;
	}

	// continue to add the other fields
	if(!empty($award['taxonomies']['project_award_rank']['name'])) {
		$output .= ', ' . $award['taxonomies']['project_award_rank']['name'];
	}

	if(!empty($award['taxonomies']['project_award_category']['name'])) {
		$output .= ', ' . $award['taxonomies']['project_award_category']['name'];
	}

	if(!empty($award['taxonomies']['project_award_year']['name'])) {
		$output .= ', ' . $award['taxonomies']['project_award_year']['name'];
	}

	return $output;
}

/**
 * Projects - Show project awards
 */
function hello_project_awards() {
	$awards = get_project_taxonomy_group_presets('award');
	if(!empty($awards)) : ?>
		<div class="meta-award">
			<h3><?php _e('Awards:', 'hello'); ?></h3>
			<ul class="taxonomy-awards">
			<?php foreach($awards as $award) : ?>
				<?php $name = hello_get_award_name($award); ?>
				<?php if(!empty($name)) : ?>
					<li><?php echo hello_get_award_name($award); ?>.</li>
				<?php endif; ?>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endif;
}

/**
 * Projects - Show all awards
 */
function hello_awards_list($show_projects = true) {
	global $projects;

	$sort = array(
		'project_award_year',
		SORT_DESC,
		SORT_NUMERIC,
		'project_award_name',
		SORT_ASC,
		'project_award_rank',
		SORT_ASC
	);
	$awards = get_projects_taxonomy_group_presets('award', $sort, true);
	?>
	<h3><?php esc_html_e('Awards', 'hello'); ?></h3>
	<ul>
	<? foreach($awards as $award) : ?>
		<?php $name = hello_get_award_name($award); ?>
		<?php if(!empty($name)) : ?>
			<li>
				<?php $link = get_projects_taxonomy_group_preset_permalink($award); ?>
				<a href="<?php echo $link; ?>"><?php echo $name; ?></a>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
	<?php
}

/**
 * show page content
 */
function hello_page_content($slug) {
	$page_id = hello_get_page_id($slug);
	$page = get_page($page_id);
    if(!empty($page)) {
		$content = apply_filters('the_content', $page->post_content);
	}
	?>
	<?php echo $content; ?>
	<?php
}

/**
 * show page title
 */
function hello_page_title($slug) {
	$page_id = hello_get_page_id($slug);
	$page = get_page($page_id);
    if(!empty($page)) {
    	echo apply_filters('the_title', $page->post_title);
    }
}

/**
 * get page image url
 */
function hello_page_image_url($slug) {
	$attachment_id = hello_page_image_id($slug);
	if(!empty($attachment_id)) {
		$attachment_src = wp_get_attachment_image_src($attachment_id, 'full');
		return $attachment_src[0];
	}
}

/**
 * get page image id
 */
function hello_page_image_id($slug) {
	$page_id = hello_get_page_id($slug);
    if(!empty($page_id)) {
		$attachment_id = get_post_thumbnail_id($page_id);
		return $attachment_id;
	}
	return;
}

/**
 * get page id
 */
function hello_get_page_id($slug) {
    $page = get_page_by_path($slug);
    if($page) {
        return $page->ID;
    } else {
        return null;
    }
}

/**
 * show profile bio
 */
function hello_user_bio($user_id = 1) {
	$user_description = get_the_author_meta('description', $user_id);
	?>
	<h3><?php esc_html_e('About', 'hello'); ?></h3>
	<?php if(!empty($user_description)): ?>
		<p><?php echo $user_description; ?></p>
	<?php endif; ?>
	<?php
}

/**
 * show profile link
 */
function hello_user_links($user_id = 1) {
	$user_email = get_the_author_meta('user_contact_email', $user_id);
	$user_facebook = get_the_author_meta('user_facebook', $user_id);
	$user_twitter = get_the_author_meta('user_twitter', $user_id);
	$user_instagram = get_the_author_meta('user_instagram', $user_id);
	$user_pinterest = get_the_author_meta('user_pinterest', $user_id);
	$user_xing = get_the_author_meta('user_xing', $user_id);
	$user_linkedin = get_the_author_meta('user_linkedin', $user_id);
	$user_github = get_the_author_meta('user_github', $user_id);
	?>
	<h3><?php esc_html_e('Links', 'hello'); ?></h3>
	<ul class="links-list">
		<?php if(!empty($user_email)): ?>
			<li><a href="mailto:<?php echo $user_email; ?>" class="icon-button email"><?php esc_html_e('Email', 'hello'); ?></a></li>
		<?php endif; ?>
		<?php if(!empty($user_facebook)): ?>
			<li><a href="<?php echo $user_facebook; ?>" class="icon-button facebook" target="_blank"><?php esc_html_e('Facebook', 'hello'); ?></a></li>
		<?php endif; ?>
		<?php if(!empty($user_twitter)): ?>
			<li><a href="<?php echo $user_twitter; ?>" class="icon-button twitter" target="_blank"><?php esc_html_e('Twitter', 'hello'); ?></a></li>
		<?php endif; ?>
		<?php if(!empty($user_instagram)): ?>
			<li><a href="<?php echo $user_instagram; ?>" class="icon-button instagram" target="_blank"><?php esc_html_e('Instagram', 'hello'); ?></a></li>
		<?php endif; ?>
		<?php if(!empty($user_pinterest)): ?>
			<li><a href="<?php echo $user_pinterest; ?>" class="icon-button pinterest" target="_blank"><?php esc_html_e('Pinterest', 'hello'); ?></a></li>
		<?php endif; ?>
		<?php if(!empty($user_xing)): ?>
			<li><a href="<?php echo $user_xing; ?>" class="icon-button xing" target="_blank"><?php esc_html_e('Xing', 'hello'); ?></a></li>
		<?php endif; ?>
		<?php if(!empty($user_linkedin)): ?>
			<li><a href="<?php echo $user_linkedin; ?>" class="icon-button linkedin" target="_blank"><?php esc_html_e('LinkedIn', 'hello'); ?></a></li>
		<?php endif; ?>
		<?php if(!empty($user_github)): ?>
			<li><a href="<?php echo $user_github; ?>" class="icon-button github" target="_blank"><?php esc_html_e('GitHub', 'hello'); ?></a></li>
		<?php endif; ?>
	</ul>
	<?php
}

/**
 * show friends list
 */
function hello_friends_list() {
	?>
	<h3><?php esc_html_e('Friends', 'hello'); ?></h3>
	<ul class="friends-list">
		<?php
		$args = array(
			'categorize' => false,
			'title_li' => '',
			'title_before' => '',
			'title_after' => '',
			'category_before' => '',
			'category_after' => ''
		);
		wp_list_bookmarks($args);
		?>
	</ul>
	<?php
}

/**
 * show page title
 */
function hello_share_buttons() {
	global $post;
    $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
    $src = $src[0];
	?>
	<ul>
		<li><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode( get_home_url() ); ?>&amp;t=<?php echo urlencode( get_bloginfo( 'name' ) ); ?>" class="share-button facebook" target="_blank"><?php _e('Facebook', 'hello'); ?><span class="share-number">0</span></a>
		<li><a href="http://twitter.com/share?text=<?php echo urlencode( get_bloginfo( 'name' ) ); ?>&amp;url=<?php echo urlencode( get_home_url() ); ?>" class="share-button twitter" target="_blank"><?php _e('Twitter', 'hello'); ?><span class="share-number">0</span></a>
		<li><a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink();?>&amp;media=<?php echo $src; ?>" class="share-button pinterest"><?php _e('Pin It', 'hello'); ?><span class="share-number">0</span></a>
	</ul>
	<?php
}

/**
 * Projects - single content navigation
 */
function hello_content_nav($nav_id) {
	global $wp_query;

	?>
	<?php if ( is_single() ) : // navigation links for single posts ?>
	<ul>
		<li class="nav-previous"><?php previous_post_link('%link', '<span class="nav-title">%title</span>'); ?></li>
		<li class="nav-next"><?php next_post_link('%link', '<span class="nav-title">%title</span>'); ?></li>
	</ul>
	<?php endif; ?>
	<?php
}

/**
 * Add some more info fields to the user profile
 */
function hello_add_user_contact_fields($user) {
	?>
	<h3><?php esc_html_e('Additional contact information', 'hello'); ?></h3>
	<table class="form-table">
		<tr>
			<th><label for="user_address"><?php esc_html_e('Address', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_address" value="<?php echo esc_attr(get_the_author_meta('user_address', $user->ID)); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_postalcode"><?php esc_html_e('Postal Code', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_postalcode" value="<?php echo esc_attr(get_the_author_meta('user_postalcode', $user->ID)); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_city"><?php esc_html_e('City', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_city" value="<?php echo esc_attr(get_the_author_meta('user_city', $user->ID)); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_telephone"><?php esc_html_e('Telephone', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_telephone" value="<?php echo esc_attr(get_the_author_meta('user_telephone', $user->ID)); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_contact_email"><?php esc_html_e('Contact Email', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_contact_email" value="<?php echo esc_attr(get_the_author_meta('user_contact_email', $user->ID)); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_facebook"><?php esc_html_e('Facebook', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_facebook" value="<?php echo esc_attr(get_the_author_meta('user_facebook', $user->ID)); ?>" class="regular-text" placeholder="http://" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_twitter"><?php esc_html_e('Twitter', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_twitter" value="<?php echo esc_attr(get_the_author_meta('user_twitter', $user->ID)); ?>" class="regular-text" placeholder="http://" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_instagram"><?php esc_html_e('Instagram', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_instagram" value="<?php echo esc_attr(get_the_author_meta('user_instagram', $user->ID)); ?>" class="regular-text" placeholder="http://" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_pinterest"><?php esc_html_e('Pinterest', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_pinterest" value="<?php echo esc_attr(get_the_author_meta('user_pinterest', $user->ID)); ?>" class="regular-text" placeholder="http://" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_xing"><?php esc_html_e('Xing', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_xing" value="<?php echo esc_attr(get_the_author_meta('user_xing', $user->ID)); ?>" class="regular-text" placeholder="http://" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_linkedin"><?php esc_html_e('LinkedIn', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_linkedin" value="<?php echo esc_attr(get_the_author_meta('user_linkedin', $user->ID)); ?>" class="regular-text" placeholder="http://" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="user_github"><?php esc_html_e('GitHub', 'hello'); ?></label></th>
			<td>
				<input type="text" name="user_github" value="<?php echo esc_attr(get_the_author_meta('user_github', $user->ID)); ?>" class="regular-text" placeholder="http://" /><br />
			</td>
		</tr>
	</table>
	<?php
}
add_action('show_user_profile', 'hello_add_user_contact_fields');
add_action('edit_user_profile', 'hello_add_user_contact_fields');

/**
 * Save the info fields of the user profile
 */
function hello_save_user_contact_fields($user_id) {
	if(!current_user_can('edit_user', $user_id)) {
		return false;
	}

	update_user_meta($user_id, 'user_address', $_POST['user_address']);
	update_user_meta($user_id, 'user_city', $_POST['user_city']);
	update_user_meta($user_id, 'user_postalcode', $_POST['user_postalcode']);
	update_user_meta($user_id, 'user_telephone', $_POST['user_telephone']);

	update_user_meta($user_id, 'user_contact_email', $_POST['user_contact_email']);
	update_user_meta($user_id, 'user_facebook', $_POST['user_facebook']);
	update_user_meta($user_id, 'user_twitter', $_POST['user_twitter']);
	update_user_meta($user_id, 'user_instagram', $_POST['user_instagram']);

	update_user_meta($user_id, 'user_pinterest', $_POST['user_pinterest']);
	update_user_meta($user_id, 'user_xing', $_POST['user_xing']);
	update_user_meta($user_id, 'user_linkedin', $_POST['user_linkedin']);
	update_user_meta($user_id, 'user_github', $_POST['user_github']);
}
add_action('personal_options_update', 'hello_save_user_contact_fields');
add_action('edit_user_profile_update', 'hello_save_user_contact_fields');

?>
