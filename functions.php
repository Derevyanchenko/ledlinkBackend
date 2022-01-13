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

// #####################################################################
// wooocommerce

if ( ! function_exists( 'is_woocommerce' ) ) {
	return;
}
// remove basic woo styles
if ( ! is_cart() || ! is_checkout() ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
}

remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

// archive product page
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// remove divs for main content
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

// content product
add_action( 'woocommerce_before_shop_loop_item_title', 'ecommerce_archive_product_img_wrap_start', 5 );
function ecommerce_archive_product_img_wrap_start() {
	echo '<div class="product__img-wrapper">';
}

add_action( 'woocommerce_before_shop_loop_item_title', 'ecommerce_archive_product_img_wrap_end', 15 );
function ecommerce_archive_product_img_wrap_end() {
	echo '</div>';
}

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);


// remove sidebar
add_action('woocommerce_before_main_content', 'remove_sidebar' );
function remove_sidebar() {
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
}

// woocommerce_no_products_found

add_action( 'woocommerce_no_products_found', 'ecommerce_woocommerce_no_products_found_wrapper_start', 5 );
function ecommerce_woocommerce_no_products_found_wrapper_start() {
	echo '<div class="woo-not-found">';
}

add_action( 'woocommerce_no_products_found', 'ecommerce_woocommerce_no_products_found_wrapper_end', 15 );
function ecommerce_woocommerce_no_products_found_wrapper_end() {
	echo '</div>';
}

// #####################################################################################################3
// single product
// start wrapper
add_action( 'woocommerce_before_single_product', 'ecommerce_single_product_wrapper_start',  15 );
function ecommerce_single_product_wrapper_start() {
	?>
	<section class="section color-black">
		<div class="container shopPage-container">
	<?php
}

// content
add_action( 'woocommerce_before_single_product', 'ecommerce_single_product_main_title',  20 );
function ecommerce_single_product_main_title() {
	?> 
	<div class="woocommerce-products-header">
		<h1 class="woocommerce-products-header__title page-title dir-ltr"><?php the_title(); ?></h1>
	</div>
	<?php
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

// repeater
add_action( 'woocommerce_single_product_summary', 'woocommerce_single_product_summary_repeater_wrapper_start', 1);
function woocommerce_single_product_summary_repeater_wrapper_start() {
	echo '<div class="woocommerce-product-details__short-description dir-ltr">';
}

add_action( 'woocommerce_single_product_summary', 'woocommerce_single_product_summary_repeater_content' , 2);
function woocommerce_single_product_summary_repeater_content() {
	?>
		<?php the_content(); ?>
		<br>
		<br>

	<?php
		$bullet_points = get_field( 'bullet_points' );
		if ( ! empty( $bullet_points ) ) {
			echo '<ul>';
			foreach ( $bullet_points as $bullet_point ) {
				echo '<li>' . $bullet_point['text'] . '</li>';
			}
			echo '</ul>';
		}
}

add_action( 'woocommerce_single_product_summary', 'woocommerce_single_product_summary_repeater_wrapper_end' , 3);
function woocommerce_single_product_summary_repeater_wrapper_end() {
	echo '</div>';
}

// end wrapper
add_action( 'woocommerce_after_single_product', 'ecommerce_single_product_wrapper_end',  5 );
function ecommerce_single_product_wrapper_end() {
	?>
		</section>
	</div>
	<?php
}

add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
  function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}