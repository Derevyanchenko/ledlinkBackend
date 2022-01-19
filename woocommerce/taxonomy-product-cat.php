<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


// wc_get_template( 'archive-product.php' );


if ( is_product_category() ) {
	global $wp_query;
	$main_term = $wp_query->get_queried_object();
	$cat_id = $main_term->term_id;
	$cat_name = $main_term->name;

	$taxonomy  = 'product_cat';
	$child_ids = get_term_children( $cat_id, $taxonomy );

	if ( ! empty( $child_ids ) ) {

	get_header( 'shop' );

	/**
	 * Hook: woocommerce_before_main_content.
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 * @hooked WC_Structured_Data::generate_website_data() - 30
	 */
	do_action( 'woocommerce_before_main_content' );
?>

<section class="section brands ">
	<div class="container shopPage-container brands-container">
	    <div class="brands-title">
			<h2><?php echo $cat_name; ?></h2>
		</div>
		<?php
				echo '<div class="brands__wrapper">';
				foreach ( $child_ids as $child_id ) {
					if( $child_id != $main_term->term_id ) {

						$term = get_term_by( 'id', $child_id, $taxonomy );
						$thumb_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
						$term_img = wp_get_attachment_url(  $thumb_id );
					?>
						<div class="brands__col">
							<a href="<?php echo get_term_link( $child_id, $taxonomy ); ?>" class="brands__item">
								<p class="brands__item-title"><?php echo $term->name; ?></p>
								<?php if ( ! empty( $term_img ) ) : ?>
									<div class="brands__item-img">
										<img src="<?php echo $term_img; ?>" alt="img">
									</div>
								<?php endif; ?>
							</a>
						</div>
						<!-- brands__col -->
					<?php
					}
				}
				echo '</div>';
		?>
	</div>
</section>

<?php
	/**
	 * Hook: woocommerce_after_main_content.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );

	/**
	 * Hook: woocommerce_sidebar.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action( 'woocommerce_sidebar' );

	get_footer( 'shop' );

	} else {
		// echo '<h1>element dont have childrens. Its "else"</h1>';
		// if ( is_product_category() ) { 
		// 	echo '<h1>Category page</h1>';
		// 	echo  wc_get_loop_prop( 'total' );
		// }
		wc_get_template( 'archive-product.php' );
	}

}
?>