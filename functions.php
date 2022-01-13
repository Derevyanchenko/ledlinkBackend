<?php

/**
 * Implement the Custom Header feature.
 */
require_once "inc/setup.php";
require_once "inc/enqueue-styles-and-scripts.php";

function ecommerce_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'ecommerce_add_woocommerce_support' );

/**
 * Load WooCommerce compatibility file.
 */
// if ( class_exists( 'WooCommerce' ) ) {
// 	require get_template_directory() . '/inc/wc-modifications.php';
// }

add_action( 'widgets_init', 'register_my_widgets' );
function register_my_widgets(){

	register_sidebar( array(
		'name'          => 'Sidebar custom',
		'id'            => "sidebar-custom",
		'description'   => '',
		'class'         => '',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => "</li>\n",
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => "</h2>\n",
		'before_sidebar' => '', // WP 5.6
		'after_sidebar'  => '', // WP 5.6
	) );
}

add_filter( 'nav_menu_css_class', 'add_my_class_to_nav_menu', 10, 2 );
function add_my_class_to_nav_menu( $classes, $item ){
	/* $classes содержит
	Array(
		[1] => menu-item
		[2] => menu-item-type-post_type
		[3] => menu-item-object-page
		[4] => menu-item-284
	)
	*/
	$classes[] = 'menu__item';

	return $classes;
}

add_action( "acf/init", "register_settings_page" );
/**
* Create settings page acf
**/ 
function register_settings_page() {
	if (function_exists('acf_add_options_page')) {
		$option_page = acf_add_options_page(array(
			'page_title' => 'Theme settings',
			'menu_title' => 'Theme settings',
			'menu_slug' => 'theme-general-settings',
			'capability' => 'edit_posts',
			'redirect' => false,
			'position' => '76',
			'post_id' => 'theme-general-settings',
		));
	}
}

// acf api key
function my_acf_google_map_api( $api ){
	$api['key'] = 'AIzaSyAOQlByLnQ-dSIiIN3gjMZ2E7QSsauhHx4';
	return $api;	
}

add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');