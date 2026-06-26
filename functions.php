<?php
if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

function omimicolors_setup() {
	load_theme_textdomain( 'omimicolors', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	register_nav_menus(array(
    'header-menu-1' => 'Меню слева (Шапка)',
    'header-menu-2' => 'Меню справа (Шапка)',
    'footer-menu-1' => 'Меню 1 (Футер)',
		'footer-menu-2' => 'Меню 2 (Футер)',
		'footer-menu-3' => 'Меню 3 (Футер)',
	));
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);
	add_theme_support(
		'custom-background',
		apply_filters(
			'omimicolors_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'omimicolors_setup' );

function omimicolors_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'omimicolors_content_width', 640 );
}
add_action( 'after_setup_theme', 'omimicolors_content_width', 0 );

function omimicolors_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'omimicolors' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'omimicolors' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'omimicolors_widgets_init' );

require get_template_directory() . '/includes/enqueuе-scripts.php';
require get_template_directory() . '/includes/carbon/functions.php';
require get_template_directory() . '/includes/ajax.php';

if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/includes/jetpack.php';
}

if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/includes/woocommerce.php';
}

function set_post_views($post_id) {
	if (current_user_can('administrator') || current_user_can('editor')) {
		return;
	}

	$key = 'post_views_count';
	$count = get_post_meta($post_id, $key, true);

	if ($count == '') {
		$count = 0;
		delete_post_meta($post_id, $key);
		add_post_meta($post_id, $key, '1');
	} else {
		$count++;
		update_post_meta($post_id, $key, $count);
	}
}

function get_post_views($post_id) {
	$count = get_post_meta($post_id, 'post_views_count', true);
	return $count ? $count : 0;
}