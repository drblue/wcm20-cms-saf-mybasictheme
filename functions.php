<?php

require_once('includes/Bootstrap_5_WP_Nav_Menu_Walker.php');
require_once('includes/bs5-pagination.php');
require_once('includes/bootscore-pagination.php');

// Register our Custom Post Types and Custom Taxonomies
// require_once('includes/custom-post-types.php');
// require_once('includes/custom-taxonomies.php');

/**
 * Setup theme.
 *
 * @return void
 */
function mbt_theme_setup() {

	/**
	 * Declare support for title-tag.
	 */
	add_theme_support('title-tag');

	/**
	 * Declare support for post-thumbnails.
	 */
	add_theme_support('post-thumbnails');

	/**
	 * Declare support for custom logo.
	 */
	add_theme_support('custom-logo', [
		'height' => 50,
		'width' => 200,
	]);

	/**
	 * Declare support for custom header image.
	 */
	add_theme_support('custom-header', [
		// Display the header text along with the image
		'header-text' => true,

		// Header image width (in pixels)
		'width' => 2560,

		// Header image height (in pixels)
		'height' => 500,

		// Allow flexible image width
		'flex-width' => true,

		// Allow flexible image height
		'flex-height' => true,
	]);

	/**
	 * Declare our own image size for archives
	 */
	add_image_size('featured-image-thumb', 520, 9999);

	/**
	 * Load translation files for textdomain 'mybasictheme'
	 */
	load_theme_textdomain('mybasictheme', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'mbt_theme_setup');

/**
 * Register theme modifications in WP Customizer
 *
 * @param WP_Customize_Manager $wp_customizer
 * @return void
 */
function mbt_customizer($wp_customizer) {
	// Use Header Textshadow?
	$wp_customizer->add_setting('header_textshadow', [
		'default' => false,
	]);
	$wp_customizer->add_control(
		new WP_Customize_Control(
			$wp_customizer,
			'header_textshadow',
			[
				'label' => 'Header Textshadow',			// Admin-visible name of the control
				'setting' => 'header_textshadow',			// Which setting to load and manipulate
				'section' => 'colors', 							// ID of the section this control should render in
				'type' => 'checkbox',
			]
		)
	);

	// Header Textshadow Color
	$wp_customizer->add_setting('header_textshadow_color', [
		'default' => '#dddddd',
	]);
	$wp_customizer->add_control(
		new WP_Customize_Color_Control(
			$wp_customizer,
			'header_textshadow_color',
			[
				'label' => 'Header Textshadow Color',			// Admin-visible name of the control
				'setting' => 'header_textshadow_color',			// Which setting to load and manipulate
				'section' => 'colors', 							// ID of the section this control should render in
				'sanitize_callback' => 'sanitize_hex_color',	// Sanitize HEX color
			]
		)
	);

	// Header Textshadow offset-x
	$wp_customizer->add_setting('header_textshadow_offset_x', [
		'default' => '0',
	]);
	$wp_customizer->add_control(
		new WP_Customize_Control(
			$wp_customizer,
			'header_textshadow_offset_x',
			[
				'label' => 'Header Textshadow Offset X',		// Admin-visible name of the control
				'description' => 'Offset in pixels',			// Admin-visible description of the control
				'setting' => 'header_textshadow_offset_x',		// Which setting to load and manipulate
				'section' => 'colors', 							// ID of the section this control should render in
				'sanitize_callback' => 'mbt_sanitize_int',		// Sanitize integer
				'type' => 'number',
			]
		)
	);

	// Header Textshadow offset-y
	$wp_customizer->add_setting('header_textshadow_offset_y', [
		'default' => '0',
	]);
	$wp_customizer->add_control(
		new WP_Customize_Control(
			$wp_customizer,
			'header_textshadow_offset_y',
			[
				'label' => 'Header Textshadow Offset Y',		// Admin-visible name of the control
				'description' => 'Offset in pixels',			// Admin-visible description of the control
				'setting' => 'header_textshadow_offset_y',		// Which setting to load and manipulate
				'section' => 'colors', 							// ID of the section this control should render in
				'sanitize_callback' => 'mbt_sanitize_int',		// Sanitize integer
				'type' => 'number',
			]
		)
	);

	// Header Textshadow blur-radius
	$wp_customizer->add_setting('header_textshadow_blur_radius', [
		'default' => '0',
	]);
	$wp_customizer->add_control(
		new WP_Customize_Control(
			$wp_customizer,
			'header_textshadow_blur_radius',
			[
				'label' => 'Header Textshadow Blur Radius',		// Admin-visible name of the control
				'description' => 'Blur radius in pixels',		// Admin-visible description of the control
				'setting' => 'header_textshadow_blur_radius',	// Which setting to load and manipulate
				'section' => 'colors', 							// ID of the section this control should render in
				'sanitize_callback' => 'mbt_sanitize_int',		// Sanitize integer
				'type' => 'number',
				'input_attrs' => [
					'min' => '0',
				],
			]
		)
	);

	// Blog Section
	$wp_customizer->add_section('mbt_blog', [
		'title' => 'Blog Settings',
		'priority' => 30,
	]);

	// Blog sidebar
	$wp_customizer->add_setting('blog_sidebar', [
		'default' => 'right',
	]);
	$wp_customizer->add_control('blog_sidebar', [
		'label' => 'Blog Sidebar Location',
		'description' => 'This applies to devices ???768px.',
		'setting' => 'blog_sidebar',
		'section' => 'mbt_blog',
		'type' => 'radio',
		'choices' => [
			'left' => 'Left',
			'right' => 'Right',
		],
	]);
}
add_action('customize_register', 'mbt_customizer');

/**
 * Sanitizes an integer.
 *
 * @param mixed $input
 * @return int
 */
function mbt_sanitize_int($input) {
	return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
}

/**
 * Output neccessary CSS for our theme modifications in WP Customizer.
 *
 * @return void
 */
function mbt_wp_head_customizer_css() {
	$styles = [];

	$header_textcolor = get_theme_mod('header_textcolor');
	array_push($styles, "#site-header .header-text-wrapper {
		color: #{$header_textcolor};
	}");

	if (get_theme_mod('header_textshadow')) {
		$header_textshadow = sprintf(
			"%dpx %dpx %dpx %s",
			get_theme_mod('header_textshadow_offset_x'),
			get_theme_mod('header_textshadow_offset_y'),
			get_theme_mod('header_textshadow_blur_radius'),
			get_theme_mod('header_textshadow_color')
		);
		array_push($styles, "#site-header .header-text-wrapper {
			text-shadow: {$header_textshadow};
		}");
	}

	printf("<style>%s</style>", implode("\n", $styles));
}
add_action('wp_head', 'mbt_wp_head_customizer_css');

/**
 * Output custom logo (if set, otherwise output site title).
 *
 * @return void
 */
function mbt_navbar_brand() {
	$custom_logo_id = get_theme_mod('custom_logo');
	$logo = wp_get_attachment_image_src($custom_logo_id, 'full');

	if ($logo) {
		echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '">';
	} else {
		echo get_bloginfo('name');
	}
}

function mbt_post_meta($display = true) {
	$post_meta = sprintf(
		// translators: Used in blog post information, if a post is posted in one or more categories. Example: "Post published 23 april, 2021 at 09:37 by jn"
		__('Post published %1$s at %2$s by %3$s', 'mybasictheme'),
		get_the_date(),
		get_the_time(),
		get_the_author()
	);

	if (has_category()) {
		$post_meta = sprintf(
			// translators: Used in blog post information, if a post is posted in one or more categories. Example: "Post published by jn in Ipsums"
			_x('%1$s in %2$s', 'blog post category', 'mybasictheme'),
			$post_meta,
			get_the_category_list(', ')
		);
	}

	if (has_tag()) {
		$post_meta = sprintf(
			// translators: Used in blog post information, if a post has one or more tags. Example: "Post published by jn with tags grafitti, skate"
			__('%1$s with tags %2$s', 'mybasictheme'),
			$post_meta,
			get_the_tag_list('', ', ')
		);
	}

	if ($display) {
		echo $post_meta;
	} else {
		return $post_meta;
	}
}

function mbt_movie_review_meta($display = true) {
	global $post;

	$post_meta = sprintf(
		// translators: Used in movie review metadata. Example: "Review published 23 april, 2021 at 09:37 by jn"
		__('Review published %1$s at %2$s by %3$s', 'mybasictheme'),
		get_the_date(),
		get_the_time(),
		get_the_author()
	);

	// $post_id = $post->ID;
	$post_id = get_the_ID();

	$genres = get_the_terms($post_id, 'mbt_movie_genre');

	if ($genres) {
		$genre_links = [];
		foreach ($genres as $genre) {
			$genre_url = get_term_link($genre, 'mbt_movie_genre');
			$genre_link = sprintf('<a href="%s">%s</a>', $genre_url, $genre->name);
			array_push($genre_links, $genre_link);
		}

		$post_meta = sprintf(
			// translators: Used in movie review metadata, if a movie has one or more genres. Example: "Review published by jn in Bromance, Wi-fi"
			_x('%1$s in %2$s', 'movie review genre', 'mybasictheme'),
			$post_meta,
			implode(', ', $genre_links)
		);
	}

	if ($display) {
		echo $post_meta;
	} else {
		return $post_meta;
	}
}

/**
 * Register neccessary scripts and styles.
 *
 * @return void
 */
function mbt_register_scripts_and_styles() {
	/**
	 * Styles
	 */
	// Bootstrap 5
	wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css', [], '5.0.0-beta3', 'all');

	// Theme styles
	wp_enqueue_style('mbt', get_parent_theme_file_uri('style.css'), ['bootstrap'], '0.1', 'all');

	// Print styles
	wp_enqueue_style('mbt-print', get_parent_theme_file_uri('print.css'), ['bootstrap'], '0.1', 'print');

	/**
	 * Scripts
	 */
	// Bootstrap 5
	wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js', [], '5.0.0-beta3', true);

	// Theme scripts
	wp_enqueue_script('mbt', get_parent_theme_file_uri('assets/js/scripts.js'), ['bootstrap'], '0.1', true);
}
add_action('wp_enqueue_scripts', 'mbt_register_scripts_and_styles');

/**
 * Change length of auto-generated excerpt.
 *
 * @param int $length
 * @return int
 */
function mybasictheme_excerpt_length($length) {
	return 10;
}
add_filter('excerpt_length', 'mybasictheme_excerpt_length', 10, 1);

/**
 * Change suffix on auto-generated excerpt.
 *
 * @param string $suffix
 * @return string
 */
function mbt_filter_excerpt_more($suffix) {
	return "...";
}
add_filter('excerpt_more', 'mbt_filter_excerpt_more');

/**
 * Append a 'Read more'-button to excerpts.
 *
 * @param string $excerpt
 * @return string
 */
function mbt_filter_the_excerpt($excerpt) {
	return $excerpt . '<div><a href="' . get_the_permalink() . '" class="btn btn-primary">' . __('Read more &raquo;', 'mybasictheme') . '</a></div>';
}
// add_filter('the_excerpt', 'mbt_filter_the_excerpt');

/**
 * Filters content from bad words and replaces them with asterisk.
 *
 * @param string $content The content to be filtered
 * @return string The filtered content
 */
function mbt_filter_bad_words($content) {
	$bad_words_raw = file_get_contents(get_parent_theme_file_path('includes/bad_words.txt'));
	$bad_words_raw = trim($bad_words_raw);
	$bad_words = explode("\n", $bad_words_raw);
	$censored_words = [];

	foreach ($bad_words as $bad_word) {
		$len = strlen($bad_word);
		$censored_word = str_repeat('*', $len);
		array_push($censored_words, $censored_word);
	}

	return str_ireplace($bad_words, $censored_words, $content);
}
add_filter('the_content', 'mbt_filter_bad_words');
add_filter('the_excerpt', 'mbt_filter_bad_words');
add_filter('the_title', 'mbt_filter_bad_words');

/**
 * Add class to next/previous posts links
 *
 * @return string;
 */
function mbt_filter_pagination_links() {
	return 'class="btn btn-secondary"';
}
add_filter('next_posts_link_attributes', 'mbt_filter_pagination_links', 10, 0);
add_filter('previous_posts_link_attributes', 'mbt_filter_pagination_links', 10, 0);

/**
 * Add class to next/previous post links
 *
 * @return string;
 */
function mbt_filter_post_nav_link($link) {
	return str_replace('<a href=', '<a class="page-link" href=', $link);
}
add_filter('previous_post_link', 'mbt_filter_post_nav_link', 10, 1);
add_filter('next_post_link', 'mbt_filter_post_nav_link', 10, 1);

/**
 * Register navigation menus.
 */
function mbt_register_nav_menus() {
	// register theme menu locations
	register_nav_menus([
		'header-menu' => __('Header Menu', 'mybasictheme'),
	]);
}
add_action('init', 'mbt_register_nav_menus');

/**
 * Register widget areas (a.k.a. sidebars).
 *
 * @return void
 */
function mbt_widgets_init() {
	// Blog widget area
	register_sidebar([
		'name' => __('Blog Sidebar', 'mybasictheme'),
		'id' => 'blog-sidebar',
		'description' => __('Sidebar on blog index, category archive and single blog posts.', 'mybasictheme'),
		'before_widget' => '<div id="%1$s" class="card mb-3 widget %2$s"><div class="card-body">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widget-title h5">',
		'after_title' => '</h3>',
	]);

	// Movie Review widget area
	register_sidebar([
		'name' => __('Movie Review Sidebar', 'mybasictheme'),
		'id' => 'movie-review-sidebar',
		'description' => __('Sidebar on movie reviews archive and single movie reviews.', 'mybasictheme'),
		'before_widget' => '<div id="%1$s" class="card mb-3 widget %2$s"><div class="card-body">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widget-title h5">',
		'after_title' => '</h3>',
	]);

	// Page widget area
	register_sidebar([
		'name' => __('Page Sidebar', 'mybasictheme'),
		'id' => 'page-sidebar',
		'description' => __('Sidebar on pages.', 'mybasictheme'),
		'before_widget' => '<div id="%1$s" class="card mb-3 widget %2$s"><div class="card-body">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widget-title h5">',
		'after_title' => '</h3>',
	]);

	// Footer widget area
	register_sidebar([
		'name' => __('Footer', 'mybasictheme'),
		'id' => 'sidebar-footer',
		'description' => __('Page Footer ????????????.', 'mybasictheme'),
		'before_widget' => '<div id="%1$s" class="text-justify col widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title h5">',
		'after_title' => '</h3>',
	]);
}
add_action('widgets_init', 'mbt_widgets_init');

/**
 * var_dump variable
 *
 * @param mixed $var Variable to dump
 * @param boolean $wrap Wrap output in <pre>-tag?
 * @return void
 */
function dump($var, $wrap = true) {
	if ($wrap) {
		echo "<pre>";
	}

	var_dump($var);

	if ($wrap) {
		echo "</pre>";
	}
}
